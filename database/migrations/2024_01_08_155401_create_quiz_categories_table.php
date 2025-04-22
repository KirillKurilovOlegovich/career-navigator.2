<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Объявление нового класса миграции, который наследуется от класса Migration
return new class extends Migration {
    /**
     * Запустите миграцию.  
     * Этот метод выполняется при применении миграции.  
     * Он создает таблицу 'quiz_categories' в базе данных.
     */
    public function up(): void
    {
        // Использование фасада Schema для работы со схемой базы данных
        Schema::create('quiz_categories', function (Blueprint $table) {
            // Создание столбца с автоинкрементным ID
            $table->id(); 

            // Создание столбца 'name' типа string (строка) для названия категории.  
            // Модификатор unique() обеспечивает уникальность значений в этом столбце.
            $table->string('name')->unique(); 

            // Создание столбца 'status' типа enum (перечисление) со значениями 'active' и 'delete'.  
            // Значение по умолчанию - 'active'.
            $table->enum('status', ['active', 'delete'])->default('active'); 

            // Создание столбцов для отметки времени создания и обновления записи (created_at и updated_at)
            $table->timestamps(); 
        });
    }

    /**
     * Измените миграцию вспять.
     * Этот метод выполняется при откате миграции.  
     * Он удаляет таблицу 'quiz_categories' из базы данных.
     */
    public function down(): void
    {
        // Использование фасада Schema для удаления таблицы
        Schema::dropIfExists('quiz_categories');
    }
};
