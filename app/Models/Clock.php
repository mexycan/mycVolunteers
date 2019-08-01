<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clocks';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function coordinator(){
        return $this->belongsTo('App\User', 'coordinator_id');
    }

    public function area(){
        return $this->hasOne('App\Models\Area');
    }

    public function clock(){
        return $this->belongsTo('App\Models\Ticket');
    }
}