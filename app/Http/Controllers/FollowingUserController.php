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
    public function countFollowersUser($idOtherUser){
        $count = FollowingUser::where('id_user',$idOtherUser)->count();
        return $count;
    }
}
