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
use App\Models\Voucher;
use DB;
use Carbon\Carbon;
class OrderController extends Controller
{
    //STATUS ORDER
    // WAITING FOR PAYMENT, NEW ORDER,  , READY TO SHIP, ON SHIPPING, ORDER FINISHED, ORDER CANCELED
    public function showOrderbyUserLogin(){
        $user = Auth::user()->id;
        $data = Order::where('id_buyer',$user)
        ->whereNotIn('order_status',['FINISHED'])
        ->orderBy('updated_at', 'DESC')
        ->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'id_merchant'      =>$d->id_merchant,
            'order_number'     =>$d->order_number,
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
            'created_at'       =>$d->created_at->format('Y-m-d H:i:s'),
            'updated_at'       =>$d->updated_at->format('Y-m-d H:i:s'),
            'preview'          =>DB::table('product_photo')
            ->select('url_photo')
            ->where('id_product',DB::table('order_detail')->where('id_order' ,$d->id)->value('id_product'))->pluck('url_photo')->first(),
            //'detail'           =>$d->getDetails,
            ]);
        }
        return ResponseFormatter::success($getAll,'Show Transaction User '.$user);
    }

    public function showOrderFinished(){
        $user = Auth::user()->id;
        $data = Order::where('id_buyer',$user)
        ->where('order_status','FINISHED')
        ->orderBy('updated_at', 'DESC')
        ->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'id_merchant'      =>$d->id_merchant,
            'order_number'     =>$d->order_number,
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
            'created_at'       =>$d->created_at->format('Y-m-d H:i:s'),
            'updated_at'       =>$d->updated_at->format('Y-m-d H:i:s'),
            'preview'          =>DB::table('product_photo')
            ->select('url_photo')
            ->where('id_product',DB::table('order_detail')->where('id_order' ,$d->id)->value('id_product'))->pluck('url_photo')->first(),
            ]);
        }
        return ResponseFormatter::success($getAll,'Show Transaction User '.$user);
    }

    public function createOrder(Request $request){
        //id_merchant, id_buyer(auto), id_destination, id_voucher,order_number(auto), order_status,shipping_price, discount_price, total_price
        $user_id                = Auth::user()->id;//get user id login
        $data                   = new Order;
        $data->id_merchant      = $request->id_merchant;
        $data->id_buyer         = $user_id; // User ID Auto
        $data->id_destination   = $request->id_destination;
        //$data->id_voucher       = $request->id_voucher;
        $data->order_number     = "";
        $data->order_status     = $request->order_status;
        $data->shipping_price   = $request->shipping_price;
        $data->discount_price   = $request->discount_price;
        $data->total_price      = $request->total_price;
        $data->save();
        $data->order_number     = Order::orderNumber().$data->id;
        $data->save();

        //Voucher::find($request->id_voucher)->decrement('voucher_quantity'); //Decrement Voucher\

        return ResponseFormatter::success($data,'Order Created');
    }
    public function editStatus(Request $request,$id){
        $ids    = Order::find($id);
        $ids->order_status = $request->order_status;
        $ids->received_date = Carbon::now();
        $ids->save();
        return ResponseFormatter::success($ids,'status Edited');
    }
    public function editVoucher(Request $request,$id){
        $id = Order::find($id);
        $id->id_voucher = $request->id_voucher;
        $id->save();
        return ResponseFormatter::success($id,'Voucher Edited');
    }




}
