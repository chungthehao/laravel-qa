<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{
    public function store(Question $question) {
        $question->favorites()->attach(auth()->id());

        return response()->json(null, 204); // 204: successfully but no content to return
    }

    public function destroy(Question $question) {
        $question->favorites()->detach(auth()->id());

        return response()->json(null, 204); // 204: successfully but no content to return
    }
}
