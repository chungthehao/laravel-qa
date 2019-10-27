<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Answer;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer) {
        $vote = request()->vote;

        $votesCount = auth()->user()->voteTheAnswer($answer, $vote);

        return response()->json([
            'message'       => 'Thanks for the feedback!',
            'votesCount'    => $votesCount
        ]);
    }
}
