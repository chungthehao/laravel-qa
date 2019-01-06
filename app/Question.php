<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date', 'is_favorited', 'favorites_count', 'body_html']; // Để khi có model instance là có luôn accessor

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'question_id', 'id')
                    ->orderBy('votes_count', 'desc');
        # Chú thích cho cách 2 ở RouteServiceProvider.php
        // BẤT CỨ KHI NÀO gọi $question->answers, kết quả trả về các answer record sẽ sắp
        // xếp theo thứ tự votes_count giảm dần.
    }

    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites', 'question_id', 'user_id')
                    ->withTimestamps(); // Khi attach, se co luon created_at va updated_at
    }

    public function isFavorited() {
        // Lay id cua user dang login: auth()->id()
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function acceptBestAnswer(Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    # Cách làm sạch dữ liệu body trước khi lưu vào database
//    public function setBodyAttribute($value) {
//        $this->attributes['body'] = clean($value);
//    }

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
        // Làm sạch dữ liệu body trước khi render ra view
        // (dù cho ở database nó ko sạch)
        return clean($this->bodyHtml());
    }

    public function getIsFavoritedAttribute() {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute() {
        return $this->favorites->count();
    }

    public function getExcerptAttribute() {
        return $this->excerpt(250);
    }

    public function excerpt($length) {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml() {
        return \Parsedown::instance()->text($this->body);
    }

}
