<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feed;
use DB;
class FeedController extends Controller
{
    public function showAllFeed(){// By User Followed (Only Merchant)
        $user = Auth::user();
        $merchantFeed = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('merchant','merchant.id','feed.id_merchant')
        ->join('following','feed.id_merchant','following.following')
        ->where('feed.paused','!=','1')
        ->where('following.id_user',$user->id)
        ->get();
        
        $userFeed = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.username as merchant_name',
            'user.url_photo as merchant_logo',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('user','user.id','feed.id_user')
        ->where('feed.paused','!=','1')
        ->get();

        $allFeed = array_merge($merchantFeed->toArray(), $userFeed->toArray()); //Merge 2 Select 
        
        return ResponseFormatter::success($allFeed,'Show all Feed Followed by '.$user->username);
    }
    public function createFeed(Request $request){
        $user               = Auth::user()->id;//get user id login
        $input              = $request->all();
        $input['id_user']   = $user;
        $feed               = Feed::create($input);
        return ResponseFormatter::success($feed,'Feed Created');
    }
    public function editFeed(Request $request,$id){
        $data = Feed::where('id',$id)->update($request->all());
        return ResponseFormatter::success($data,'Feed Updated');
    }
    public function deleteFeed(Feed $id){
        $id->delete();
        return ResponseFormatter::success($id,'Comment Deleted');
    }
    public function showOwnFeed(Request $request){
        $user = Auth::user();
        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.username as merchant_name',
            'user.url_photo as merchant_logo',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('user','user.id','feed.id_user')
        ->where('feed.paused','!=','1')
        ->where('feed.id_user',$user->id)
        ->get();
        return ResponseFormatter::success($datas,'Show all Feed Own of '.$user->username);
    }
    public function showMerchantFeedById($id){
        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('merchant','merchant.id','feed.id_merchant')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->where('feed.id_merchant',$id)
        ->get();
        return ResponseFormatter::success($datas,'Show Feed By Merchant');
    }
    public function showFeedBestSellerProduct($limit){
        $datas = DB::table('feed')->orderBy('quantity_sold','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->selectRaw('SUM(order_detail.amount) AS quantity_sold')
        ->groupBy(['product.id']) 
        ->join('product','product.id','feed.id_product')
        ->join('order_detail', 'order_detail.id_product', '=', 'product.id')
        ->join('merchant','merchant.id','feed.id_merchant')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->take($limit)
        ->get();
        return ResponseFormatter::success($datas,'Show Feed By Best Seller And Limit = '.$limit);
    }
    public function showFeedRandom($limit){
        $datas = DB::table('feed')->orderBy(DB::raw('RAND()'))
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('merchant','merchant.id','feed.id_merchant')
        ->join('following','feed.id_merchant','following.following')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->take($limit)
        ->get();
        return ResponseFormatter::success($datas,'Show Feed Random And Limit = '.$limit);
    }

    public function showFeedByUserId($id){
        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.username as merchant_name',
            'user.url_photo as merchant_logo',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('user','user.id','feed.id_user')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->where('feed.id_user', $id)
        ->get();
        return ResponseFormatter::success($datas,'Show all Feed By Specific User');
    }

}
