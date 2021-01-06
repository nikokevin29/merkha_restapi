<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\UserInterestController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//No Login Required
Route::post('login', [UserController::class ,'login']);
Route::post('register', [UserController::class ,'register']);

Route::post('password/email', [UserController::class, 'forgot']);
Route::post('password/reset', [UserController::class ,'reset']);


Route::get('/email/resend', [VerificationController::class,'resend'])->name('verification.resend');//need bearer register
Route::get('/email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');

Route::get('product/category/show',[ProductCategoryController::class,'show']);
Route::get('product/category/showname',[ProductCategoryController::class,'showNameOnly']);
//Login Required
Route::group(['middleware' => 'auth:api','verified'], function(){
    //Account
    Route::post('details', [UserController::class ,'details']);
    Route::get('user', [UserController::class ,'fetch']);
    Route::post('user', [UserController::class ,'updateProfile']);
    Route::post('user/photo', [UserController::class ,'updatePhoto']);
    Route::post('logout', [UserController::class ,'logout']);

    Route::post('user/interest/{value}', [UserInterestController::class ,'add_user_interest']);
    Route::get('user/interest/show', [UserInterestController::class ,'show_user_interest']);

    //Address
    Route::get('user/addressall',[AddressController::class,'index']);
    Route::get('user/address',[AddressController::class,'showbyuser']);
    Route::post('user/address',[AddressController::class,'store']);
    Route::put('user/address/{id}',[AddressController::class,'update']);
    Route::delete('user/address/{id}',[AddressController::class,'destroy']);

    //Wishlist
    Route::get('wishlist/show',[WishlistController::class,'show']);
    Route::post('wishlist/add',[WishlistController::class,'add']);
    Route::delete('wishlist/delete/{id}',[WishlistController::class,'delete']);

    //Product
    Route::get('product/showall',[ProductController::class,'showAll']);
    Route::get('product/showbycategory/{id}',[ProductController::class,'showByCategory']);
    Route::get('product/showbymerchant/{id}',[ProductController::class,'showByMerchant']);
    Route::get('product/showdiscover/{limit}',[ProductController::class,'showDiscover']);
    Route::get('product/showbyorder/{limit}/{order}',[ProductController::class,'showByOrder']);//(order) asc : desc
    Route::get('product/showbybestseller/{limit}',[ProductController::class,'showByBestseller']);
    
    //Merchant
    Route::get('merchant/showbyrandom/{limit}',[MerchantController::class,'showByRandom']);
    Route::get('merchant/showbyid/{id}',[MerchantController::class,'showById']);

    //Order
    Route::get('order/show',[OrderController::class,'showOrderbyUserLogin']);
    //php artisan serve --host 0.0.0.0 for Emulator Android Windows

    //Payment
    //Feed Posting
    //Chat --Firebase
});