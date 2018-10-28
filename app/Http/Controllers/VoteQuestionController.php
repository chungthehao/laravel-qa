<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function __invoke(Question $question) {
        $vote = (int) request()->vote;

        // auth()->user() get current login user instance
        auth()->user()->voteTheQuestion($question, $vote);

        return back();
    }
}
