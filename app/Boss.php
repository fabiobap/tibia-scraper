<?php

namespace App;

use App\BossSighting;
use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    protected $table = 'bosses';
    public $timestamps = false;
    protected $fillable = ['name', 'image'];
    
    public function bossSightings(){
        return $this->hasMany(BossSighting::class);
    }
}
