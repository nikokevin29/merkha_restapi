<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInterest;

class UserInterestController extends Controller
{
    public function add_user_interest(Request $request, $value){
        $user = Auth::user()->id;
        $input = $request->all();
        $input['id_user'] = $user;
        $input['id_category'] = $value;
        $data = UserInterest::create($input);
        return ResponseFormatter::success($data,'Category '.$value.' Added');
    }
    public function show_user_interest(Request  $request){
        $user = Auth::user()->id;
        $datas = UserInterest::all()->where('id_user',$user);
        $getAll = [];
        foreach($datas as $data){
            $d = [];
            foreach($data->getCategory as $keys => $get) {
                $d[$keys] = $get;
            }
            array_push($getAll,[
                'id_category'  =>$data->id_category,
                'category'     =>$get->category_name,
                'url_icon'     =>$get->url_icon,
            ]);
        }
        return ResponseFormatter::success($getAll,'User Interest Showed');
    }
}
