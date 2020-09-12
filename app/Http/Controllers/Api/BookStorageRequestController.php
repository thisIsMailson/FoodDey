<?php

namespace App\Http\Controllers\Api;

use App\BookStorageRequest;
use App\Exceptions\NotUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookStorageRequestController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userStorageRequests(Request $request)
    {
        $usersBookReq = BookStorageRequest::all();
        return response(['status' => true, 'bookRequests' => $usersBookReq]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'price'  => 'required|double',
            'storage_id' => 'required|integer'
        ]);

        $bookStorageReq = new BookStorageRequest();
        $bookStorageReq->price = $request->price;
        $bookStorageReq->storage_id = $request->storage_id;
        $bookStorageReq->user_id =  Auth::user()->id;

        $bookStorageReq->save();

        return $this->createdResponse(true, 'Storage Book Request saved successful', Response::HTTP_CREATED);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookStorageRequestController $bookStorageReq)
    {
        $this->validate($request, [
            'price' => 'required|double',
        ]);

        $bookStorageReq->update($request->all());
        return $this->createdResponse(true, 'Storage Book Request updated successful', Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookStorageRequestController $bookStorageReq)
    {
        $this->storageUserCheck($bookStorageReq->user_id);
        $bookStorageReq->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    // check if storage is for user
    public function storageRequestUserCheck($user_id){
        if(Auth::user()->id !== $user_id){
            throw new NotUsersRequest();
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
