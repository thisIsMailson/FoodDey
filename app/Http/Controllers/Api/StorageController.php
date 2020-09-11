<?php

namespace App\Http\Controllers\Api;

use App\Storage;
use App\StoragePrice;
use App\Http\Resources\Storage\StorageResource;
use App\Http\Resources\Storage\StorageCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Exceptions\NotBelongsToUser;
use App\Http\Messages\ResponseMessageTrait;

class StorageController extends Controller
{
    use ResponseMessageTrait;

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
            'price'    => 'required|numeric',
            'currency'    => 'required|string',
        ]);  

        try{
            DB::beginTransaction();
            $storage = new Storage;
            $storage->name = $request->name;
            $storage->location = $request->location;
            $storage->description = $request->description;
            $storage->capacity = $request->capacity;
            $storage->available_capacity = $request->availableCapacity;
            $storage->user_id =  Auth::user()->id;
            $storage->save();

            // save storage price with storage through one endpoint
            $storagePrice = new StoragePrice();
            $storagePrice->price = $request->price;
            $storagePrice->currency = $request->currency;
            $storagePrice->storage_id = $storage->id;
            $storagePrice->save();
            DB::commit();
            return $this->apiReponse(true, 'Storage saved successful', Response::HTTP_CREATED);
        }catch(\Exception $e){
            DB::rollback();
            return $this->apiReponse(false, 'Error saving storage', Response::HTTP_OK);
        }
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
        return $this->apiReponse(true, 'Storage updated successful', Response::HTTP_CREATED);
    }

    public function delete(Storage $storage)
    {
        $this->storageUserCheck($storage->user_id);
        $storage->delete();
        return $this->apiReponse(true, 'Storage deleted successful', Response::HTTP_OK);
    }


    // check if storage is for user
    public function storageUserCheck($user_id){
        if(Auth::user()->id !== $user_id){
            throw new NotBelongsToUser;
        }
    }



   
}
