<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запуск миграции: создание таблицы quizzes.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id(); // Автоинкрементный первичный ключ

            // ID пользователя, создавшего викторину.  Беззнаковый и большой, для соответствия типу ID в таблице users.
            $table->unsignedBigInteger('user_id'); 
            // Заголовок викторины (строка).
            $table->string('title'); 
            // Статус викторины (строка). Значение по умолчанию - 'waiting'.
            $table->enum('status', ['rejected', 'approved' , 'waiting'])->default('waiting'); 
            // ID категории викторины (беззнаковый большой, может быть NULL).
            $table->unsignedBigInteger('category_id')->nullable(); 
            // Определение внешнего ключа для category_id, ссылающегося на таблицу quiz_categories.
            // При удалении категории, значение category_id в этой таблице устанавливается в NULL.
            $table->foreign('category_id')->references('id')->on('quiz_categories')->onDelete('set null');
            // Описание викторины (текст, может быть NULL).
            $table->text('description')->nullable(); 
            // Штампы времени (created_at и updated_at).
            $table->timestamps(); 

            // Определение внешнего ключа для user_id, ссылающегося на таблицу users.
            // При удалении пользователя, все связанные викторины также удаляются (каскадное удаление).
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Отмена миграции: удаление таблицы quizzes.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};