<?php

namespace App\Http\Controllers;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use DB;
class MerchantController extends Controller
{
    public function showByRandom($limit){
        $datas = DB::table('user')
        ->join('merchant','user.id','merchant.id_user')
        ->select(
            'user.id as id_user',
            'merchant.id as id_merchant',
            'merchant.name',
            'merchant.merchant_logo',
            'merchant.description',
            'province',
            'city',
            'country',
            'followers_count',
            'merchant.created_at',
            'merchant.updated_at',
            'last_access',
            'active_status')
        ->where('merchant.paused','!=','1')
        ->limit($limit)
        ->inRandomOrder()
        ->get();
        return ResponseFormatter::success($datas,'Show Random Limit By '.$limit);
    }
    public function showById($id){//show merchant by id user
        $datas = DB::table('user')
        ->join('merchant','user.id','merchant.id_user')
        ->select(
            'user.id as id_user',
            'merchant.id as id_merchant',
            'merchant.name',
            'merchant.merchant_logo',
            'merchant.description',
            'province',
            'city',
            'country',
            'followers_count',
            'merchant.created_at',
            'merchant.updated_at',
            'last_access',
            'active_status')
        ->where('merchant.paused','!=','1')
        ->where('user.id','=',$id)
        ->get();
        return ResponseFormatter::success($datas,'Show Merchant By '.$id); 
    }
    public function showByMerchantId($id){//show merchant by merchant id
        $datas = DB::table('user')
        ->join('merchant','user.id','merchant.id_user')
        ->select(
            'user.id as id_user',
            'merchant.id as id_merchant',
            'merchant.name',
            'merchant.merchant_logo',
            'merchant.description',
            'province',
            'city',
            'country',
            'followers_count',
            'merchant.created_at',
            'merchant.updated_at',
            'last_access',
            'active_status')
        ->where('merchant.paused','!=','1')
        ->where('merchant.id',$id)
        ->get();
        return ResponseFormatter::success($datas,'Show Merchant By Id '.$id); 
    }
    public function searchByMerchantName($merchantName){
        $datas = DB::table('user')
        ->join('merchant','user.id','merchant.id_user')
        ->select(
            'user.id as id_user',
            'merchant.id as id_merchant',
            'merchant.name',
            'merchant.merchant_logo',
            'merchant.description',
            'province',
            'city',
            'country',
            'followers_count',
            'merchant.created_at',
            'merchant.updated_at',
            'last_access',
            'active_status')
        ->where('merchant.paused','!=','1')
        ->where('merchant.name','like', "%{$merchantName}%")
        ->get();
        return ResponseFormatter::success($datas,'Seach By Merchant Name ');
    }
}
