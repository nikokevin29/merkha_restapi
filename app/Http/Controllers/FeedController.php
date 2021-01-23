<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feed;

class FeedController extends Controller
{
    public function showAllFeed(){
        $data = Feed::orderBy('created_at','DESC')->get();

        $getAll = [];
        foreach($data as $datas){
            array_push(
                $getAll,[
                    'id_user'       => $datas->id_user,
                    'merchant'      => $datas->getMerchant->name,
                    'product'       => $datas->getProduct->product_name,
                    'like_count'    => $datas->like_count,
                    'url_image'     => $datas->url_image,
                    'caption'       => $datas->caption,
                    'location'      => $datas->location,
                    'report_count'  => $datas->report_count,
                    'created_at'    => $datas->created_at,
                    'updated_at'    => $datas->updated_at,
                ]
            );
        }
        return ResponseFormatter::success($getAll,'Show all Feed');
    }
    public function createFeed(Request $request){
        $user               = Auth::user()->id;//get user id login
        $input              = $request->all();
        $input['id_user']   = $user;
        $feed               = Feed::create($input);


        return ResponseFormatter::success($feed,'Feed Created');
    }
}
