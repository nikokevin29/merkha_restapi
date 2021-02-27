<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use App\Models\User;
use App\Models\ReportFeed;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use DB;

class ReportFeedController extends Controller
{
    public function createReportFeed(Request $request){
        $input = $request->all();
        $input['id_user'] = Auth::user()->id;
        $data = ReportFeed::create($input);
        Feed::where('id',$request->id_feed)->increment('report_count',1);
        return ResponseFormatter::success($data,'Create Feed Feed Success');
    }
    public function deleteReportFeed(Request $request,$id_feed){
        $user = Auth::user()->id;
        $id = ReportFeed::where('id_user',$user)
        ->where('id_feed',$id_feed)
        ->delete();
        Feed::where('id',$id_feed)->decrement('report_count',1);
        return ResponseFormatter::success($id,'delete success');
    }
    public function checkReportFeed(Request $request,$id_feed){
        $check = ReportFeed::where('id_user', Auth::user()->id)
        ->where('id_feed',$id_feed)
        ->first();
        if(empty($check)){
            return 0;
        }
        return $check->id_feed;
    }
}
