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


Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
