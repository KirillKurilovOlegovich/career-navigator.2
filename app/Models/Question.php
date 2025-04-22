<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Модель для работы с вопросами в базе данных.
class Question extends Model
{
    use HasFactory;

    // Указывает поля, которые могут быть заполнены при создании/обновлении модели.
    //  Это важная мера безопасности, предотвращающая внесение данных в нежелательные поля.
    protected $fillable = ['quiz_id', 'question_text', 'correct_answer'];


    // Определяет отношение "один ко многим" между таблицами Question и Quiz.
    // Это означает, что каждый вопрос принадлежит одному викторине.
    // Метод `quiz()` возвращает экземпляр модели Quiz, связанный с текущим вопросом.
    public function quiz()
    {
        // Возвращает связанную модель Quiz.
        return $this->belongsTo(Quiz::class);
    }
}