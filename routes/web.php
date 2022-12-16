<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Home;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'], function() {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/tasks/new', [TaskController::class, 'new'])->name('tasks.new');
    Route::post('/tasks/new', [TaskController::class, 'create']);

    Route::get('/tasks/{task_id}/edit', [TaskController::class, 'editShow'])->name('tasks.edit');
    Route::post('/tasks/{task_id}/edit', [TaskController::class, 'edit']);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [Home::class, 'top'])->name('Home.top');
