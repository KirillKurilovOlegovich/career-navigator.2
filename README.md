**Установка**
- Установить PHP <a>https://www.php.net/downloads</a>
- Установить Nodejs <a>https://nodejs.org/en/download</a> **Не меньше 14 версии**
- Установить Composer <a>https://getcomposer.org/</a>
- Клонировать репозиторий `git clone <link>`
- Скачать модули node `npm install`
- Добавить composer `Composer i`
---
**Запуск**
- Создать файл конфигурации с примера `Copy .env.example .env`
>*Файл .env* <br> - Отредактировать файл конфигурации
- Создать ключ приложения `php artisan key:generate`
- Мигрировать таблицы `php artisan migrate`
- Создать админа `php artisan db:seed`
- Создание локального хранилища `php artisan storage:link`
- Запустить приложения `npm run dev` и `php artisan serve`
---
**Данные админа** <br>
>*Изменять в  файле миграций*
- Логин: `admin@gmail.com`
- Пароль: `00000000`
