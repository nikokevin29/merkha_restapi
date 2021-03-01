<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\ResponseFormatter;
use App\Models\MerchantBanner;
class MerchantBannerController extends Controller
{
    public function getMerchBanner($idMerchant){
        $data = MerchantBanner::where('id_merchant',$idMerchant)
        ->where('hide','!=','1')
        ->orderBy('position','ASC')
        ->pluck('url_image')
        ->toArray();
        return $data;
    }
}
