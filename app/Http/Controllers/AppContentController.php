<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppContent;

class AppContentController extends Controller
{
    public function showMainAppContent(){
        $data =  AppContent::where('location','=','Main Page')->select('url_image')->pluck('url_image')->toArray();
        return $data;
    }
}