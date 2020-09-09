<?php

namespace App\Http\Controllers\Api;

use App\Storage;
use App\Http\Resources\Storage\StorageResource;
use App\Http\Resources\Storage\StorageCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Auth;
use App\Exceptions\NotBelongsToUser;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('storages', 'storage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storages()
    {
        return StorageCollection::collection(Storage::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|string',
            'location' => 'required|string',
            'description'     => 'required|string',
            'capacity'  => 'required|integer',
            'availableCapacity'    => 'required|integer',
        ]);  

        $storage = new Storage;
        $storage->name = $request->name;
        $storage->location = $request->location;
        $storage->description = $request->description;
        $storage->capacity = $request->capacity;
        $storage->available_capacity = $request->availableCapacity;
        $storage->user_id =  Auth::user()->id;
        $storage->save();

        return $this->createdResponse(true, 'Storage saved successful', Response::HTTP_CREATED);

    }

    public function storage(Storage $storage)
    {
        return new StorageResource($storage);
    }

    public function update(Request $request, Storage $storage)
    {
        $this->validate($request, [
            'name'  => 'required|string',
            'location' => 'required|string',
            'description'     => 'required|string',
            'capacity'  => 'required|integer',
            'availableCapacity'    => 'required|integer',
        ]);

        $this->storageUserCheck($storage->user_id);  

        // change availableCapacity(client request) to available_capacity(field name) and remove client  requested field name
        $request['available_capacity'] = $request->availableCapacity;
        unset($request['availableCapacity']);
        $storage->update($request->all());
        return $this->createdResponse(true, 'Storage updated successful', Response::HTTP_CREATED);
    }

    public function delete(Storage $storage)
    {
        $this->storageUserCheck($storage->user_id);
        $storage->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    // check if storage is for user
    public function storageUserCheck($user_id){
        if(Auth::user()->id !== $user_id){
            throw new NotBelongsToUser;
        }
    }

    // created responses
    public function createdResponse($status, $message, $code){
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }


   
}
