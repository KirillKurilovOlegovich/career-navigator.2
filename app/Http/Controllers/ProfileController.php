<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Basket;
use App\Models\Quiz;
use App\Models\quiz_categories;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403); // Or redirect, as before.
        }
        // Corrected line: Get quizzes where user_id matches the authenticated user's ID.
        $quizzes = Quiz::where('user_id', $user->id)->get(); 
        $categories = quiz_categories::all(); // Получаем все категории

        return view('profile', compact('quizzes', 'categories'));
    }

    public function edit_profile(Request $request) //обраб редактир проф польз
    // Редактирование профиля
    {
        $user = Auth::user(); //получ текущ польз
    
        $user->name = $request->name;//обновл полей проф польз на основе дан из http-запроса
        $user->surname = $request->surname;//обновл полей проф польз на основе дан из http-запроса
        $user->number = $request->phone;//обновл полей проф польз на основе дан из http-запроса
        $user->email = $request->email;//обновл полей проф польз на основе дан из http-запроса
        if ($request->filled('password')) { //если в запр есть нов пар, он хэшир и обновл в проф польз
            $user->password = Hash::make($request->password); //если в запр есть нов пар, он хэшир и обновл в проф польз
        }
    
        $user->save(); //сохр обновлен данн польз
    
        return redirect()->back(); //перенаправл обратно на предыд страницу
    }
    public function buy() //обраб процесс покупки 
    {
        $user_id = auth()->id(); //получ id польз 
        $baskets = Basket::where('user_id', $user_id)->get(); //загруж все записи из табл baskets
    
        foreach ($baskets as $basket) { 
            $purchase = new Purchase(); //созд нов запис в табл с данными из корз
            $purchase->user_id = $basket->user_id;
            $purchase->product_id = $basket->product_id;
            $purchase->save(); //сохр обновлен запись 
    
            $basket->delete(); //удал запись из корз
        }
    
        return redirect()->route('profile'); //перенаправл на стран проф 
    }
}
