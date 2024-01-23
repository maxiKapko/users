<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Auth\LoginController;


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

/* Route::get('/', function () {
    return view('welcome');
}); */



Route::middleware(['auth'])->group(function () {

    Route::get('/home', [UsersController::class, 'index'])->name('home');
    Route::get('/create-user', [UsersController::class, 'create'])->name('create.user');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/edit-user/{id}', [UsersController::class, 'edit'])->name('edit.user');
    Route::post('/update-user/{id}', [UsersController::class, 'update'])->name('update.user');
    Route::delete('/delete-user/{id}', [UsersController::class, 'delete'])->name('delete.user');
    Route::post('/activate-user/{id}', [UsersController::class, 'activate'])->name('activate.user');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/create-file', [FileController::class, 'createFile'])->name('create.file');
    Route::post('/store-file', [FileController::class, 'store'])->name('file.store');
});



Auth::routes();


