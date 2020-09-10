<?php

namespace App\Http\Controllers\Api;

use App\storagePrice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoragePriceControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $storagePrice = new StoragePrice();
        $storagePrice->name = $request->name;
        $storagePrice->storage_id = $request->storage_id;

        if ($storagePrice->save()) return $this->createdResponse(true, 'Storage price saved successful', Response::HTTP_CREATED);
        return $this->createdResponse(false, 'Error saving price', Response::HTTP_SERVICE_UNAVAILABLE);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, StoragePrice $storagePrice)
    {
        $this->validate($request, [
            'name'  => 'required|string',
        ]);
        $storagePrice->update($request->all());

        return $this->createdResponse(true, 'Storage updated successful', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // created responses
    public function createdResponse($status, $message, $code){
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }

}
