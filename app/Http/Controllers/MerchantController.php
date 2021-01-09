<?php

namespace App\Http\Controllers;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
class MerchantController extends Controller
{
    public function showByRandom($limit){
        $datas = Merchant::inRandomOrder()
        ->where('merchant_id','<>','0')
        ->join('user','user.id','=','merchant.id_user')
        ->take($limit)
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            array_push($getAll,[
                'id_user'               =>$data->id_user,
                'merchant_id'           =>$data->merchant_id,
                'business_type'         =>$data->getBusinessType->business_name,
                'merchant_category'     =>$data->getMerchantCategory->category_name,
                'merchant_name'         =>$data->name,
                'address'               =>$data->address,
                'email'                 =>$data->email,
                'phone_number'          =>$data->phone_number,
                'status'                =>$data->status,
                'bio'                   =>$data->bio,
                'followers_count'       =>$data->followers_count,
                'following_count'       =>$data->following_count,
                'url_photo'             =>$data->url_photo,
                'created_at'            =>$data->created_at->format('Y-m-d H:i:s'),
                'updated_at'            =>$data->updated_at->format('Y-m-d H:i:s'),
                ]);
        }   
        return ResponseFormatter::success($getAll,'Show Random Limit By '.$limit);
    }
    public function showById($id){//show merchant by id user
        $datas = Merchant::where('id_user',$id)
        ->where('merchant_id','<>','0')
        ->join('user','user.id','=','merchant.id_user')
        ->get();
        $getAll = [];
        foreach($datas as $data)
        {
            array_push($getAll,[
                'id_user'               =>$data->id_user,
                'merchant_id'           =>$data->merchant_id,
                'business_type'         =>$data->getBusinessType->business_name,
                'merchant_category'     =>$data->getMerchantCategory->category_name,
                'merchant_name'         =>$data->name,
                'address'               =>$data->address,
                'email'                 =>$data->email,
                'phone_number'          =>$data->phone_number,
                'status'                =>$data->status,
                'bio'                   =>$data->bio,
                'followers_count'       =>$data->followers_count,
                'following_count'       =>$data->following_count,
                'url_photo'             =>$data->url_photo,
                'created_at'            =>$data->created_at->format('Y-m-d H:i:s'),
                'updated_at'            =>$data->updated_at->format('Y-m-d H:i:s'),
                ]);
        }  
        return ResponseFormatter::success($getAll,'Show Merchant By '.$id); 
    }
    public function searchByMerchantName($merchantName){
        if($merchantName == null){
            $datas = Merchant::query()->join('user','user.id','=','merchant.id_user')->get();
        }
        else{
            $datas = Merchant::query()
            ->where('name','like','%'.$merchantName.'%')
            ->join('user','user.id','=','merchant.id_user')->get();
        }
        $getAll = [];
        foreach($datas as $data)
        {
            array_push($getAll,[
                'id_user'               =>$data->id_user,
                'merchant_id'           =>$data->merchant_id,
                'business_type'         =>$data->getBusinessType->business_name,
                'merchant_category'     =>$data->getMerchantCategory->category_name,
                'merchant_name'         =>$data->name,
                'address'               =>$data->province,
                'email'                 =>$data->email,
                'phone_number'          =>$data->phone_number,
                'status'                =>$data->status,
                'bio'                   =>$data->bio,
                'followers_count'       =>$data->followers_count,
                'following_count'       =>$data->following_count,
                'url_photo'             =>$data->url_photo,
                'created_at'            =>$data->created_at->format('Y-m-d H:i:s'),
                'updated_at'            =>$data->updated_at->format('Y-m-d H:i:s'),
                ]);
        }
        return ResponseFormatter::success($getAll,'Seach By Merchant Name ');
    }
}
