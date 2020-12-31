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
}
