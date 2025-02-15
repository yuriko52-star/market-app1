<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
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

Route::get('/download-image', [ImageController::class, 'downloadImage']);
// Route::post('/mypage/profile/store-address',[ProfileController::class,'storeProfileAddress'])->name('profile.storeAddress');
// Route::post('/mypage/profile/store-image',[ProfileController::class,'storeProfileImage'])->name('profile.storeImage');


// Route::get('/?tab=mylist', function() {
    // return view ('mylist');
// })->name('mylist');





Route::get('/', [ItemController::class, 'index'])->name('list');
Route::get('/search',[ItemController::class,'search'])->name('item.search');
Route::get('/item/{item_id}', [ItemController::class,'show']);

Route::post('/toggle-like/{item}', [LikeController::class, 'toggleLike'])->name('toggle-like');
Route::post('/items/{item_id}/comment',[CommentController::class,'store'])->name('comment.store');

 Route::get('/purchase/address/{item_id}',[PurchaseController::class,'editAddress'])->name('purchase.address');
// Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
 Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
Route::get('/purchase/{item_id}',[PurchaseController::class,'show'])->name('purchase.show');
route::post('/purchase/{item_id}',[PurchaseController::class,'store'])->name('purchase.store');







