<?php

use App\Http\Controllers\Auth\LoginController;
use App\Jobs\FileUpload;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
Route::get('/viva/checkout/redirect', [\App\Http\Controllers\HomeController::class, 'api'])->name('index');
Route::get('/viva/checkout/callback', [\App\Http\Controllers\HomeController::class, 'confirm'])->name('viva.confirm');
Route::get('/editor', [\App\Http\Controllers\HomeController::class, 'tiny'])->name('tiny');
Route::get('/mce', [\App\Http\Controllers\HomeController::class, 'mce'])->name('tiny');

Route::post('/add', function() {
    \Illuminate\Support\Facades\Session::flash('success_message', 'helooo');
});
Route::post('/second', function() {
    \Illuminate\Support\Facades\Session::flash('success_message', 'Has the message changed');
});
Route::post('/danger', function() {
    \Illuminate\Support\Facades\Session::flash('danger_message', 'redddddddd');
});
Route::get('/remove/session/', function(\Illuminate\Http\Request $request) {
    if(\Illuminate\Support\Facades\Session::get($request->key))
    {
        \Illuminate\Support\Facades\Session::forget($request->key);
    }
});
Route::post('/file', function(\Illuminate\Http\Request $request) {

    dispatch(new FileUpload($request->file('files'), auth()->user(), 'file'))->onQueue('high')->afterResponse();

    return back();

});
Route::post('/file/move', function(\Illuminate\Http\Request $request) {
    $draggable = \Spatie\MediaLibrary\MediaCollections\Models\Media::whereId($request->draggable)->first();
    $dropped = \Spatie\MediaLibrary\MediaCollections\Models\Media::whereId($request->dropped)->first();
    $media = auth()->user()->photos()->pluck('id')->toArray();
    $arrayItemToBeReplaced = array_search($dropped->id, $media);
    $itemToBeBefore = array_search($draggable->id, $media);
    \App\Models\User::moveElement($media,   $itemToBeBefore ,$arrayItemToBeReplaced  );
    Media::setNewOrder(array_values($media));
});

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
    Route::get('/stripe', [LoginController::class, 'stripe']);

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


