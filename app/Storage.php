<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storages';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'location', 'description', 'capacity', 'available_capacity', 'is_available', 'user_id',
    ];


    public function owner() 
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
