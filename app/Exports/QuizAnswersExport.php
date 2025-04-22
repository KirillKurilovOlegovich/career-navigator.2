<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class QuizAnswersExport implements FromQuery, WithHeadings, WithMapping
{
    protected $quizId;

    public function __construct($quizId) {
        $this->quizId = $quizId;
    }

    public function query()
    {
        return DB::table('quiz_answers')
            ->join('users', 'quiz_answers.user_id', '=', 'users.id')
            ->join('questions', 'quiz_answers.question_id', '=', 'questions.id')
            ->select(
                'users.id as user_id',
                'users.surname as user_surname',
                'questions.question_text',
                'quiz_answers.user_answer',
                'questions.correct_answer',
                DB::raw('CASE WHEN quiz_answers.user_answer = questions.correct_answer THEN "Правильно" ELSE "Неправильно" END as result')
            )
            ->where('quiz_answers.quiz_id', $this->quizId)
            ->orderBy('quiz_answers.id', 'asc');
    }

    public function headings(): array
    {
        return [
            'ID пользователя',
            'Фамилия пользователя',
            'Текст вопроса',
            'Ответ пользователя',
            'Правильный ответ',
            'Результат',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user_id,
            $row->user_surname,
            $row->question_text,
            $row->user_answer,
            $row->correct_answer,
            $row->result,
        ];
    }
}