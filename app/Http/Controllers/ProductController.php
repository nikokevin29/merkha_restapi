<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\ProductPhoto;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{
    public function showAll(){
        $datas = Product::where('paused','!=','1')->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show All Product');
    }
    public function showByCategory($id){
        $datas = Product::where('id_category',$id)
        ->where('paused','!=','1')
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Product By id '.$id.' Success');
    }
    public function showDiscover($limit){//Random Show By limit
        $datas = Product::inRandomOrder()->where('product.paused','!=','1')->take($limit)->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show All Product By Limit Discover');
    }
    public function showByMerchant($id){
        $datas = Product::where('id_merchant',$id)->where('paused','!=','1')->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Product By Merchant '.$id);
    }
    public function showByOrder($limit,$order){
        $datas = Product::orderBy('created_at', $order)
        ->where('paused','!=','1')
        ->take($limit)
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show By Order '.$order.' Limit By '.$limit);
    }
    public function showByBestseller($limit){
        $datas = Product::query()
        ->join('order_detail', 'order_detail.id_product', '=', 'product.id')
        ->selectRaw('product.*, SUM(order_detail.amount) AS quantity_sold')
        ->groupBy(['product.id']) // should group by primary key
        ->orderByDesc('quantity_sold')
        ->where('paused','!=','1')
        ->take($limit)
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Best Seller Limit By '.$limit);
    }
    public function searchByProductName($productName){
        $datas = Product::query()
        ->where('product_name','like','%'.$productName.'%')
        ->where('paused','!=','1')
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }
        return ResponseFormatter::success($getAll,'Seach By Product Name '.$productName);
    }
    public function showById($id){
        $product = Product::where('id',$id)
        ->where('paused','!=','1')
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
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        if($getAll == []){
            $getAll = null;
        }
        return ResponseFormatter::success($getAll,'Show By Id '.$id);
    }
    public function showByMerchantCategory($id){
        $product = Product::where('merchant.id_merchant_category',$id)
        ->join('merchant','product.id_merchant','merchant.id')
        ->join('product_photo','product.id','product_photo.id_product')
        ->where('product.paused','!=','1')
        ->groupBy('product_photo.id_product')
        ->get();
        $getAll = [];
        foreach($product as $data)
        {
            array_push($getAll,[
                'id'               =>$data->id_product,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
                'product_name'     =>$data->product_name,
                'description'      =>Product::where('id',$data->id_product)->pluck('description')->first(),
                'price'            =>$data->price,
                'color'            =>$data->color,
                'size'             =>$data->size,
                'stock'            =>$data->stock,
                'weight'           =>$data->weight,
                'created_at'       =>$data->created_at,
                'updated_at'       =>$data->updated_at,
                'report_count'     =>$data->report_count,
                'preview'          =>ProductPhoto::where('id_product',$data->id_product)->pluck('url_photo')->first(),
                'photo'            =>ProductPhoto::where('id_product',$data->id_product)->pluck('url_photo')->toArray(),
                ]);
        } 
        return ResponseFormatter::success($getAll,'Show By Merchant Category');
    }
    public function showBestSellerById($id){
        $datas = Product::query()
        ->join('order_detail', 'order_detail.id_product', '=', 'product.id')
        ->selectRaw('product.*, SUM(order_detail.amount) AS quantity_sold')
        ->groupBy(['product.id']) // should group by primary key
        ->orderByDesc('quantity_sold')
        ->where('paused','!=','1')
        ->where('product.id_merchant',$id)
        ->take(6)
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Best Seller By Merchant ');
    }

    public function searchProductByMerchant($productName,$idMerchant){
        $datas = Product::query()
        ->where('product_name','like','%'.$productName.'%')
        ->where('paused','!=','1')
        ->where('id_merchant','=',$idMerchant)
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'               =>$data->id,
                'category'         =>$data->getCategory->category_name,
                'merchant_id'      =>$data->getMerchant->id,
                'website'          =>$data->getMerchant->website,
                'merchant'         =>$data->getMerchant->name,
                'merchant_location'=>$data->getMerchant->province,
                'merchant_logo'    =>$data->getMerchant->merchant_logo,
                'id_province'      =>$data->getMerchant->id_province,
                'id_city'          =>$data->getMerchant->id_city,
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
                'preview'          =>$getPhotos->url_photo ??'',
                'photo'            =>$photo,
                ]);
        }
        return ResponseFormatter::success($getAll,'Seach By Product Name '.$productName);
    }

    public function increaseViewProduct($id,Request $request){
        Product::where('id',$id)->increment('viewed',1);
        return null;
    }

    
}
