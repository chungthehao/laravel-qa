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
Route::get('/questions/{question}/answers', 'Api\AnswersController@index');
Route::get('/questions/{question}-{slug}', 'Api\QuestionDetailsController');
Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('/questions', 'Api\QuestionsController')
        ->only(['show', 'store', 'update', 'destroy']);
    Route::apiResource('/questions.answers', 'Api\AnswersController')
        ->only(['store', 'update', 'destroy']);
    Route::post('questions/{question}/vote', 'Api\VoteQuestionController');
    Route::post('answers/{answer}/vote', 'Api\VoteAnswerController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
