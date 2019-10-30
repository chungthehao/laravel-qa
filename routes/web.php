<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::view('{any}', 'spa')->where('any', '.*');

Route::get('/', 'QuestionsController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');
Route::get('questions/{question}-{slug}', 'QuestionsController@show')->name('questions.show');

//Route::post('questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::resource('questions.answers', 'AnswersController')->except(['create', 'show']);

// Single action controller, không cần chỉ ra action nào cụ thể, vì chỉ có 1
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('questions/{question}/vote', 'VoteQuestionController');
Route::post('answers/{answer}/vote', 'VoteAnswerController');

Route::get('test/query', function (\Illuminate\Http\Request $request) {
    return $request->query('q');
    // Access: http://127.0.0.1:8000/test/query?q[]=1&q[]=8
    // Result: ["1","8"]
});