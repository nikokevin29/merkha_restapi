<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;
use App\Models\Merchant;
use DB;
class CommentController extends Controller
{
    public function showComment(Request $request,$id_feed){
        $datas = DB::table('comment')
        ->orderBy('comment.updated_at','ASC')
        ->select(
        'comment.id_user',
        'comment.id_merchant',
        'comment.id_feed',//input
        'merchant.username as merchant_username',
        'merchant.name as merchant_name',
        'user.username as user_name',
        'comment.comment',
        'comment.mention',
        'comment.created_at',
        'comment.updated_at',
        )
        ->leftJoin('user','user.id','comment.id_user')
        ->leftJoin('merchant','merchant.id','comment.id_merchant')
        ->where('comment.id_feed',$id_feed)
        ->get();
        return ResponseFormatter::success($datas,'Show Comment by id Feed');
    }

    public function createComment(Request $request){
        $user = Auth::user();
        $input = $request->all();
        $input['id_user'] = $user->id;
        //$input['id_feed'] = $id_feed;//input
        $data = Comment::create($input);
        return ResponseFormatter::success($data,'Created Comment');
    }
    public function editComment(Request $request, $id){
        $data = Comment::where('id',$id)->update($request->all());
        return ResponseFormatter::success($data,'Comment Updated');
    }
    public function deleteComment(Comment $id){
        $id->delete();
        return ResponseFormatter::success($id,'Comment Deleted');
    }
}
