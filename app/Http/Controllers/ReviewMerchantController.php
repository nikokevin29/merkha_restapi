<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Helpers\ResponseFormatter;
use App\Models\ReviewMerchant;

class ReviewMerchantController extends Controller
{
    public function getReviewByIdMerchant($idMerchant){
        $data = DB::table('review_merchant')
            ->join('user', 'user.id', '=', 'review_merchant.id_user')
            ->select(
            'review_merchant.id',
            'id_order',
            'user.username',
            'user.url_photo',
            'is_hidden_name',
            'stars',
            'review_merchant.description',
            'review_merchant.created_at',
            )
            ->orderBy('review_merchant.created_at', 'DESC')
            ->where('id_merchant',$idMerchant)
            ->get();
        return ResponseFormatter::success($data,'Show Review By IdMerchant  '.$idMerchant);
    }
    public function createReviewMerchant(Request $request){
        $iduser = Auth::user()->id;
        $input = $request->all();
        $input['id_user'] = $iduser;
        $data = ReviewMerchant::create($input);
        return ResponseFormatter::success($data,'Create Review');
    }
    public function countAverageReviewMerchant($idMerchant){
        // $data  =DB::table('review_merchant')
        // ->select(DB::raw('avg(stars) AS average'))
        // ->where('id_merchant',$idMerchant)
        // ->get();
        $data = ReviewMerchant::select(DB::raw('avg(stars) as avg'))
        ->where('id_merchant',$idMerchant)->first();
        return number_format($data->avg,2);
    }
    public function checkReviewMerchantDone($idOrder){
        $data = ReviewMerchant::where('id_order',$idOrder)
        ->count();
        return $data;
    }
}
