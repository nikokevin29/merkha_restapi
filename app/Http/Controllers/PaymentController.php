<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createPayment(Request $request){
        $input = $request->all();
        return ResponseFormatter::success(Payment::create($input),'Payment Created');
    }

    public function showPaymentByOrder(Request $request,$id_order){
        $data = Payment::where('id_order',$id_order)->get();
        return ResponseFormatter::success($data,'Payment Showed');
    }
    
}
