<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # Xem cách mà laravel thực hiện câu truy vấn khi mình gọi:
        # Question::latest()->paginate(5);
        # và $question->user->url, name ở view
        # cho thấy vấn đề truy vấn N+1 (lazy loading), và giải pháp
        # eager loading.
        /*\DB::enableQueryLog();

        $questions = Question::with('user')->latest()->paginate(5);

        view('questions.index', compact('questions'))->render();

        dd(\DB::getQueryLog());*/

        //-----------------------------------------------------

        $questions = Question::with('user')->latest()->paginate(5);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question(); // Chỉ để có thể dùng chung _form.blade.php với edit

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        // $request->user(): Get the user making the request. (laravel có sẵn, Ctrl + Click để xem thêm)
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        /* Cập nhật lượt views */
        # Cách 1
        // $question->views = $question->views + 1;
        // $question->save();
        # Cách 2
        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question) // Route Model Binding
    {
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', 'Your question has been modified.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Your question has been removed.');
    }
}
