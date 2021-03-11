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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MerchantCategoryController;
use App\Http\Controllers\AppContentController;
use App\Http\Controllers\FollowingUserController;
use App\Http\Controllers\ReviewMerchantController;
use App\Http\Controllers\ReviewProductController;
use App\Http\Controllers\ReportProductController;
use App\Http\Controllers\ReportFeedController;
use App\Http\Controllers\OperationalHoursController;
use App\Http\Controllers\MerchantBannerController;
use App\Http\Controllers\FeedLikeController;
use App\Http\Controllers\WishlistSavedController;

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

//Background Banner Mobile
Route::get('banner',[AppContentController::class,'getBanner']);
//Login Required
Route::group(['middleware' => 'auth:api','verified'], function(){
    //Account
    Route::post('details', [UserController::class ,'details']);
    Route::get('user', [UserController::class ,'fetch']);
    Route::post('user', [UserController::class ,'updateProfile']);
    Route::post('user/photo', [UserController::class ,'updatePhoto']);
    Route::post('logout', [UserController::class ,'logout']);
    Route::get('users/{id}',[UserController::class,'getUserById']);
    Route::put('username/update',[UserController::class,'updateUsername']);

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
    Route::get('product/showbymerchant/{id}',[ProductController::class,'showByMerchant']);//Show Product By Merchant
    Route::get('product/showdiscover/{limit}',[ProductController::class,'showDiscover']);
    Route::get('product/showbyorder/{limit}/{order}',[ProductController::class,'showByOrder']);//(order) asc : desc
    Route::get('product/showbybestseller/{limit}',[ProductController::class,'showByBestseller']);
    Route::get('product/searchbyproduct/{productName}',[ProductController::class,'searchByProductName']);
    Route::get('product/showbyid/{id}',[ProductController::class,'showById']);
    Route::get('product/showbymerchantcategory/{id}',[ProductController::class,'showByMerchantCategory']);
    Route::get('product/showbestsellerbymerchant/{id}',[ProductController::class,'showBestSellerById']);

    Route::get('product/searchproductbymerchant/{productName}/{idMerchant}',[ProductController::class,'searchProductByMerchant']);
    Route::get('product/increaseview/{id}',[ProductController::class,'increaseViewProduct']);

    //Merchant
    Route::get('merchant/showbyrandom/{limit}',[MerchantController::class,'showByRandom']);
    Route::get('merchant/showbyid/{id}',[MerchantController::class,'showById']);
    Route::get('merchant/searchbymerchant/{merchantName}',[MerchantController::class,'searchByMerchantName']);
    Route::get('merchant/showbymerchantid/{id}',[MerchantController::class,'showByMerchantId']);

    //Order
    Route::get('order/show',[OrderController::class,'showOrderbyUserLogin']);
    Route::get('order/show/finished',[OrderController::class,'showOrderFinished']);
    Route::post('order/create',[OrderController::class,'createOrder']);
    Route::put('order/editstatus/{id}',[OrderController::class,'editStatus']);
    Route::put('order/editvoucher/{id}',[OrderController::class,'editVoucher']);

    Route::get('order/isExpired',[OrderController::class,'isExpiredOrder']);

    //Detail Order
    Route::get('orderdetail/show/{id_order}',[OrderDetailController::class,'showDetailOrder']);
    Route::post('orderdetail/create',[OrderDetailController::class,'createDetailOrder']);
    
    //Payment
    Route::get('payment/show/{id_order}',[PaymentController::class,'showPaymentByOrder']);
    Route::post('payment/create',[PaymentController::class,'createPayment']);

    //Feed Posting
    Route::get('feed/showall/{start}/{end}',[FeedController::class,'showAllFeed']);
    Route::get('feed/showownfeed',[FeedController::class,'showOwnFeed']);
    Route::post('feed/create',[FeedController::class,'createFeed']);
    Route::put('feed/editFeed/{id}',[FeedController::class,'editFeed']);
    Route::delete('feed/deleteFeed/{id}',[FeedController::class,'deleteFeed']);
    Route::get('feed/showfeedbyid/{id}',[FeedController::class,'showMerchantFeedById']); //Show Feed By Merchant Id
    Route::get('feed/showbestseller/{limit}',[FeedController::class,'showFeedBestSellerProduct']);
    Route::get('feed/showrandom/{limit}',[FeedController::class,'showFeedRandom']);
    Route::get('feed/showbyuserid/{id}',[FeedController::class,'showFeedByUserId']);
    Route::get('feed/showfeedbymerchantcategory/{id}',[FeedController::class,'showFeedByMerchantCategory']);

    //Comment
    Route::get('comment/showcommentbyid/{id_feed}',[CommentController::class,'showComment']);
    Route::post('comment/createcomment',[CommentController::class,'createComment']);
    Route::put('comment/editcomment/{id}',[CommentController::class,'editComment']);
    Route::delete('comment/deletecomment/{id}',[CommentController::class,'deleteComment']);

    //Voucher
    Route::get('voucher/showall',[VoucherController::class,'showVoucher']);
    Route::get('voucher/usevoucher/{id}',[VoucherController::class,'useVoucher']);
    Route::get('voucher/check/{code}',[VoucherController::class,'checkVoucher']);

    //Following
    Route::get('following/followlist',[FollowingController::class,'followList']);
    Route::get('following/follow/{id_merchant}',[FollowingController::class,'follow']);
    Route::get('following/unfollow/{id_merchant}',[FollowingController::class,'unfollow']);
    Route::get('following/checkstatus/{id_merchant}',[FollowingController::class,'checkStatus']);
    Route::get('following/countFollowersMerchant/{id_merchant}',[FollowingController::class,'countFollowersMerchant']);
    Route::get('following/countFollowingUser',[FollowingController::class,'countFollowingUser']);

    //Following User
    Route::get('followinguser/countfollowinguser/{id}',[FollowingUserController::class,'countFollowersUser']);
    Route::get('followinguser/countfollowersuser/{id}',[FollowingUserController::class,'countFollowersUser']);

    
    Route::get('followinguser/follow/{id}',[FollowingUserController::class,'follow']);
    Route::get('followinguser/unfollow/{id}',[FollowingUserController::class,'unfollow']);
    Route::get('followinguser/checkstatus/{id}',[FollowingUserController::class,'checkStatus']);

    //Merchant Category
    Route::get('merchant_category/showall/',[MerchantCategoryController::class,'showMerchantDisplayById']);
    Route::get('merchant_category/showbyid/{id}',[MerchantCategoryController::class,'showProductByMerchantCategory']);

    //Review Merchant
    Route::get('review_merchant/showbyidmerchant/{idMerchant}',[ReviewMerchantController::class,'getReviewByIdMerchant']);
    Route::post('review_merchant/create',[ReviewMerchantController::class,'createReviewMerchant']);
    Route::get('review_merchant/avgreview/{idMerchant}',[ReviewMerchantController::class,'countAverageReviewMerchant']);
    Route::get('check_review_merchant/{idMerchant}',[ReviewMerchantController::class,'checkReviewMerchantDone']);
    //Review Product
    Route::post('review_product/create',[ReviewProductController::class,'createReviewProduct']);
    Route::get('review_product/showbyidproduct/{idProduct}',[ReviewProductController::class,'getReviewByIdProduct']);
    Route::get('review_product/avg/{id_product}',[ReviewProductController::class,'avgReviewPerMerchant']);

    //Report Product
    Route::post('report_product/create',[ReportProductController::class,'createReportProduct']);
    Route::delete('report_product/delete/{id_product}',[ReportProductController::class,'deleteReportProduct']);
    Route::get('report_product/check/{id_product}',[ReportProductController::class,'checkReportProduct']);

    //Report Feed
    Route::post('report_feed/create',[ReportFeedController::class,'createReportFeed']);
    Route::delete('report_feed/delete/{id_feed}',[ReportFeedController::class,'deleteReportFeed']);
    Route::get('report_feed/check/{id_feed}',[ReportFeedController::class,'checkReportFeed']);
    
    //Operational Hours
    Route::get('operational_hours/get/{idMerchant}',[OperationalHoursController::class,'getOperational']);

    //App Content
    Route::get('app_content/main_page',[AppContentController::class,'showMainAppContent']);
    Route::get('app_content/merchant_category/{id_merchant_category}',[AppContentController::class,'showMerchantCategoryAppContent']);
    Route::get('app_content/main_page_format',[AppContentController::class,'showMainAppContentFormat']);
    
    //Feed Like
    Route::post('feed_like/create/{id_feed}',[FeedLikeController::class,'create']);
    Route::delete('feed_like/delete/{id_feed}',[FeedLikeController::class,'delete']);
    Route::get('feed_like/check/{id_feed}',[FeedLikeController::class,'check']);

    //Wishlist Status
    Route::post('wishlist_saved/create/{id_product}',[WishlistSavedController::class,'create']);
    Route::delete('wishlist_saved/delete/{id_product}',[WishlistSavedController::class,'delete']);
    Route::get('wishlist_saved/check/{id_product}',[WishlistSavedController::class,'check']);
    
    //App Content Merchant
    Route::get('app_content/merchant/{id_merchant}',[MerchantBannerController::class,'getMerchBanner']);


    //php artisan serve --host 0.0.0.0 for Emulator Android Windows
    //php artisan key:generate kalo instal env baru

    //TODO: Carousel per Merchant App Content
});