<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Merchant;

class OrderController extends Controller
{
    //STATUS ORDER
    // WAITING FOR PAYMENT, NEW ORDER,  , READY TO SHIP, ON SHIPPING, ORDER FINISHED, ORDER CANCELED
    public function showOrderbyUserLogin(){
        $user = Auth::user()->id;
        $data = Order::where('id_buyer',$user)->whereNotIn('order_status',['ORDER FINISHED'])->orderBy('updated_at', 'DESC')->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'merchant_name'    =>$d->getMerchant->firstWhere('id',$d->id_merchant)->name,
            'id_buyer'         =>$d->id_buyer,//for getting address
            'address'          =>$d->getAddress->firstWhere('id',$d->id_destination)->address,
            'province'         =>$d->getAddress->firstWhere('id',$d->id_destination)->province,
            'city'             =>$d->getAddress->firstWhere('id',$d->id_destination)->city,
            // 'voucher'          =>$d->id_voucher,
            // 'id_campaign'      =>$d->id_campaign,
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

    public function showOrderFinished(){
        $user = Auth::user()->id;
        $data = Order::where('id_buyer',$user)->where('order_status','ORDER FINISHED')->orderBy('updated_at', 'DESC')->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'merchant_name'    =>$d->getMerchant->firstWhere('id',$d->id_merchant)->name,
            'id_buyer'         =>$d->id_buyer,//for getting address
            'address'          =>$d->getAddress->firstWhere('id',$d->id_destination)->address,
            'province'         =>$d->getAddress->firstWhere('id',$d->id_destination)->province,
            'city'             =>$d->getAddress->firstWhere('id',$d->id_destination)->city,
            // 'voucher'          =>$d->id_voucher,
            // 'id_campaign'      =>$d->id_campaign,
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

    public function createOrder(Request $request){
        $user               = Auth::user()->id;//get user id login
        $input              = $request->all();
        $input['id_buyer']  = $user;
        $order              = Order::create($input);

        return ResponseFormatter::success($order,'order created');
    }
    public function editStatus(Request $request,$id){
        $ids    = Order::find($id);
        $ids->order_status = $request->order_status;
        $ids->save();
        return ResponseFormatter::success($ids,'status Edited');
    }




}
