<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    public function index(Question $question)
    {
        // Eager loading user của mỗi answer (method user() trong Answer model)
        $answers = $question->answers()->with('user');

        // Ý tưởng là loại bỏ những cái đc thêm mới single page ở phía client side TRƯỚC khi paginate
        if (request()->has('excludes')) {
            $answers->whereNotIn('id', request()->query('excludes'));
        }

        return AnswerResource::collection($answers->simplePaginate(3));
        //return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        // Bỏ vô trong create luôn
        /*$request->validate([
            'body' =>'required'
        ]);*/

        $newAnswer = $question->answers()->create(
            $request->validate([
                'body' =>'required'
            ])
//            , // Dùng toán tử + luôn
            +
            [
//                'body'      => $request->body, // Dùng cách mới thì bỏ cái này (ở trên có rồi)
                'user_id'   => \Auth::id()
            ]
        );

        return response()->json([
            'message' => 'Your answer has been submitted successfully!',
            'answer' => new AnswerResource($newAnswer->load('user'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update(
            $request->validate([
                'body' => 'required'
            ])
        );

        return response()->json([
            'message'   => 'Your answer has been modified successfully!',
            'body_html' => $answer->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    # Tham số thứ 1: Question $question, không cần dùng đến
    // vẫn để
    // theo cái route thôi, xem lại bằng cách chạy
    // php artisan route:list --name=questions.answers.destroy
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json([
            'message' => 'Your answer has been removed!'
        ]);
    }
}
