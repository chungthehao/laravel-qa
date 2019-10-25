<?php

use Illuminate\Http\Request;

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

Route::post('token', 'Auth\LoginController@getToken');

Route::get('/questions', 'Api\QuestionsController@index');

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('/questions', 'Api\QuestionsController')
        ->only(['show', 'store', 'update', 'destroy']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
