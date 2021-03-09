<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WishlistSaved;

class WishlistSavedController extends Controller
{
    public function create(Request $request,$id_product){
        $user = Auth::user()->id;
        $isExist = WishlistSaved::where('id_user',$user)
        ->where('id_product',$id_product)
        ->count();
        if($isExist != 0){
            return ResponseFormatter::error(['id' => null],'Already Added In Wishlist', 409);
        }
        $input = $request->all();
        $input['id_user'] = $user;
        $input['id_product'] = $id_product;
        $data = WishlistSaved::create($input);
        
        return ResponseFormatter::success($data,' Success = '.$id_product);
    }
    public function delete($id_product){
        $user = Auth::user()->id;
        $id = WishlistSaved::where('id_user',$user)
        ->where('id_product',$id_product)
        ->delete();

        return ResponseFormatter::success($id,'Delete Wishlist Success');
    }
    public function check(Request $request,$id_product){
        $id_user = Auth::user()->id;
        $check = WishlistSaved::where('id_user',$id_user)
        ->where('id_product',$id_product)
        ->first();
        if(empty($check)){
            return 0;
        }
        return $check->id_product;
    }
}
