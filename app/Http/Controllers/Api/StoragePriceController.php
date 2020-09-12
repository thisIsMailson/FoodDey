
<?php

namespace App\Http\Controllers\Api;

use App\StoragePrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Messages\ResponseMessageTrait;
use App\Exceptions\NotBelongsToUser;
use Illuminate\Http\Response;
use Auth;

class StoragePriceController extends Controller
{
    use ResponseMessageTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // check if storage is for user
    public function userCheck($user_id){
        if(Auth::user()->id !== $user_id){
            throw new NotBelongsToUser;
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'price'  => 'required|numeric',
            'currency'  => 'required|string',
            'storageID'  => 'required|integer',
        ]);

        $storagePrice = new StoragePrice();
        $storagePrice->price = $request->price;
        $storagePrice->currency = $request->currency;
        $storagePrice->storage_id = $request->storageID;

        if ($storagePrice->save()) return $this->apiReponse(true, 'Storage price saved successful', Response::HTTP_CREATED);
        return $this->apiReponse(false, 'Error saving price', Response::HTTP_SERVICE_UNAVAILABLE);

    }

    public function update(Request $request, StoragePrice $storagePrice)
    {
        $this->validate($request, [
            'price'  => 'required|numeric',
        ]);
        $this->userCheck($storagePrice->storage->user_id);
        $storagePrice->update($request->all());

        return $this->apiReponse(true, 'Storage price updated successful', Response::HTTP_CREATED);
    }
}
