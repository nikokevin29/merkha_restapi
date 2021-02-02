<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderDetail;

class OrderDetailController extends Controller
{
    public function createDetailOrder(Request $request){
        $input = $request->all();
        return ResponseFormatter::success(OrderDetail::create($input),'Detail Created');
    }

    public function showDetailOrder($id_order){
        return ResponseFormatter::success(OrderDetail::where('id_order',$id_order)->get(),'Detail Created');
    }

}
// Buat Update Stock
// Flight::where('active', 1)
//       ->where('destination', 'San Diego')
//       ->update(['delayed' => 1]);