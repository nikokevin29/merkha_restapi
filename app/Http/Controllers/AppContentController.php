<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppContent;

class AppContentController extends Controller
{
    public function showMainAppContent(){
        $data =  AppContent::where('location','=','Main Page')
        ->where('hide','!=','1')
        ->select('url_image')
        ->pluck('url_image')
        ->toArray();
        return $data;
    }
    public function showMainAppContentFormat(){
        // $data =  AppContent::
        // where('location','=','Main Page')
        // ->where('hide','!=','1')
        // ->select('url_image')
        // ->pluck('url_image')
        // ->toArray();
        
        $data = AppContent::where('location','=','Main Page')
        ->where('hide','!=','1')
        ->select('id','id_merchant','url_image')
        ->get();
        return $data;
    }
    public function showMerchantCategoryAppContent($id_merchant_category){
        // $data =  AppContent::where('id_merchant_category','=',$id_merchant_category)
        // ->where('hide','!=','1')
        // ->select('url_image')
        // ->pluck('url_image')
        // ->toArray();
        // return $data;

        $data = AppContent::where('id_merchant_category','=',$id_merchant_category)
        ->where('hide','!=','1')
        ->select('id','id_merchant','url_image')
        ->get();
        return $data;
    }
}
