<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function coordinator(){
        return $this->belongsTo('App\User', 'coordinator_id');
    }

    public function clock(){
        return $this->hasMany('App\Models\Clock');
    }

}