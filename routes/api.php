<?php

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

// API
Route::namespace('Api')->group(function() {
    // Products
    Route::prefix('products')->group(function() {
        Route::get('/', 'ProductController@index');    
        Route::get('/{id}', 'ProductController@show');
        Route::post('/', 'ProductController@save')->middleware('auth.basic');
        Route::put('/', 'ProductController@update');
        Route::delete('/{id}', 'ProductController@delete');
    });
    
    // Users
    Route::resource('/users', 'UserController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/teste', function(Request $request) {
    //dd($request);
    $response = new Response(json_encode(['msg' => 'Esta é uma rota de teste da api laravel']));
    $response->header('Content-type', 'application/json');
    return $response;
    //return ['msg' => 'Esta é uma rota de teste da api laravel'];
});