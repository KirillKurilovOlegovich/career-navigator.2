<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   
use Illuminate\Support\Facades\File;
use App\Models\Quiz;
use App\Models\quiz_categories;
use App\Models\Question;

class AdminController extends Controller 
{

    public function index() 
    {
        $Quiz = Quiz::latest()->get(); 
        $Question = Question::latest()->get(); 
        $quiz_categories = quiz_categories::latest()->get(); 
        return view('admin', ['Quiz' => $Quiz, 'Question' => $Question, 'quiz_categories' => $quiz_categories]); //сортируются по убыванию даты создания и передает в представление admin
    }

    public function reject(Quiz $quiz)
    {
        $quiz->status = 'rejected'; 
        $quiz->save();

        return redirect()->route('Admin'); 
    }

    public function approve(Quiz $quiz)
    {
        $quiz->status = 'approved'; 
        $quiz->save();

        return redirect()->route('Admin');
    }


    public function Delete($id)
    {
        //Find and delete the category
        $quizCategory = quiz_categories::findOrFail($id);
        $quizCategory->status = 'delete';
        $quizCategory->save();
    
        //Update quizzes associated with deleted category
        Quiz::where('category_id', $id)->update(['status' => 'rejected']);
    
        return redirect()->route('Admin')->with('success', 'Quiz category deleted successfully.');
    }
    
    public function Actvie($id)
    {
        $quizCategory = quiz_categories::findOrFail($id);
        $quizCategory->status = 'active';
        $quizCategory->save();
    
        //Update quizzes associated with activated category
        Quiz::where('category_id', $id)->update(['status' => 'approved']);
    
        return redirect()->route('Admin')->with('success', 'Quiz category activated successfully.');
    }
}
