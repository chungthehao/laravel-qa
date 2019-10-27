<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question) {
        $vote = (int) request()->vote;

        // auth()->user() get current login user instance
        $votesCount = auth()->user()->voteTheQuestion($question, $vote);

        return response()->json([
            'message'       => 'Thanks for the feedback!',
            'votesCount'    => $votesCount
        ]);
    }
}
