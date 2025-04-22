<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_answers extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'user_answers', 'question_id'];
    protected $casts = ['user_answers' => 'array']; //Cast user_answers to an array

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id'); // Assuming Question model exists and has the id column.
    }
}