<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use App\Models\Quiz;
use App\Models\quiz_categories;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request) //отвеч за отобр глав стран
    {
        $quizzes = Quiz::all(); // Fetch all quizzes from the database
        $categories = quiz_categories::all(); // Загружаем все категории
        if ($request->has('category')) {
            $categoryId = $request->input('category');
            $quizzes->where('category_id', $categoryId);
        }
        return view('welcome', compact('quizzes', 'categories')); // Замените 'welcome' на имя вашего шаблона
    }

   
    public function search(Request $request)
    {
        $categories = quiz_categories::all(); // Исправлено имя модели
    
        $query = Quiz::with('questions', 'category')->where('status', 'approved');
    
        if ($request->has('category')) {
            $categoryId = $request->input('category');
            if ($categoryId !== "") { // Проверка на пустое значение
                $query->where('category_id', $categoryId);
            }
        }
    
        $quizzes = $query->paginate(10); // Выполняем запрос и пагинируем результат
    
        return view('welcome', compact('quizzes', 'categories'));
    }

}
