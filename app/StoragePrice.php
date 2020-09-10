<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoragePrice extends Model
{
    protected $table = 'storage_prices';
    protected $primaryKey = 'id';

    protected $fillable = [
        'price', 'storage_id',
    ];

    public function storage()
    {
        return $this->belongsTo('App\Storage', 'storage_id');
    }

}
