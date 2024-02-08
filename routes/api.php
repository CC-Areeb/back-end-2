<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ToDoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'super.admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('users.index');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::get('view/{id}', [UserController::class, 'singleUser'])->name('users.single');
        Route::post('update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });
});

Route::post('/create-task', [ToDoController::class, 'storeToDo']);
