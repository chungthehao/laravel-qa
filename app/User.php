<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens; // Provide some helper methods to inspect the authenticated user token

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['avatar', 'url']; // Để khi có model là có luôn các accessor

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

    public function posts() {
        $type = request()->get('type');
        $posts = collect();

        switch ($type) {
            case 'questions':
                $questions = $this->questions()->get();
                $posts = $posts->merge($questions);
                break;
            case 'answers':
                $answers = $this->answers()->with('question')->get();
                $posts = $posts->merge($answers);
                break;
            default: // both
                $questions = $this->questions()->get();
                $answers = $this->answers()->with('question')->get(); // eager loading trước để lát lấy title của question, best_answer_id
                $posts = $posts->merge($questions);
                $posts = $posts->merge($answers);
        } // End switch $type

        // Tweak the structure
        $posts = $posts->map(function ($post, $key) {
            $item = [
                'id' => $post->id,
                'votes_count' => $post->votes_count,
                'created_at' => $post->created_at->format('M d Y')
            ];

            if ($post instanceof Answer) {
                $item['type'] = 'A';
                $item['question_title'] = $post->question->title;
                $item['accepted'] = $post->question->best_answer_id === $post->id;
            } elseif ($post instanceof Question) {
                $item['type'] = 'Q';
                $item['question_title'] = $post->title;
                $item['accepted'] = isset($post->best_answer_id); // Nếu question này chưa chọn best answer thì best_answer_id là null
            }

            return $item;
        }); // End $posts->map

        return $posts->sortByDesc('votes_count')->values()->all();
        // values: Reset các key của mảng (bị lộn xộn sau khi sortByDesc)
        // all: Convert từ collection về array
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

        return $this->_vote($voteQuestions, $question, $vote);
    }
    
    public function voteTheAnswer(Answer $answer, $vote) {
        $voteAnswers = $this->voteAnswers();

        return $this->_vote($voteAnswers, $answer, $vote);
    }
    
    private function _vote($relationship, $model, $vote) {
        # Tao / Cap nhat vao bang pivot
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model->id, ['vote' => $vote]);
        } else {
            $relationship->attach($model->id, ['vote' => $vote]);
        }

        /* Cap nhat so vote (votes_count trong bang questions/answers/?,...) */
        $model->load('votes'); // refresh the relationship

        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $downVotes + $upVotes;
        $model->save();

        return $model->votes_count;
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
