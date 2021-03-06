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

// Authentication routes
Route::post('register', 'Api\Auth\RegisterController');
Route::post('login', 'Api\Auth\LoginController@store');
Route::delete('logout', 'Api\Auth\LoginController@destroy')->middleware('auth:api'); // Đã login mới logout chứ


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

    // Single action controller, không cần chỉ ra action nào cụ thể, vì chỉ có 1
    Route::post('/answers/{answer}/accept', 'Api\AcceptAnswerController');

    Route::post('questions/{question}/favorites', 'Api\FavoritesController@store');
    Route::delete('questions/{question}/favorites', 'Api\FavoritesController@destroy');

    Route::get('my-posts', 'Api\MyPostsController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
