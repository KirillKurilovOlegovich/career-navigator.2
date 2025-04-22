<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграции: создание таблицы quiz_answers.  Эта таблица будет хранить ответы пользователей на вопросы викторин.
     */
    public function up(): void
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id(); // Автоинкрементный первичный ключ

            // ID пользователя, который дал ответ (беззнаковый большой).
            $table->unsignedBigInteger('user_id'); 
            // ID викторины (беззнаковый большой).
            $table->unsignedBigInteger('quiz_id'); 
            // ID вопроса (беззнаковый большой).  Это необходимо для связи с таблицей вопросов.
            $table->unsignedBigInteger('question_id'); 
            // Сам ответ пользователя (строка).
            $table->string('user_answer'); 
            // Штампы времени (created_at и updated_at).
            $table->timestamps(); 

            // Определение внешнего ключа для user_id, ссылающегося на таблицу users.
            // При удалении пользователя, все его ответы удаляются (каскадное удаление).
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Определение внешнего ключа для quiz_id, ссылающегося на таблицу quizzes.
            // При удалении викторины, все ответы на вопросы этой викторины удаляются (каскадное удаление).
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            // Определение внешнего ключа для question_id, ссылающегося на таблицу questions.
            // При удалении вопроса, все ответы на этот вопрос удаляются (каскадное удаление).
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Отмена миграции: удаление таблицы quiz_answers.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};