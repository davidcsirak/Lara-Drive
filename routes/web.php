<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/files/create', [\App\Http\Controllers\FilesController::class, 'create'])->name('files.create');
Route::post('/files', [\App\Http\Controllers\FilesController::class, 'store'])->name('files.store');
Route::get('/files/{file}/edit', [\App\Http\Controllers\FilesController::class, 'edit'])->name('files.edit');
Route::patch('/files/{file}', [\App\Http\Controllers\FilesController::class, 'update'])->name('files.update');
Route::delete('/files/{file}', [\App\Http\Controllers\FilesController::class, 'delete'])->name('files.destroy');
Route::get('/files/redirect', [\App\Http\Controllers\FilesController::class, 'redirect'])->name('files.redirect');
Route::get('/files/{file}', [\App\Http\Controllers\FilesController::class, 'download'])->name('files.download');

Route::get('/textfiles/create', [\App\Http\Controllers\TextfilesController::class, 'create'])->name('textfiles.create');

Route::get('/custom-forgot-password', [\App\Http\Controllers\CustomPasswordResetController::class, 'create'])->name('custom.password.create');
Route::post('/custom-forgot-password', [\App\Http\Controllers\CustomPasswordResetController::class, 'store'])->name('custom.password.store');

Route::get('/custom-forgot-username', [\App\Http\Controllers\CustomUsernameResetController::class, 'create'])->name('custom.username.create');
Route::post('/custom-forgot-username', [\App\Http\Controllers\CustomUsernameResetController::class, 'store'])->name('custom.username.store');

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/index-search', [\App\Http\Controllers\HomeController::class, 'indexSearch'])->name('search');

require __DIR__.'/auth.php';
