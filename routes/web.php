<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index']);
Route::get('create', [UserController::class, 'create']);
Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
Route::get('show/{user}', [UserController::class, 'show'])->name('show');
Route::post('/', [UserController::class, 'store'])->name('store');
Route::put('update/{user}', [UserController::class, 'update']);
Route::delete('destroy/{user}', [UserController::class, 'destroy']);

// Route::get('help', HelpController::class)->name('help');