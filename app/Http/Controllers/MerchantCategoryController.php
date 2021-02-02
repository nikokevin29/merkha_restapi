<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\ProductPhoto;
use App\Models\MerchantCategory;
use DB;

class MerchantCategoryController extends Controller
{
    public function showMerchantDisplayById(){
        $data = DB::table('merchant_category')
        ->get();
        return ResponseFormatter::success($data,'Show Merchant Category by id merchant Category');
    }
    public function showProductByMerchantCategory($ids){
        $datas = DB::table('product')
        ->select('product.id',
        'product_category.category_name as category',
        'merchant.merchant_id as merchant',
        'merchant.province as merchant_location',
        'merchant.merchant_logo',
        'merchant.id_province',
        'merchant.id_city',
        'product.product_name',
        'product.description',
        'product.price',
        'product.color',
        'product.size',
        'product.stock',
        'product.weight',
        'product_photo.url_photo as preview'
        )
        ->join('merchant','merchant.id','product.id_merchant')
        ->join('product_category','product_category.id','product.id_category')
        ->join('product_photo','product_photo.id','product.id')
        ->where('product.paused','!=','1')
        ->where('merchant.id_merchant_category',$ids)
        ->get();
        // return $datas;
        // $getAll = [];
        // foreach($datas as $data)
        // {
        //     //get Array Photo
        //     $photo = [];
        //     foreach($data->getPhoto as $keys => $getPhotos) {
        //         $photo[$keys] = $getPhotos->url_photo;
        //     }
        //     array_push($getAll,[
        //         'id'               =>$data->id,
        //         'category'         =>$data->getCategory->category_name,
        //         'merchant_id'      =>$data->getMerchant->id,
        //         'website'          =>$data->getMerchant->website,
        //         'merchant'         =>$data->getMerchant->name,
        //         'merchant_location'=>$data->getMerchant->province,
        //         'merchant_logo'    =>$data->getMerchant->merchant_logo,
        //         'id_province'      =>$data->getMerchant->id_province,
        //         'id_city'          =>$data->getMerchant->id_city,
        //         'product_name'     =>$data->product_name,
        //         'description'      =>$data->description,
        //         'price'            =>$data->price,
        //         'color'            =>$data->color,
        //         'size'             =>$data->size,
        //         'stock'            =>$data->stock,
        //         'weight'           =>$data->weight,
        //         'created_at'       =>$data->created_at,
        //         'updated_at'       =>$data->updated_at,
        //         'report_count'     =>$data->report_count,
        //         'preview'          =>$getPhotos->url_photo ??'',
        //         'photo'            =>$photo,
        //         ]);
            return ResponseFormatter::success($datas,'Show Product By Merchant Category');
        
    }
}
