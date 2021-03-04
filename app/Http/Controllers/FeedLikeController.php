<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FeedLike;
use App\Models\Feed;
class FeedLikeController extends Controller
{
    public function create(Request $request,$id_feed){
        $user = Auth::user()->id;
        $isExist = FeedLike::where('id_user',$user)
        ->where('id_feed',$id_feed)
        ->count();
        if($isExist != 0){
            return ResponseFormatter::error(['id' => null],'Already Liked', 409);
        }
        $input = $request->all();
        $input['id_user'] = $user;
        $input['id_feed'] = $id_feed;
        $data = FeedLike::create($input);
        Feed::where('id',$id_feed)->increment('like_count',1);
        return ResponseFormatter::success($data,'Liked idFeed = '.$id_feed);
    }
    public function delete($id_feed){
        $user = Auth::user()->id;
        $id = FeedLike::where('id_user',$user)
        ->where('id_feed',$id_feed)
        ->delete();
        Feed::where('id',$id_feed)->decrement('like_count',1);
        return ResponseFormatter::success($id,'Unlike Feed Success');
    }
    public function check(Request $request,$id_feed){
        $id_user = Auth::user()->id;
        $check = FeedLike::where('id_user',$id_user)
        ->where('id_feed',$id_feed)
        ->first();
        if(empty($check)){
            return 0;
        }
        return $check->id_feed;
    }
}
