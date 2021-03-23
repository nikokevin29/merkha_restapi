<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Following;
use App\Models\FollowingUser;

class FollowingUserController extends Controller
{
    public function countFollowingUser($idOtherUser){
        $count = FollowingUser::where('id_user',$idOtherUser)->count();
        return $count;
    }
    public function countFollowersUser($id){
        $count = FollowingUser::where('following_users',$id)->count();
        return $count;
    }

    public function follow(Request $request,$idOtherUser){
        $user = Auth::user()->id;
        $isExist = FollowingUser::where('id_user',$user)
        ->where('following_users',$idOtherUser)
        ->count();
        if($isExist != 0){
            return ResponseFormatter::error(['id' => null],'Merchant Already Followed', 409);
        }
        $input = $request->all();
        $input['id_user'] = $user;
        $input['following_users'] = $idOtherUser;
        $data = FollowingUser::create($input);
        return ResponseFormatter::success($data,'Following '.$idOtherUser);
    }
    public function unfollow(Request $request,$idOtherUser){
        $user = Auth::user()->id;
        $id = FollowingUser::where('id_user',$user)
        ->where('following_users',$idOtherUser)
        ->delete();
        return ResponseFormatter::success($id,'Unfollow success');
    }

    public function checkStatus(Request $request,$idOtherUser){
        $id_user = Auth::user()->id;
        $check = FollowingUser::where('id_user',$id_user)
        ->where('following_users',$idOtherUser)
        ->first();
        if(empty($check)){
            return 0;
        }
        return $check->following;
    }
}
