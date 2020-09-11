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

Route::get('users', 'Api\UserController@users');
Route::get('user', 'Api\UserController@user');

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::prefix('storages')->group(function () {
    Route::get('/', 'Api\StorageController@storages')->name('storage.all');
    Route::post('/', 'Api\StorageController@store')->name('storage.store');
    Route::get('/{storage}', 'Api\StorageController@storage')->name('storage.show');
    Route::post('/{storage}/edit', 'Api\StorageController@update')->name('storage.update');
    Route::delete('/{storage}/delete', 'Api\StorageController@delete')->name('storage.delete');

    Route::post('/prices/{storagePrice}/edit', 'Api\StoragePriceController@update')->name('storage.price_edit');
});
