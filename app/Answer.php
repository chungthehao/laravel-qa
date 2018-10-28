<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function question() {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute() {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute() {
        return $this->isBest();
    }

    public function isBest() {
        return $this->id === $this->question->best_answer_id;
    }

    public static function boot() {
        // Kế thừa, giữ lại method cha
        parent::boot();

        /* Eloquent Events */
        # Chạy đoạn code này khi answer (model instance) được create
        static::created(function ($answer) {// $answer represent the current model instance
            # Testing purpose
            echo "Answer is Created!\n";

            $answer->question->increment('answers_count');
            // Không cần gọi tiếp $answer->question->save()
            // tự nó save luôn rồi.
        });

        # Chạy đoạn code này khi answer (model instance) được save (cả create và khi update)
        static::saved(function ($answer) {// $answer represent the current model instance
            echo "Answer is Saved!\n";
        });

        /* Các bước test create */
        # B1: Chạy php artisan tinker
        # B2: Lấy 1 instance Question bất kỳ, vd:
        // $q = App\Question::first()
        # B3: Tạo 1 answer cho $q:
        // $q->answers()->save( // answers() mối qh trong model Question
        //     factory(App\Answer::class)->make()
        // )

        /* Các bước test save */
        # B1: Chạy php artisan tinker
        # B2: Lấy 1 instance Answer bất kỳ, vd:
        // $a = App\Answer::find(22)
        # B3: Chỉnh sửa gì đó bất kỳ
        // $a->votes_count = 8
        # B4: Save lại
        // $a->save()

        static::deleted(function ($answer) { // define an argument to represent the answer instant
            $question = $answer->question;

            // Xóa 1 answer thì giảm answers_count ở bảng questions đi 1
            $question->decrement('answers_count');

            /* Nếu answer bị xóa là best answer thì cập nhật lại */
            # Cách 1
//            if ($question->best_answer_id === $answer->id) {
//                $question->best_answer_id = null;
//                $question->save();
//            }
            # Cách 2
            // Dùng best_answer_id làm khóa ngoại (xem file migration bổ sung)
        });

    }
}
