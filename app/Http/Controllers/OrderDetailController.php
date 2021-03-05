<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderDetail;
use App\Models\Product;
use DB;
class OrderDetailController extends Controller
{
    public function createDetailOrder(Request $request){
        $input = $request->all();
        Product::where('id',$request->id_product)->decrement('stock',$request->amount);
        return ResponseFormatter::success(OrderDetail::create($input),'Detail Created');
    }

    public function showDetailOrder($id_order){
        $data = DB::table('order_detail')
        ->select(
            'order_detail.id',
            'order_detail.id_order',
            'order_detail.product_price',
            'order_detail.id_product',
            'order_detail.amount',
            'order_detail.subtotal',
            'product.product_name',
            //'product.price',
        )
        ->join('product','product.id','order_detail.id_product')
        ->where('id_order',$id_order)
        ->get();
        return ResponseFormatter::success($data,'Detail Created');
    }

}
// Buat Update Stock
// Flight::where('active', 1)
//       ->where('destination', 'San Diego')
//       ->update(['delayed' => 1]);