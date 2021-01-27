<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use App\Models\Merchant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function showVoucher(){
        $now = Carbon::now();
        $data = Voucher::where('start_time','<=',$now)
        ->where('end_time','>=',$now)
        ->get();
        $getAll = [];
        foreach($data as $d){
            array_push($getAll,[
            'id'               =>$d->id,
            'merchant'         =>$d->getMerchant->firstWhere('id',$d->id_merchant)->name,
            'merchant_logo'    =>$d->getMerchant->firstWhere('id',$d->id_merchant)->merchant_logo,
            'voucher_name'     =>$d->voucher_name,
            'voucher_code'     =>$d->voucher_code,
            'voucher_type'     =>$d->voucher_type,
            'voucher_quantity' =>$d->voucher_quantity,
            'min_basket_size'  =>$d->min_basket_size,
            'max_usage'        =>$d->max_usage,
            'disc_amount'      =>$d->disc_amount,
            'disc_rate'        =>$d->disc_rate,
            'valid_date'       =>$d->end_time,
            'created_at'       =>$d->created_at,
            'updated_at'       =>$d->updated_at,
            ]);
        }
        return ResponseFormatter::success($getAll,'Show Voucher All');
    }
    public function checkVoucher(Request $request,$code){
        $now = Carbon::now();
        $query = Voucher::where('start_time','<=',$now)
        ->where('end_time','>=',$now)
        ->where('voucher_code','=',$code)
        ->first();
        if($query == null){
            return ResponseFormatter::error($query, 'Voucher Not Found', 404);
        }
        if($query->voucher_quantity == 0){
            return ResponseFormatter::error($query, 'Voucher Sold Out', 406);
        }else if($query->max_usage == 0){
            return ResponseFormatter::error($query, 'Voucher Reach Max Usage', 406);
        }
        return ResponseFormatter::success($query,'Voucher Avaiable');
    }

    public function useVoucher(Request $request,$code){
        //note: Kurangin max usage,kurangin voucher_quantity, dalem kurung waktu tertentu
        $now = Carbon::now();
        $query = Voucher::where('start_time','<=',$now)
        ->where('end_time','>=',$now)
        ->where('voucher_code','=',$code)
        ->first();
        if($query == null){
            return ResponseFormatter::error($query, 'Voucher Not Found', 404);
        }
        if($query->voucher_quantity == 0){
            return ResponseFormatter::error($query, 'Voucher Sold Out', 406);
        }else if($query->max_usage == 0){
            return ResponseFormatter::error($query, 'Voucher Reach Max Usage', 406);
        }
        $query->decrement('max_usage');
        $query->decrement('voucher_quantity');
        return ResponseFormatter::success($query,'Voucher Used');

    }
}
