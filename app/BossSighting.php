<?php

namespace App;

use App\{Boss,Server};
use Illuminate\Database\Eloquent\Model;

class BossSighting extends Model
{
    protected $table = 'sightings';
    public $timestamps = true;
    protected $fillable = ['boss_id', 'server_id'];
    
    public function boss(){
        return $this->belongsTo(Boss::class);
    }    
    public function server(){
        return $this->belongsTo(Server::class);
    }
}
