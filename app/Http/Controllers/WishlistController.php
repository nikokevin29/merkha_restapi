<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use DB;
class WishlistController extends Controller
{
    public function show(){
        $user_auth = Auth::user()->id;
        $product = Wishlist::join('product','wishlist.id_product','=','product.id')
        ->where('wishlist.id_user',$user_auth)
        ->get();
        $getAll = [];
        foreach($product as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id_product,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'product_name'     =>$data->product_name,
                'description'      =>$data->description,
                'price'            =>$data->price,
                'color'            =>$data->color,
                'size'             =>$data->size,
                'stock'            =>$data->stock,
                'weight'           =>$data->weight,
                'created_at'       =>$data->created_at,
                'updated_at'       =>$data->updated_at,
                'report_count'     =>$data->report_count,
                'preview'          =>$getPhotos->url_photo ?? '',
                'photo'            =>$photo,
                ]);
        }
        return ResponseFormatter::success($getAll,'Wishlist Showed by user login');
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
    public function delete($id){
        $search_id = Wishlist::where('id_user', Auth::user()->id)->where('id_product',$id)->delete();
        return ResponseFormatter::success($search_id,'Wishlist Deleted');
    }
}
