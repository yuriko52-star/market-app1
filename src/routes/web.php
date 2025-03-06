<?php

use Illuminate\Support\Facades\Route;
//  use App\Http\Controllers\DebugController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\AUth;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;

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


// Route::get('/preview/{viewName}', [DebugController::class, 'show']);

Route::get('/register',[RegisterController::class,'showRegister'])->name('register.show');
Route::post('/register',[RegisterController::class,'processRegister'])->name('register.process');

Route::middleware(['auth'])->group(function () {
    // Route::get('/email/verify', function () {
        // return view('auth.verify-email');
    // })->name('verification.notice');
    Route::get('/email/verify', [EmailVerificationController::class, 'show'])
        ->name('verification.notice'); 


    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');
});
Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/mypage/profile',[ProfileController::class,'showProfile'])->name('profile.show');
Route::get('/mypage/profile/create',[ProfileController::class,'create'])->name('profile.create');
Route::post('/mypage/profile/store',[ProfileController::class,'store'])->name('profile.store');
Route::get('/mypage/profile/{user}',[ProfileController::class,'edit'])
->where('user', '[0-9]+')
->name('profile.edit');
Route::patch('/mypage/profile/{user}',[ProfileController::class,'update'])->name('profile.update');
});
Route::get('/download-image', [ImageController::class, 'downloadImage']);
// Route::post('/mypage/profile/store-address',[ProfileController::class,'storeProfileAddress'])->name('profile.storeAddress');
// Route::post('/mypage/profile/store-image',[ProfileController::class,'storeProfileImage'])->name('profile.storeImage');


// Route::get('/?tab=mylist', function() {
    // return view ('mylist');
// })->name('mylist');





Route::get('/', [ItemController::class, 'index'])->name('list');
Route::get('/list/search', [ItemController::class, 'list'])->name('list.search'); // 検索結果保持用

Route::get('/search',[ItemController::class,'search'])->name('item.search');
Route::get('/item/{item}', [ItemController::class,'show'])->name('item.show');
Route::get('/sell',[ItemController::class,'sellPage']);
Route::get('/sell', [ItemController::class, 'create']);
Route::post('/sell',[ItemController::class,'store'])->name('sell.store');
Route::post('/toggle-like/{item}', [LikeController::class, 'toggleLike'])->name('toggle-like');
Route::post('/items/{item_id}/comment',[CommentController::class,'store'])->name('comment.store');

 Route::get('/purchase/address/{item_id}',[PurchaseController::class,'editAddress'])->name('purchase.address');
// Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
 Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
Route::get('/purchase/{item_id}',[PurchaseController::class,'show'])->name('purchase.show');
Route::post('/purchase/update-payment',[PurchaseController::class,'updatePayment'])->name('purchase.updatePayment');
// route::post('/purchase/{item_id}',[PurchaseController::class,'store'])->name('purchase.store');
route::post('/purchase',[PurchaseController::class,'store'])->name('purchase.store');

// Route::get('/mypage',[ProfileController::class,'index']);
 Route::get('/mypage',[ProfileController::class,'show'])->name('mypage');
Route::post('/checkout',[StripeController::class,'checkout'])->name('stripe.checkout');

Route::get('/success',[StripeController::class,'success'])->name('stripe.success');
Route::get('/cancel',[StripeController::class,'cancel'])->name('stripe.cancel');

Route::post('/stripe/webhook',[StripeWebhookController::class,'handleWebhook']);



