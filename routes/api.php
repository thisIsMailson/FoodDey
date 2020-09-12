<?php

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;
use App\Employee;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['auth:api']], function() {

    // THE ENDPOINTS GOES HERE

});

// users requests
Route::get('users', 'Api\UserController@users');
Route::get('user', 'Api\UserController@user');

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

// storage requests
Route::get('storages', 'Api\StorageController@storages')->name('storage.all');
Route::post('storages', 'Api\StorageController@store')->name('storage.store');
Route::get('storages/{storage}', 'Api\StorageController@storage')->name('storage.show');
Route::post('storages/{storage}/edit', 'Api\StorageController@update')->name('storage.update');
Route::delete('storages/{storage}/delete', 'Api\StorageController@delete')->name('storage.delete');

// book storage requests
Route::get('bookStorageRequest', 'Api\BookStorageRequestController@userStorageRequests')->name('bookStorageRequest.all');
Route::post('bookStorageRequest', 'Api\BookStorageRequestController@store')->name('bookStorageRequest.store');
Route::post('bookStorageRequest/{bookStorageRequest}/edit', 'Api\BookStorageRequestController@update')->name('bookStorageRequest.update');
Route::delete('bookStorageRequest/{bookStorageRequest}/delete', 'Api\BookStorageRequestController@delete')->name('bookStorageRequest.delete');
