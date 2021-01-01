<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
class OrderDetailController extends Controller
{
    public function createDetailOrder(){
        $detail = Order::create([
            'id_order'    => $request->id_order,
            'id_product'  => $request->id_product,
            'amount'      => $request->amount,
            'subtotal'    => $request->subtotal,
        ]);
        return ResponseFormatter::success($detail,'Detail Created');
    }
    
}
