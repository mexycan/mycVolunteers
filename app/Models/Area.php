<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';

    public function user(){
        return $this->belongsTo('App\user');
    }

    public function clock(){
        return $this->hasMany('App\Models\Clock');
    }
}