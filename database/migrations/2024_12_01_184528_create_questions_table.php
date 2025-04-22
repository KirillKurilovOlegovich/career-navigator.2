<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Выполняет миграцию: создание таблицы questions.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // Автоинкрементный первичный ключ

            // ID викторины, к которой принадлежит вопрос (беззнаковый большой).
            $table->unsignedBigInteger('quiz_id'); 
            // Текст вопроса.
            $table->text('question_text'); 
            // Правильный ответ на вопрос.  Можно рассмотреть хранение в формате JSON для поддержки нескольких правильных ответов.
            $table->text('correct_answer'); 
            // Штампы времени (created_at и updated_at).
            $table->timestamps(); 

            // Определение внешнего ключа для quiz_id, ссылающегося на таблицу quizzes.
            // При удалении викторины, все связанные вопросы также удаляются (каскадное удаление).
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Отменяет миграцию: удаление таблицы questions.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};