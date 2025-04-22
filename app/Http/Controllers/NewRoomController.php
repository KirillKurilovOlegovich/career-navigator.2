<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\quiz_categories;
use App\Models\quiz_answers;
use Auth;
use App\Exports\QuizAnswersExport;
use Illuminate\Http\JsonResponse; //Ensure that you are returning a json response
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; //Для валидации
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException; // Correct import
class NewRoomController extends Controller
{
    public function new_test()
    {
        $user_id = auth()->id();
        $quiz = Quiz::with('questions', 'category')->where('user_id', $user_id)->first(); // Добавлен 'category'
        $categories = quiz_categories::all(); // Получаем все категории
    
        if (!$quiz) {
            return back()->with('error', 'You have not created any quizzes yet.');
        }
    
        return view('NewTest', compact('user_id', 'quiz', 'categories')); // Добавлена 'categories'
    }

public function storeTest(Request $request)
{
    $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'questions' => 'array',
        'questions.*.question_text' => 'required',
        'questions.*.correct_answer' => 'required',
    ]);

    $quiz = Quiz::findOrFail($request->quiz_id);
    $questions = $request->input('questions');

    // Process and save the questions.  This depends on your Question model.
    foreach ($questions as $questionData) {
        $question = new Question();
        $question->quiz_id = $quiz->id;
        $question->question_text = $questionData['question_text'];
        $question->correct_answer = $questionData['correct_answer'];
        $question->save();
    }

    return redirect()->route('quizzes.index')->with('success', 'Test saved successfully!'); // Or wherever you want to redirect
}
// фунция создаяни теста
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'required|exists:quiz_categories,id', // Validate category ID
        'description' => 'nullable|string', //Allow null or string for description
    ]);

    $quiz = Quiz::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'category_id' => $request->category_id,
        'description' => $request->description,
        'status' => 'waiting' //Add status field
    ]);

    return redirect()->route('new_test')->with('success', 'Test created successfully!');
}


public function addQuestions(Request $request)
{
    $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'questions' => 'required|array',
        'questions.*.question_text' => 'required|string|max:255',
        'questions.*.correct_answer' => 'required|string|max:255',
        'questions.*.id' => 'nullable|exists:questions,id', //New validation rule
    ]);

    $quiz = Quiz::findOrFail($request->quiz_id);

    try {
        DB::transaction(function () use ($quiz, $request) {
            foreach ($request->input('questions') as $questionData) {
                if (isset($questionData['id']) && $questionData['id']) {
                    //Update existing question
                    $question = Question::find($questionData['id']);
                    if ($question && $question->quiz_id === $quiz->id) {
                        $question->update($questionData);
                    }
                } else {
                    // Add new question
                    $quiz->questions()->create($questionData);
                }
            }
        });
        return back();
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error saving questions: ' . $e->getMessage()]);
    }
}


public function deleteQuestion(Request $request, $questionId)
{
    try{
        $question = Question::findOrFail($questionId);
        $question->delete();
        return back();
    }catch(\Exception $e){
        return response()->json(['success' => false, 'message' => 'Error deleting question: ' . $e->getMessage()]);
    }

}

public function deleteQuiz(Request $request, $quizId)
{
    $quiz_delete = Quiz::where('id', $quizId)->delete();
    return back();

}

public function showQuiz(Quiz $quiz)
{
   
    return view('NewTest', compact('quiz'));
}


public function show($quizId)
{
    try {
        $quiz = Quiz::findOrFail($quizId); // Find quiz by ID; throws exception if not found

        return view('quiz', compact('quiz'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('index')->with('error', 'Quiz not found'); //Or abort(404)
    }
}



    // ... other methods ...public function storeResults(Request $request, $quizId)
    public function storeAnswer(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'quiz_id' => 'required|integer',
                'question_id' => 'required|integer',
                'user_answer' => 'required|string',
            ]);
    
            // Check for existing answer
            $existingAnswer = quiz_answers::where([
                'user_id' => $request->input('user_id'),
                'quiz_id' => $request->input('quiz_id'),
                'question_id' => $request->input('question_id'),
            ])->first();
    
    
            if ($existingAnswer) {
                return response()->json(['message' => 'Вы уже отвечали на этот вопрос.'], 200); //200 OK to prevent further errors
            }
    
            $quizAnswer = new quiz_answers();
            $quizAnswer->user_id = $request->input('user_id');
            $quizAnswer->quiz_id = $request->input('quiz_id');
            $quizAnswer->question_id = $request->input('question_id');
            $quizAnswer->user_answer = $request->input('user_answer');
            $quizAnswer->save();
    
            return response()->json(['message' => 'Answer saved successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error saving quiz answer: ' . $e->getMessage() . '  Stack Trace:' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to save answer: ' . $e->getMessage()], 500);
        }
    }



    public function showTest($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id); //Throws ModelNotFoundException if not found

        $answers = quiz_answers::where('quiz_id', $quiz_id)
            ->with('question')
            ->get();

        return view('show_awnser', ['quiz' => $quiz, 'answers' => $answers]);
    }

    public function showQuizUpdate($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $categories = quiz_categories::all(); // Загружаем все категории
    
        return view('quiz_update', ['quiz' => $quiz, 'categories' => $categories]);
    }
    public function updateQuiz(Request $request, Quiz $quiz)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:quiz_categories,id',
            ]);
    
            $quiz->title = $request->input('title');
            $quiz->category_id = $request->input('category_id');
            $quiz->save();
    
            return back()->with('success', 'Викторина успешно обновлена!');
        } catch (\Exception $e) {
            Log::error("Error updating quiz: " . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при обновлении викторины.');
        }
    }


    // создания новой категории 
    public function store_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:quiz_categories,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        quiz_categories::create(['name' => $request->name]);

        return redirect()->route('new_test')->with('success', 'Test created successfully!');
        }


        public function export($quiz_id, Request $request) {
            $answersExport = new QuizAnswersExport($quiz_id);
            return Excel::download($answersExport, 'quiz_answers_' . $quiz_id . '.xlsx');
        }
}

