<?php
namespace App;

trait VotableTrait
{
    public function votes() {
        return $this->morphToMany(
            User::class,
            'votable'
        # De luc goi $a1->votes (<=> $a1->votes()->get())
        // thi co luon 'created_at', 'updated_at', 'vote'
        // ma ko can phai $a1->votes()->withPivot('vote')->get() de lay them cot 'vote'
        )->withTimestamps()->withPivot('vote');
    }

    public function upVotes() {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes() {
        return $this->votes()->wherePivot('vote', -1);
    }
}