<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feed;
use DB;
class FeedController extends Controller
{
    public function showAllFeed(){
        $user = Auth::user()->id;
        $datas = DB::table('feed')->orderBy('feed.created_at','DESC')
        ->select(
            'feed.id',
            'feed.id_user',
            'feed.id_merchant',
            'merchant.name as merchant_name',
            'product.product_name',
            'like_count',
            'url_image',
            'caption',
            'location'
        )
        ->join('product','product.id','feed.id_product')
        ->join('merchant','merchant.id','feed.id_merchant')
        ->join('following','feed.id_merchant','following.following')
        ->where('feed.paused','!=','1')
        ->where('following.id_user',$user)
        ->get();
        return ResponseFormatter::success($datas,'Show all Feed');
    }
    public function createFeed(Request $request){
        $user               = Auth::user()->id;//get user id login
        $input              = $request->all();
        $input['id_user']   = $user;
        $feed               = Feed::create($input);


        return ResponseFormatter::success($feed,'Feed Created');
    }
}
