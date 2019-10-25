<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\QuestionDetailsResource;
use App\Question;
use App\Http\Controllers\Controller;

class QuestionDetailsController extends Controller
{

    public function __invoke(Question $question)
    {
        $question->increment('views');

        return new QuestionDetailsResource($question);
    }
}
