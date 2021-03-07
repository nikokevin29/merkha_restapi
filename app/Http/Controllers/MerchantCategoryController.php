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
        ->where('hide','!=','1')
        ->get();
        return ResponseFormatter::success($data,'Show Merchant Category by id merchant Category');
    }
    public function showProductByMerchantCategory($ids){
        $datas = DB::table('product')
        ->select('product.id',
        'product_category.category_name as category',
        'merchant.name as merchant',
        'merchant.province as merchant_location',
        'merchant.website',
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
        'product_photo.url_photo as preview',
        )
        ->join('merchant','merchant.id','product.id_merchant')
        ->join('product_category','product_category.id','product.id_category')
        ->join('product_photo','product_photo.id','product.id')
        ->where('waiting_status','=','0')
        ->where('product.paused','!=','1')
        ->where('merchant.id_merchant_category',$ids)
        ->get();
        return ResponseFormatter::success($datas,'Show Product By Merchant Category');
        
    }
}
