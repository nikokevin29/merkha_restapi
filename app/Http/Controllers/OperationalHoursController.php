<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\ResponseFormatter;
use App\Models\OperationalHours;
class OperationalHoursController extends Controller
{
    public function getOperational($idMerchant){
        $data = OperationalHours::where('id_merchant',$idMerchant)->get();
        return ResponseFormatter::success($data,'Show Operational Hours By id_merchant');
    }
}
