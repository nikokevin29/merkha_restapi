<?php

namespace App\Http\Controllers;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function show(){
        return ResponseFormatter::success(ProductCategory::all(),'Show All Category');
    }
    public function showNameOnly(){
        $datas = ProductCategory::all();
        
        $name = [];
        foreach($datas as $keys => $d) {
            $name[$keys] = $d->category_name;
        }
            
        return $name;
    }
}
