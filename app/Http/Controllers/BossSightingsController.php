<?php

namespace App\Http\Controllers;

use App\{Boss, Server, BossSighting};
use App\Services\AutomaticBossSightingCreator;
use Illuminate\Http\Request;

class BossSightingsController extends Controller
{
    public function index(Request $request){
        
        $sightings = BossSighting::query()->orderBy('created_at', 'asc')->paginate(5);
        $message = $request->session()->get('message');
        
        return view('boss_sightings.index', compact('sightings', 'message'));
    }
    
    public function store(Request $request, AutomaticBossSightingCreator $creator){
        
        $allBossesNames = [];
        $allServersNames = [];
        
        $bosses = Boss::all();
        $servers = Server::all();
        
        foreach($bosses as $boss){
            $allBossesNames[$boss->id] = $boss->name;
        }
        
        foreach($servers as $server){
            $allServersNames[$server->id] = $server->name;
        }
       
        $creator->getAllBossesFromWebsite($allServersNames, $allBossesNames);
        
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly added!"
        );
        return redirect()->route('boss_sightings_list');
    }
    
    public function destroy(Request $request){
        
        BossSighting::destroy($request->id);
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly removed!"
        );
        return redirect()->route('boss_sightings_list');
    }
}
