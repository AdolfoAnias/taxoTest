<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

    Route::get('moduleUsers', 'userController@index')->name('moduleUsers');
    Route::get('moduleMails', 'MailsController@index')->name('moduleMails');
    
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/logout', [LoginController::class,'logout']);
});
