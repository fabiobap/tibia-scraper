<?php

namespace App\Services;

use App\{Server, Boss, BossSighting};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AutomaticBossSightingCreator
{
    
    public function getAllBossesFromWebsite($servers, $bosses){
        $listOfSightings = [];
        
        foreach($servers as $server){
            $bossesFromWebsite = $this->scrapeWebsite($server);
            $bossesIntersect = array_intersect($bossesFromWebsite, $bosses);
            if (!empty($bossesIntersect)){
                foreach($bossesIntersect as $bossName){
                    $boss_id = array_search($bossName, $bosses);
                    $server_id = array_search($server, $servers);
                    $listOfSightings[] = ["server_id"=>$server_id, "boss_id"=>$boss_id];
                }
            }
        }
        $this->createSightingRecord($listOfSightings);        
    }
    
    private function scrapeWebsite($serverName){
        
        /**dom**/
        $dom = new \DOMDocument();
        libxml_use_internal_errors( 1 );
        
        $data = file_get_contents( 'https://www.tibia.com/community/?subtopic=killstatistics&world='.$serverName );
        //replace blank code
        $data = str_replace( '&#160;', '', $data );
        
        $dom->loadHTML( $data );
        $dom->formatOutput = True;
        
        //retriving the correct table
        $table = $dom->getElementsByTagName( 'table' )->item(4);
        
        //saving in html / "converting" to SimpleXmlElement
        $xml = '<?xml version="1.0" encoding="utf-8" ?>'.$dom->saveHTML( $table );
        $xml = new \SimpleXmlElement( $xml );
        /** END dom **/
        
           //empty array
        $bossesFromWebsite = array();

        /**
        iterate over the tr tag, 
        td[0] is the name, 
        td[1] are the players death
        td[2] is the boss death
        **/
        foreach($xml->tr as $tr){

            $name = $tr->td[0];

            if(isset($name)){

                $name = trim($name);
                $killedPlayers = $tr->td[1];
                $killedByPlayers = $tr->td[2];
            }

            if($killedPlayers > 0 || $killedByPlayers > 0){

                $bossesFromWebsite[] = strval($name);
            }
        }
        return $bossesFromWebsite;
    }
    
    private function createSightingRecord(array $sightings){
        try {
            DB::beginTransaction();
            foreach($sightings as $sighting){
                BossSighting::create([
                    "server_id" => $sighting["server_id"],
                    "boss_id" => $sighting["boss_id"]
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}