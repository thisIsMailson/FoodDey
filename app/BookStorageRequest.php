<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookStorageRequest extends Model
{
    protected $table = 'book_storage_requests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'storage_id', 'price', 'is_confirmed',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function storage() {
        return $this->belongsTo('App\Storage', 'storage_id');
    }

    public function isConfirmed()
    {
        return ($this->is_confirmed)? true:false;
    }
}
