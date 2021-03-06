<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

        // $answer->question: 1 instance của Question
        // acceptBestAnswer method nằm trong Question class
        $answer->question->acceptBestAnswer($answer);

        return response()->json([
            'message' => 'You have just accepted this answer as best answer!'
        ]);
    }
}
