<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


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

//Controller ( TasksController@index ) を経由してdashboardを表示するようにしてる
Route::get('/', [TasksController::class, 'index']);
//Route::get('/', function() { return view('dashboard'); });

Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::get('/', [TasksController::class, 'index']);
    Route::resource('tasks', TasksController::class);
    
    //Route::resource('tasks', TasksController::class, ['only' => ['store', 'destroy']]);
});

//Route::get('tasks/{id}', [TasksController::class, 'show']);
//Route::post('tasks', [TasksController::class, 'store']);
//Route::put('tasks/{id}', [TasksController::class, 'update']);
//Route::delete('tasks/{id}', [TasksController::class, 'destroy']);

//Rote::get('tasks', [TasksController::class, 'index'])->name('task.index');
//Route::get('tasks/create', [TasksControler:class, 'create'])->name('task.create');
//Route::get('tasks/{id}/edit', [TasksController::class, 'edit'])->name('task.edit');
require __DIR__.'/auth.php'; //auth.phpの内容を取得する記述