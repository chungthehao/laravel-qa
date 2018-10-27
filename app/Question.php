<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    # Định nghĩa Accessor
    // Khi đâu đó lấy thuộc tính url của đối tượng question
    // thì sẽ trả về link tới màn hình show của question đó
    public function getUrlAttribute() {
        return route("questions.show", $this->slug);
    }

    // Mặc dù đn là CreatedDate nhưng lúc truy xuất thì chỉ
    // cần ->created_date
    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute() {
        if ($this->answers_count == 0) {
            return 'unanswered';
        }
        if ($this->best_answer_id) {
            return 'answered-accepted';
        }
        return 'answered';
    }

    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }

    public function acceptBestAnswer(Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}
