<?php

namespace App\Http\Controllers\Api;

use App\Storage;
use App\Http\Resources\Storage\StorageResource;
use App\Http\Resources\Storage\StorageCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storages()
    {
        return StorageCollection::collection(Storage::all());
    }

    public function storage(Storage $storage)
    {
        return new StorageResource($storage);
    }

   
}
