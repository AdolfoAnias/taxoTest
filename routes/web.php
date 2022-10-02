<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('mail', [UserController::class,'mail'])->name('mail');
    
    Route::post('edit', [UserController::class,'update'])->name('edit');
    Route::post('delete.user/', [UserController::class,'destroy'])->name('delete.user');

    Route::get('moduleUsers', 'userController@index')->name('moduleUsers');
    Route::get('moduleMails', [EmailController::class, 'index'])->name('moduleMails');
    
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/logout', [LoginController::class,'logout']);
    
    Route::get('/usersFromApi', [UserController::class, 'getUsersFromAPI'])->name('usersFromApi');
});
