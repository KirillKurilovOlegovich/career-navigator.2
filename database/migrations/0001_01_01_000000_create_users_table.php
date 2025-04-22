<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration // Создает новый экземпляр класса миграции, который наследуется от базового класса Migration.
{
    /**
     * Run the migrations.
     */
    public function up(): void // Вызывается при выполнении миграции, отвечает за создание новых таблиц в БД
    {
        Schema::create('users', function (Blueprint $table) { // Создание новой таблицы с именем 'users'. Внутри блока кода определяются поля таблицы.
            $table->id(); // Этот метод добавляет автоинкрементное поле "id" в таблицу, которое будет служить первичным ключом.
            $table->string('name'); // Добавляет строковое поле 'name' для имени пользователя.
            $table->string('surname'); // Добавляет строковое поле 'surname' для фамилии пользователя.
            $table->string('email')->unique(); // Добавляет строковое поле 'email' для электронной почты,  уникальное значение.
            $table->string('number'); // Добавляет строковое поле 'number' для номера телефона или другого идентификатора.
            $table->boolean('is_admin')->default(false); // Поле для указания, является ли пользователь администратором, по умолчанию установлено false (нет).
            $table->timestamp('email_verified_at')->nullable(); // Для хранения временной метки подтверждения электронной почты, может быть пустым (NULL).
            $table->string('password'); // Поле для хранения зашифрованного пароля пользователя.
            $table->rememberToken(); // Для хранения токена для аутентификации пользователя (для функции "Запомнить меня").
            $table->timestamps(); // Добавляет поля `created_at` и `updated_at` для отслеживания временных меток создания и обновления запи поле 'email' для электронной почты пользователя, которое будет служить первичным ключом.
            $table->string('token'); // Поле для хранения токена, который будет отправлен пользователю для сброса пароля.
            $table->timestamp('created_at')->nullable(); // Поле для хранения временной метки создания записи о запросе на сброс пароля.
        });

        Schema::create('sessions', function (Blueprint $table) { // Создает новую таблицу 'sessions' для хранения сессий пользователей.
            $table->string('id')->primary(); // Поле, служащее первичным ключом и хранящее ID сессии.
            $table->foreignId('user_id')->nullable()->index(); // Поле для хранения ID пользователя, связанного с данной сессией.  `nullable` - может быть NULL, `index о браузере и операционной системе пользователя.
            $table->longText('payload'); // Поле для хранения данных сессии в виде текста.
            $table->integer('last_activity')->index(); // Поле для временной метки последней активности в сессии, индекс для ускорения поиска.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // Вызывается при откате миграции, отвечает за удаление таблиц, созданных в методе up().
    {
        Schema::dropIfExists('users'); // Удаляет таблицу 'users' из базы данных.
        Schema::dropIfExists('password_reset_tokens'); // Удаляет таблицу 'password_reset_tokens' из базы данных.
        Schema::dropIfExists('sessions'); // Удаляет таблицу 'sessions' из базы данных.
    }
};
