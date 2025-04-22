<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewRoomController;

// use App\Http\Controllers\LikeController;у
// use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

use App\Exports\QuizAnswersExport; // Импортируем класс экспорта
use Maatwebsite\Excel\Facades\Excel;

Route::post('/create-category', [NewRoomController::class, 'store_category'])->name('store.category');



Route::get('/export-quiz-answers/{quiz_id}', [NewRoomController::class, 'export'])->name('export-quiz-answers');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/seatch', [HomeController::class, 'search'])->name('seatch');

Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/product/{product_id}', [HomeController::class, 'product'])->name('product')->middleware(['auth', 'verified']);
Route::post('/search', [HomeController::class, 'search'])->name('Search');
Route::post('/validate', [HomeController::class, 'validate'])->name('Validate');

Route::post('/profile/edit', [ProfileController::class, 'edit_profile'])->middleware(['auth', 'verified'])->name('editProfile');
    Route::get('/profile', [ProfileController::class, 'profile'])->middleware(['auth', 'verified'])->name('profile');
Route::get('/buy', [ProfileController::class, 'buy'])->middleware(['auth', 'verified'])->name('Buy');

Route::post('/storeTest', [NewRoomController::class, 'store'])->middleware(['auth', 'verified'])->name('storeTest');
Route::get('/Test_setting', [NewRoomController::class, 'new_test'])->middleware(['auth', 'verified'])->name('new_test');

Route::post('/addQuestions', [NewRoomController::class, 'addQuestions'])->middleware(['auth', 'verified'])->name('addQuestions');

Route::get('/deleteQuestion/{questionId}', [NewRoomController::class, 'deleteQuestion'])->middleware(['auth', 'verified']);

Route::get('/quiz/lets_quiz/{quiz}', [NewRoomController::class, 'show'])->name('lets_quiz')->middleware(['auth']);
Route::delete('/profile/quiz/{quizId}', [NewRoomController::class, 'deleteQuiz'])->middleware(['auth'])->name('deleteQuiz');

Route::get('/quiz/{quiz}', [NewRoomController::class, 'showQuiz'])->name('show_quiz')->middleware(['auth']);
Route::post('/quizzes/answer', [NewRoomController::class, 'storeAnswer'])->middleware(['auth', 'web']);// Route::get('/basket/add/{product_id}', [BasketController::class, 'add_basket'])->name('ToBasket')->middleware(['auth', 'verified']);
// Route::get('/basket/open', [BasketController::class, 'open_basket'])->name('OpenBasket')->middleware(['auth', 'verified']);
// Route::get('/basket/delete/{basket_id}', [BasketController::class, 'delete_basket'])->name('DeleteBasket')->middleware(['auth', 'verified']);

Route::get('/test/{quiz_id}', [NewRoomController::class, 'showTest'])->name('show_test')->middleware(['auth']);
Route::get('/quiz/{quiz}', [NewRoomController::class, 'showQuiz'])->name('show_quiz')->middleware(['auth']);

Route::get('/quiz_update/{quiz_id}', [NewRoomController::class, 'showQuizUpdate'])->name('showQuizUpdate')->middleware(['auth']);
Route::put('/quiz/{quiz}/update', [NewRoomController::class, 'updateQuiz'])->name('update_quiz')->middleware(['auth']);

Route::get('/admin', [AdminController::class, 'index'])->name('Admin')->middleware([IsAdmin::class]);
Route::get('/admin/delete/{product_id}', [AdminController::class, 'delete_product'])->name('DeleteProduct')->middleware([IsAdmin::class]);
Route::post('/admin/position/add', [AdminController::class, 'new_product'])->name('NewPosition')->middleware([IsAdmin::class]);
Route::get('/edit/{product_id}', [AdminController::class, 'edit_product'])->name('EditTovar')->middleware([IsAdmin::class]);
Route::post('/edit/{product_id}', [AdminController::class, 'save_edit_product'])->name('EditTovar')->middleware([IsAdmin::class]);
Route::get('/quizzes/{quiz}/reject', [AdminController::class, 'reject'])->name('RejectQuiz')->middleware([IsAdmin::class]);
Route::get('/quizzes/{quiz}/approve', [AdminController::class, 'approve'])->name('ApproveQuiz')->middleware([IsAdmin::class]);


Route::get('/quiz_categories/{quiz}/reject', [AdminController::class, 'Delete'])->name('Delete')->middleware([IsAdmin::class]);
Route::get('/quiz_categories/{quiz}/approve', [AdminController::class, 'Actvie'])->name('Actvie')->middleware([IsAdmin::class]);

require __DIR__.'/auth.php';
