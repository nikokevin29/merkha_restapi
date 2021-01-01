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
            'id_campaign'      =>$d->id_campaign,
            'received_date'    =>$d->received_date,
            'order_status'     =>$d->order_status,
            'shipping_price'   =>$d->shipping_price,
            'discount_price'   =>$d->discount_price,
            'total_price'      =>$d->total_price,
            'created_at'       =>$d->created_at,
            'updated_at'       =>$d->updated_at,
            'detail'           =>$d->getDetails,
            ]);
        }
        return ResponseFormatter::success($getAll,'Show Transaction User '.$user);
    }

    public function createOrder(){
        $user = Auth::user()->id;//get user id login
        
        $validator = Validator::make($request->all(), [
            'shipping_price'    => 'required|numeric',
            'total_price'       => 'required|numeric',
            'discount_price'    => 'numeric',
        ]);
        
        if($validator->fails()){
            return ResponseFormatter::error([
                'message' => 'Validator Failed',
                'error'   => $validator->errors(),
            ],'Something gone wrong.', 400);
        }

        $order = Order::create([
            'id_merchant'       => $request->id_merhcant, //  ni Konekinnya gmn ??
            'id_buyer'          => $user,
            'id_destination'    => $request->destination,//keknya ga perlu
            'id_voucher'        => $request->id_voucher,
            'id_campaign'       => $request->id_campaign,
            'received_date'     => $request->received_date,
            'order_status'      => $request->order_status,
            'shipping_price'    => $request->shipping_price,
            'discount_price'    => $request->discount_price,
            'total_price'       => $request->total_price,
        ]);

        return ResponseFormatter::success($order,'Order Created');
    }




}
