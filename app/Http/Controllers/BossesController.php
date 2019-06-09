<?php

namespace App\Http\Controllers;

use App\Boss;
use App\Services\BossFileUploader;
use Illuminate\Http\Request;

class BossesController extends Controller
{
  public function index(Request $request){
        $bosses = Boss::query()->orderBy('name', 'asc')->paginate(5);
        $message = $request->session()->get('message');
        
        return view('bosses.index', compact('bosses', 'message'));
    }
    
    public function create(){
        return view('bosses.create');
    }
    
    public function store(Request $request, BossFileUploader $uploader){

        $uploader->upload($request);

        $request->session()
            ->flash(
            'message', 
            "Boss {$request->name} succesfuly added!"
        );
        
        return redirect()->route('bosses_list');
    }
    
    public function destroy(Request $request){
        
        Boss::destroy($request->id);
        $request->session()
            ->flash(
            'message', 
            "Boss succesfuly removed!"
        );
        return redirect()->route('bosses_list');
    }
}
