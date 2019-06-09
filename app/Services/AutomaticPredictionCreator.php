<?php

namespace App\Services;

use App\{Server, Boss, BossSighting, Prediction, PredictionBase};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AutomaticPredictionCreator
{
    
    public function createPrediction($baseStats, $servers){
        try {
           DB::beginTransaction();
            foreach($baseStats as $stats){
                foreach($servers as $server){
                    $where = ["boss_id"=>$stats->boss_id, 
                              "server_id"=>$server->id];
                    $predictions = Prediction::where($where)->take(1)->get();
                    if((!count($predictions)>0)){
                        Prediction::create([
                            "server_id" => $server->id,
                            "boss_id" => $stats->boss_id,
                            "sighting_id" => null,
                            "minDays" =>$stats->minDays,
                            "avgDays" =>$stats->avgDays,
                            "maxDays" =>$stats->maxDays,
                            "nextSighting" =>null,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function updatePrediction($predictions, $sightings){
         DB::beginTransaction();
            foreach($predictions as $prediction){
                foreach($sightings as $sighting){
                    if (($prediction->boss_id == $sighting->boss_id)&&($prediction->server_id == $sighting->server_id) ){
                   $nextSighting = DB::table("sightings")
                        ->selectRaw("(DATE_ADD((SELECT sightings.updated_at WHERE sightings.id = :sightingId), INTERVAL :avgDays DAY)) as nextSighting", 
                        ["sightingId" => $sighting->id, 
                            "avgDays" => $prediction->avgDays
                        ])->distinct()->take(2)->get();
            
                        $cleanNextSighting = $nextSighting
                            ->reject(function ($user) { 
                                return $user->nextSighting === null;
                            })
                            ->map(function ($user) {
                                return $user->nextSighting;
                            });
                        $predictionUpdate = Prediction::find($prediction->id);

                        $predictionUpdate->sighting_id = $sighting->id;
                        $predictionUpdate->nextSighting = $cleanNextSighting->first();

                        $predictionUpdate->save();
                        }
                    }
            }
            DB::commit();
    }
    
}