<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('words')->group(function () {
    /* 登録単語一覧 */
    Route::get('/', [App\Http\Controllers\WordController::class, 'index'])->name('word.index');
    /* 暗記した単語を送信 */
    Route::put('/memorized', [App\Http\Controllers\WordController::class, 'memorized'])->name('word.memorized');
    /* 暗記単語一覧 */
    Route::get('/memorized-words', [App\Http\Controllers\WordController::class, 'showMemorizedWords'])->name('memorized.words'); 
    /* 未暗記単語一覧 */
    Route::get('/unmemorized-words', [WordController::class, 'showUnmemorizedWords'])->name('unmemorized.words');
    /* 単語登録 */
    Route::get('/add', [App\Http\Controllers\WordController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\WordController::class, 'add']);
    /* 単語編集 */
    Route::get('/{id}/edit', [App\Http\Controllers\WordController::class, 'edit'])->name('word.edit');
    Route::put('/{id}', [App\Http\Controllers\WordController::class, 'update'])->name('word.update');
    /* 単語削除 */
    Route::delete('/{id}', [App\Http\Controllers\WordController::class, 'destroy'])->name('word.destroy');

});
