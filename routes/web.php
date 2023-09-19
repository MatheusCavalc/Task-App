<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/my-tasks', [AppController::class, 'index'])->middleware(['auth', 'verified'])->name('my-tasks');

Route::get('/task/{task}/details', [AppController::class, 'detailsTask'])->name('task.details')->middleware(['auth', 'verified']);
Route::get('/category/{category}/details', [AppController::class, 'detailsCategory'])->name('task.details.category')->middleware(['auth', 'verified']);
Route::put('/cards/{card}/move', [AppController::class, 'updateStatus'])->name('subtasks.status')->middleware(['auth', 'verified']);


Route::resource('categories', CategoryController::class)->middleware(['auth', 'verified']);
Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);
Route::resource('subtasks', SubtaskController::class)->middleware(['auth', 'verified']);


















Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
