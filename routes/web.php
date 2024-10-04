<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('items')->group(function () {
    /* 単語一覧 */
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('item.index');
    /* 単語登録 */
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    /* 単語編集 */
    Route::get('/{id}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
    Route::put('/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('item.update');
    /* 単語削除 */
    Route::delete('/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('item.destroy');
    
    /* 暗記単語移動 */
    Route::post('/words/{id}/memorize', [App\Http\Controllers\WordController::class, 'memorize'])->name('words.memorize');
    /* 暗記単語表示 */
    Route::get('/words/memorized', [App\Http\Controllers\WordController::class, 'memorizedWords'])->name('words.memorized');    
    });

Route::prefix('words')->group(function () {
    /* 暗記単語一覧 */
    Route::get('/', [App\Http\Controllers\WordController::class, 'index'])->name('word.index');
    });
