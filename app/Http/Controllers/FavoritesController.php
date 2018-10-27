<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class FavoritesController extends Controller
{
    public function __construct() {
        # De dam bao rang co user dang login
        $this->middleware('auth');
    }

    public function store(Question $question) {
        $question->favorites()->attach(auth()->id());

        return back();
    }

    public function destroy(Question $question) {
        $question->favorites()->detach(auth()->id());

        return back();
    }
}
