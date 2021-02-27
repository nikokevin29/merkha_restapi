<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ReportProduct;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use DB;

class ReportProductController extends Controller
{
    public function createReportProduct(Request $request){
        // $isExist = ReportProduct::where('id_user',Auth::user()->id)
        // ->where('id_product',$id_product)
        // ->count();
        // if($isExist != 0){
        //     return ResponseFormatter::error(['id' => null],'Product Already Reported ', 409);
        // }
        $input = $request->all();
        $input['id_user'] = Auth::user()->id;
        $data = ReportProduct::create($input);
        Product::where('id',$request->id_product)->increment('report_count',1);
        return ResponseFormatter::success($data,'Create Report Product Success');
    }
    public function deleteReportProduct(Request $request,$id_product){
        $user = Auth::user()->id;
        $id = ReportProduct::where('id_user',$user)
        ->where('id_product',$id_product)
        ->delete();
        Product::where('id',$id_product)->decrement('report_count',1);
        return ResponseFormatter::success($id,'delete success');
    }
    public function checkReportProduct(Request $request,$id_product){
        $check = ReportProduct::where('id_user', Auth::user()->id)
        ->where('id_product',$id_product)
        ->first();
        if(empty($check)){
            return 0;
        }
        return $check->id_product;
    }
}
