<?php

namespace App\Http\Controllers;

use App\Server;
use App\Http\Requests\ServerFormRequest;
use App\Services\AutomaticServerCreator;
use Illuminate\Http\Request;

class ServersController extends Controller
{
    public function index(Request $request){
        $servers = Server::query()->orderBy('name', 'asc')->paginate(10);
        $succesful = $request->session()->get('succesful');
        $error = $request->session()->get('error');
        
        return view('servers.index', compact('servers', 'succesful', 'error'));
    }
    
    public function create(){
        return view('servers.create');
    }
    
    public function store(Request $request, AutomaticServerCreator $creator){
        
        if (!empty($addedServers = $creator->getAllServersNames())){
        
            $request->session()
                ->flash(
                'succesful', 
                "Servers: ".implode(", ",$addedServers)." were succesfuly added!"
            );
        }else{
          $request->session()
                ->flash(
                'error', 
                "All servers were already added!"
            );  
        }
        return redirect()->route('servers_list');
    }
    
    public function destroy(Request $request){
        
        Server::destroy($request->id);
        $request->session()
            ->flash(
            'succesful', 
            "Server succesfuly removed!"
        );
        return redirect()->route('servers_list');
    }
}
