<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feed;
use DB;
class FeedController extends Controller
{
    public function showAllFeed($start,$end){// By User Followed (Only Merchant)
        $user = Auth::user();
        $merchantFeed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->rightjoin('product','product.id','feed.id_product')
        ->rightJoin('merchant','merchant.id','feed.id_merchant')
        ->rightjoin('user','feed.id_user','user.id')
        ->rightJoin('following','feed.id_merchant','following.following') // following merchant
        ->rightJoin('following_user','feed.id_user','following_user.following_users')//following user
        ->where('feed.paused','!=','1')
        //->where('product.paused','!=','1')
        ;
        
        $Feed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->leftjoin('product','product.id','feed.id_product')
        ->leftJoin('merchant','merchant.id','feed.id_merchant')
        ->leftJoin('user','feed.id_user','user.id')
        ->leftJoin('following','feed.id_merchant','following.following')
        ->leftJoin('following_user','feed.id_user','following_user.following_users')
        ->where('feed.paused','!=','1')
        //->where('product.paused','!=','1')
        ->where('following.id_user',$user->id)//merchant
        ->orWhere('following_user.id_user',$user->id)//other user
        ->union($merchantFeed)
        ->skip($start)
        ->take($end);
        
        return ResponseFormatter::success($Feed->orderBy('created_at','DESC')->get(),'Show all Feed Followed by '.$user->username.' total : '.$Feed->count());
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
        $data = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.username as merchant_username',
            'user.url_photo as merchant_logo',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location',
            'feed.created_at'
        )
        ->leftjoin('product','product.id','feed.id_product')
        ->join('user','user.id','feed.id_user')
        //->Where('product.paused','!=','1')
        ->where('feed.id_user',$user->id);

        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.username as merchant_username',
            'user.url_photo as merchant_logo',
            'product.product_name',
            'product.price',
            'like_count',
            'url_image',
            'caption',
            'location',
            'feed.created_at'
        )
        ->rightjoin('product','product.id','feed.id_product')
        ->join('user','user.id','feed.id_user')
        //->where('product.paused','!=','1')
        ->where('feed.paused','!=','1')
        ->where('feed.id_user',$user->id)
        ->union($data);
        return ResponseFormatter::success($datas->orderBy('created_at','DESC')->get(),'Show all Feed Own of '.$user->username);
    }
    public function showMerchantFeedById($id){
        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'merchant.username as merchant_username',
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
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'product.paused',
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
        //->where('product.paused','!=','1')
        ->take($limit)
        ->get();
        return ResponseFormatter::success($datas,'Show Feed By Best Seller And Limit = '.$limit);
    }
    public function showFeedRandom($limit){

        $merchantFeed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->rightjoin('product','product.id','feed.id_product')
        ->rightJoin('merchant','merchant.id','feed.id_merchant')
        ->rightjoin('user','feed.id_user','user.id')
        ->rightJoin('following','feed.id_merchant','following.following') // following merchant
        ->rightJoin('following_user','feed.id_user','following_user.following_users')//following user
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1');
        
        $Feed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->leftjoin('product','product.id','feed.id_product')
        ->leftJoin('merchant','merchant.id','feed.id_merchant')
        ->leftJoin('user','feed.id_user','user.id')
        ->leftJoin('following','feed.id_merchant','following.following')
        ->leftJoin('following_user','feed.id_user','following_user.following_users')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->union($merchantFeed)
        // ->skip($start)
        ->take($limit);
        return ResponseFormatter::success($Feed->orderBy(DB::raw('RAND()'))->get(),'Show Feed Random And Limit = '.$limit);
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

    public function showFeedByMerchantCategory($id){
        $merchantFeed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->rightjoin('product','product.id','feed.id_product')
        ->rightJoin('merchant','merchant.id','feed.id_merchant')
        ->rightjoin('user','feed.id_user','user.id')
        ->rightJoin('following','feed.id_merchant','following.following') // following merchant
        ->rightJoin('following_user','feed.id_user','following_user.following_users')//following user
        ->where('feed.paused','!=','1')
        ->where('merchant.id_merchant_category',$id)
        ->where('product.paused','!=','1');
        
        $Feed = DB::table('feed')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'feed.id_product',
            'user.url_photo',
            'user.username',
            'merchant.username as merchant_username',
            'merchant.name as merchant_name',
            'merchant.merchant_logo',
            'merchant.last_access',
            'merchant.description',
            'merchant.website',
            'product.product_name',
            'product.price',
            'feed.like_count',
            'feed.url_image',
            'feed.caption',
            'feed.location',
            'feed.created_at'
        )
        ->leftjoin('product','product.id','feed.id_product')
        ->leftJoin('merchant','merchant.id','feed.id_merchant')
        ->leftJoin('user','feed.id_user','user.id')
        ->leftJoin('following','feed.id_merchant','following.following')
        ->leftJoin('following_user','feed.id_user','following_user.following_users')
        ->where('feed.paused','!=','1')
        ->where('product.paused','!=','1')
        ->where('merchant.id_merchant_category',$id)
        ->union($merchantFeed);
        return ResponseFormatter::success($Feed->orderBy(DB::raw('RAND()'))->get(),'Show By Merchant Category');
    }

}
