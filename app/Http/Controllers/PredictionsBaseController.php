<?php

namespace App\Http\Controllers;

use App\{Boss, PredictionBase};
use Illuminate\Http\Request;

class PredictionsBaseController extends Controller
{

    public function index(Request $request){
        
        $predictions = PredictionBase::query()->orderBy('id', 'asc')->paginate(5);
        $message = $request->session()->get('message');
        
        return view('prediction_base.index', compact('predictions', 'message'));
    }
    
    public function create(){
        $bosses = Boss::orderBy('name','asc')->get();
        
        return view('prediction_base.create', compact('bosses'));
    }
    
    public function store(Request $request){
        
        $boss = PredictionBase::create([
            'boss_id'=>$request->boss_id,
            'minDays'=>$request->minDays,
            'avgDays'=>$request->avgDays,
            'maxDays'=>$request->maxDays
        ]);
        
        $request->session()
            ->flash(
            'message', 
            "The base stats was succesfuly added!"
        );
        return redirect()->route('base_list');
    }
    
    public function destroy(Request $request){
        
        PredictionBase::destroy($request->id);
        $request->session()
            ->flash(
            'message', 
            "The sighting was succesfuly removed!"
        );
        return redirect()->route('base_list');
    }
}
