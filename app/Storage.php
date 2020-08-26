<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{

    public function owner() {

        return $this->belongsTo('App\User');

    }
}