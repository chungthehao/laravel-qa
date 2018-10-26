<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
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

        $question->answers()->create(
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

        return back()->with('success', 'Your answer has been submitted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
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

        return redirect()
            ->route('questions.show', [$question->slug])
            ->with('success', 'Your answer has been modified successfully!');
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

        return back()->with('success', 'Your answer has been removed!');
    }
}
