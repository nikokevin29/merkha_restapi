<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\ProductPhoto;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showAll(){
        $datas = Product::all();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show All Product');
    }
    public function showByCategory($id){
        $datas = Product::where('id_category',$id)->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ?? '',
                'photo'         =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Product By id '.$id.' Success');
    }
    public function showDiscover($limit){//Random Show By limit
        $datas = Product::inRandomOrder()->take($limit)->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show All Product By Limit Discover');
    }
    public function showByMerchant($id){
        $datas = Product::where('id_merchant',$id)->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Product By Merchant '.$id);
    }
    public function showByOrder($limit,$order){
        $datas = Product::orderBy('created_at', $order)->take($limit)->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
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
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Best Seller Limit By '.$limit);
    }
    public function searchByProductName($productName){
        $datas = Product::query()->where('product_name','like','%'.$productName.'%')->get();
        $getAll = [];
        foreach($datas as $data)
        {
            //get Array Photo
            $photo = [];
            foreach($data->getPhoto as $keys => $getPhotos) {
                $photo[$keys] = $getPhotos->url_photo;
            }
            array_push($getAll,[
                'id'            =>$data->id,
                'category'      =>$data->getCategory->category_name,
                'merchant_id'   =>$data->getMerchant->id,
                'merchant'      =>$data->getMerchant->name,
                'product_name'  =>$data->product_name,
                'description'   =>$data->description,
                'price'         =>$data->price,
                'color'         =>$data->color,
                'size'          =>$data->size,
                'stock'         =>$data->stock,
                'weight'        =>$data->weight,
                'created_at'    =>$data->created_at,
                'updated_at'    =>$data->updated_at,
                'report_count'  =>$data->report_count,
                'preview'       =>$getPhotos->url_photo ??'',
                'photo'         =>$photo,
                ]);
        }
        return ResponseFormatter::success($getAll,'Seach By Product Name '.$productName);
    }
}
