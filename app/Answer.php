<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public function question() {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }
}
