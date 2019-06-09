<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\{Boss,Server, BossSighting};

class Prediction extends Model
{
    protected $table = 'predictions';
    public $timestamps = true;
    protected $fillable = ['boss_id', 'server_id', 'sighting_id', 'minDays', 'avgDays', 'maxDays', 'nextSighting'];
    
    public function boss(){
        return $this->belongsTo(Boss::class);
    }    
    public function server(){
        return $this->belongsTo(Server::class);
    }    
    public function sighting(){
        return $this->belongsTo(BossSighting::class);
    }
}
