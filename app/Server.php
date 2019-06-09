<?php

namespace App;

use App\BossSighting;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    
    public function bossSighting(){
        return $this->hasMany(BossSighting::class);
    }
}
