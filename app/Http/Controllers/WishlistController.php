<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use DB;
class WishlistController extends Controller
{
    public function show(){
        //show All Wishlist by login user
        $user = Auth::user();
        $datas = Wishlist::where('id_user',$user->id)->get();
        $get = [];
        array_push($get,[
            'user' =>$user,
            'product'=>$datas->load('getProduct')
        ]);
        //$get = collect(['user' =>$user,'product' => $datas->load('getProduct')->toArray()]);
        
        return ResponseFormatter::success($get,'Wishlist Showed by user login');
    }
    public function add(Request $request){
        
        $input = $request->all();
        $validator = Validator::make($input,[
            'id_product' => 'required',
            ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Adding Wishlist Failed', 401);     
        }
        $id = Auth::user()->id;//get id login
        $input['id_user'] = $id;
        $data = Wishlist::create($input);
        return ResponseFormatter::success($data,'Wishlist Added');
    }
    public function delete(Wishlist $id){
        
        return ResponseFormatter::success($id->delete(),'Wishlist Deleted');
    }
}
