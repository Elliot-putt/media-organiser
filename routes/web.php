<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::middleware('guest')->group(function() {
    /////////////////////////////////////////////
    ////////////username/password Index//////////
    /////////////////////////////////////////////
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
    /////////////////////////////////////////////
    ////////////Login / Office Index/////////////
    /////////////////////////////////////////////
    Route::controller(\App\Http\Controllers\OfficeLoginController::class)->group(function() {
        Route::get('/login/microsoft', 'redirectToProvider')->name('office.redirect');
        Route::get('login/microsoft/callback', 'handleProviderCallback')->name('office.login');
    });
});
Route::middleware('auth')->group(function() {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout']);


    Route::controller(\App\Http\Controllers\UserController::class)->group(function() {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
    });
    Route::controller(\App\Http\Controllers\MediaController::class)->group(function() {
        Route::get('/media', 'index')->name('media.index');
        Route::get('/media/levelup', 'levelUp')->name('media.index');
        Route::post('/media/upload/', 'upload')->name('media.upload');
        Route::get('/media/folder/{folder}', 'checkFolder')->name('media.folder.check');
        Route::post('/media/folder/move/', 'moveFiles')->name('media.move.folder');
        Route::get('/media/folder/{folder}/check', 'checkFolderAnywhere')->name('folder.check.anywhere');
        Route::post('/media/folder/create/{folder}', 'createDir')->name('media.create.dir');
        Route::post('/media/delete/', 'fileDelete')->name('media.delete');
        Route::get('/media/guide/', 'guide')->name('media.guide');
    });


});


