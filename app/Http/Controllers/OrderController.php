<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function showOrderbyUserLogin(){
        $user = Auth::user()->id;
        $data = Order::where('id_buyer',$user)->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'id_merchant'      =>$d->id_merchant,
            'id_buyer'         =>$d->id_buyer,//for getting address
            'destination'      =>$d->getAddress,
            'voucher'          =>$d->getVoucher,
            //'id_campaign'    =>$d->id_campaign,
            'received_date'    =>$d->received_date,
            'order_status'     =>$d->order_status,
            'shipping_price'   =>$d->shipping_price,
            'discount_price'   =>$d->discount_price,
            'total_price'      =>$d->total_price,
            'created_at'       =>$d->created_at->format('Y-m-d H:i:s'),
            'updated_at'       =>$d->updated_at->format('Y-m-d H:i:s'),
            ]);
        }
        return ResponseFormatter::success($getAll,'Show Transaction User '.$user);
    }


}
