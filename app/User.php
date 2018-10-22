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

    // Khi đâu đó lấy thuộc tính url của đối tượng user
    // thì sẽ trả về link tới màn hình show của user đó
    public function getUrlAttribute() {
        //return route("users.show", $this->id);
        return '#';
    }
}
