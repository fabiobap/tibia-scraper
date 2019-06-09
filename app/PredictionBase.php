<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PredictionBase extends Model
{
    
    protected $table = 'predictionsbase';
    public $timestamps = false;
    protected $fillable = ['boss_id', 'minDays', 'avgDays', 'maxDays'];
    
    public function boss(){
        return $this->belongsTo(Boss::class);
    }    
}
