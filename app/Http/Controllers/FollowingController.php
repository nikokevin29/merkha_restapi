<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Following;

class FollowingController extends Controller
{
    public function follow(Request $request,$id_merchant){
        $user = Auth::user()->id;
        $input = $request->all();
        $input['id_user'] = $user;
        $input['following'] = $id_merchant;
        $data = Following::create($input);
        return ResponseFormatter::success($data,'Following '.$id_merchant);
    }
    public function unfollow(Request $request,$id_merchant){
        $user = Auth::user()->id;
        $id = Following::where('id_user',$user)
        ->where('following',$id_merchant)
        ->delete();
        return ResponseFormatter::success($id,'Unfollow success');
    }
    
}
