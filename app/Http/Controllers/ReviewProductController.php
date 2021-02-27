<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Helpers\ResponseFormatter;
use App\Models\ReviewProduct;

class ReviewProductController extends Controller
{
    public function createReviewProduct(Request $request){
        $iduser = Auth::user()->id;
        $input = $request->all();
        $input['id_user'] = $iduser;
        $data = ReviewProduct::create($input);
        return ResponseFormatter::success($data,'Create Review Product');
    }

    public function getReviewByIdProduct($idProduct){
        $data = DB::table('review_product')
            ->join('user', 'user.id', '=', 'review_product.id_user')
            ->select(
            'review_product.id',
            'id_product',
            'user.username',
            'user.url_photo',
            'is_hidden_name',
            'stars',
            'review_product.description',
            'review_product.created_at',
            )
            ->orderBy('review_product.created_at', 'DESC')
            ->where('id_product',$idProduct)
            ->get();
        return ResponseFormatter::success($data,'Show Review By idProduct  '.$idProduct);
    }

}
