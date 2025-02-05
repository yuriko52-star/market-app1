<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
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

/*Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/preview/{viewName}', [DebugController::class, 'show']);

Route::get('/register',[RegisterController::class,'showRegister'])->name('register.show');
Route::post('/register',[RegisterController::class,'processRegister'])->name('register.process');
Route::get('/mypage/profile/show',[ProfileController::class,'showProfile'])->name('profile.show');
Route::get('/mypage/profile/create',[ProfileController::class,'create'])->name('profile.create');
Route::post('/mypage/profile/store',[ProfileController::class,'store'])->name('profile.store');


Route::get('/', [ItemController::class, 'index'])->name('list');

