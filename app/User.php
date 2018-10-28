<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions() {
        return $this->hasMany(Question::class, 'user_id', 'id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public function favorites() {
        return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id')
                    ->withTimestamps(); // Khi attach, se co luon created_at va updated_at
    }

    public function voteQuestions() {
        return $this->morphedByMany(
            Question::class,
            'votable'
        )->withTimestamps()->withPivot('vote');
    }

    public function voteAnswers() {
        return $this->morphedByMany(
            Answer::class,
            'votable'
        )->withTimestamps()->withPivot('vote');
    }

    public function voteTheQuestion(Question $question, $vote) {
        $voteQuestions = $this->voteQuestions();

        # Tao / Cap nhat vao bang pivot
        if ($voteQuestions->where('votable_id', $question->id)->exists()) {
            $voteQuestions->updateExistingPivot($question->id, ['vote' => $vote]);
        } else {
            $voteQuestions->attach($question->id, ['vote' => $vote]);
        }

        /* Cap nhat so vote (votes_count trong bang questions) */
        # Cach 1: Chi dung khi bang questions votes_count=0
        // Tuc la du lieu ban dau phai chinh xac thi cach nay moi dung, vi
        // no dua tren du lieu cu, roi tang hoac giam di 1
//        $question->votes_count = $question->votes_count + $vote;
//        $question->save();

        # Cach 2: Luon dung
        // Do luc nao cung truy van kiem tra trong bang pivot roi cap nhat lai
        // vao bang questions, chu khong dua vao gia tri cu cua votes_count trong
        // bang questions
        $question->load('votes'); // refresh the relationship

        $downVotes = (int) $question->downVotes()->sum('vote');
        $upVotes = (int) $question->upVotes()->sum('vote');

        $question->votes_count = $downVotes + $upVotes;
        $question->save();
    }

    // Khi đâu đó lấy thuộc tính url của đối tượng user
    // thì sẽ trả về link tới màn hình show của user đó
    public function getUrlAttribute() {
        //return route("users.show", $this->id);
        return '#';
    }

    public function getAvatarAttribute() {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }
}
