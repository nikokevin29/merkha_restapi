<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Following;

class FollowingController extends Controller
{
    public function followList(Request $request){
        $data = Following::where('id_user',Auth::user()->id)->get();
        return ResponseFormatter::success($data,'Show All by User');
    }
    public function follow(Request $request,$id_merchant){
        $user = Auth::user()->id;
        $isExist = Following::where('id_user',$user)
        ->where('following',$id_merchant)
        ->count();
        if($isExist != 0){
            return ResponseFormatter::error(['id' => null],'Merchant Already Followed', 409);
        }
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

    public function checkStatus(Request $request,$id_merchant){
        $id_user = Auth::user()->id;
        $check = Following::where('id_user',$id_user)
        ->where('following',$id_merchant)
        ->first();
        if(empty($check)){
            return ResponseFormatter::error([
                'id' => null,
                'following'=> null,
                'message' => 'Merchant Not Found',
                'error' => $check,
            ],'Merchant Not Found', 404);
        }
        return ResponseFormatter::success($check,'Check Done');

    }
    //note: return not Formated( just number)
    public function countFollowersMerchant($idMerchant){
        $count = Following::where('following',$idMerchant)->count();
        return $count;
    }
}
