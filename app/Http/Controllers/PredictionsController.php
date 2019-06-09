<?php

namespace App\Http\Controllers;

use App\{Boss, Server, BossSighting, PredictionBase, Prediction};
use App\Services\AutomaticPredictionCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredictionsController extends Controller
{
    public function index(Request $request){
        
        $predictions = Prediction::query()->orderBy('created_at', 'asc')->paginate(5);
        
        $message = $request->session()->get('message');
        
        return view('predictions.index', compact('predictions', 'message'));
    }
    
    public function store(Request $request, AutomaticPredictionCreator $creator){
        
        $servers = Server::all();
        $baseStats = PredictionBase::all();
        
        $creator->createPrediction($baseStats, $servers);
        
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly added!"
        );
        return redirect()->route('predictions_list');
        
    }
    
    public function update(Request $request, AutomaticPredictionCreator $creator){
        
       $predictions = Prediction::all();
        $sightings = BossSighting::all();
        
        $creator->updatePrediction($predictions, $sightings);
        
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly added!"
        );
        return redirect()->route('predictions_list');
    }
    public function destroy(Request $request){
        
        Prediction::destroy($request->id);
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly removed!"
        );
        return redirect()->route('predictions_list');
    }
}
