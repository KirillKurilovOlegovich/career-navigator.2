<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable //Класс User наследуется от класса Authenticatable. Это означает, что у пользователя есть атрибуты, которые используются для аутентификации, такие как имя пользователя, пароль и электронная почта.
{
    use HasFactory, Notifiable; // позволяет использовать методы, определённые в других классах. HasFactory предоставляет методы для создания экземпляров объектов, а Notifiable позволяет пользователю получать уведомления.

    /**
     * The attributes that are mass assignable.Атрибуты, которые можно массово присваивать.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // переменная содержит список атрибутов, которые массово присвоены при создании объекта user
        'name',
        'surname',
        'email',
        'number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization. скрытые атрибуты
     *
     * @var array<int, string>
     */
    protected $hidden = [ //атрибуты которые должны быть скрыты 
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast. Преобразование атрибутов
     *
     * @return array<string, string>
     */
    protected function casts(): array //определяет какие атрибуты должны быть преобрзованы в определ тип данных перед сохр в бд
    {
        return [
            'email_verified_at' => 'datetime', //преобразован в формат даты и времени
            'password' => 'hashed', // преобразован в хэшированную строку 
        ];
    }
}
