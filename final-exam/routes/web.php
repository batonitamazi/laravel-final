<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [QuizController::class, 'index'])->name('quiz.index');

Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create')->middleware('auth');
Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store')->middleware('auth');
Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
Route::get('/quiz/{quiz}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
Route::put('/quiz/{quiz}', [QuizController::class, 'update'])->name('quiz.update');





Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('question.create');
Route::post('/questions', [QuestionController::class, 'store'])->name('question.store');
Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('question.update');


    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
