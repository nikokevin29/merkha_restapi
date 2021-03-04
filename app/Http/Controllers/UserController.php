<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;
use App\Helpers\ApiCode;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){
        try {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                $user = Auth::user();
                $success =  $user->createToken('nApp')->accessToken;
                return ResponseFormatter::success([
                    'token' =>$success,
                    'user'=> $user
                ],'Authenticated');
            }
            else{
                return ResponseFormatter::error('Login Failed', 'Unauthorized', 401); 
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name'        => 'required',
                'last_name'         => 'required',
                'email'             => 'required|email|unique:user',
                'username'          => 'required|unique:user|unique:merchant',
                'password'          => 'required',
                'gender'            => 'required',
                'phone_number'      => 'required',
                'url_photo'         => 'nullable',
            ]);
            if($validator->fails()){
                if($validator->errors()->first('username') && $validator->errors()->first('email')){
                    return ResponseFormatter::error([
                        'message' => 'Validator Failed',
                        'error'   => $validator->errors(),
                    ],'Username and Email has already been taken.', 500);
                }else if($validator->errors()->first('username')){
                    return ResponseFormatter::error([
                        'message' => 'Validator Failed',
                        'error'   => $validator->errors(),
                    ],'Username has already been taken.', 500);
                }else if ($validator->errors()->first('email')){
                    return ResponseFormatter::error([
                        'message' => 'Validator Failed',
                        'error'   => $validator->errors(),
                    ],'Email has already been taken.', 500);
                }
            }
            
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'url_photo' => $request->url_photo,
            ]);
            Hash::make($user['password']);
            $user = User::where('email', $request->email)->first();
            $tokenResult =  $user->createToken('nApp')->accessToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
        
    }
    public function details()//mirip fetch
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }


    public function updateProfile(Request $request)
    {
        
        $user = Auth::user();
        $data = $request->all();
        // $validator = Validator::make($data, [
        //     'first_name'        => 'required',
        //     'last_name'         => 'required',
        //     'username'          => 'required|unique:user|unique:merchant',
        //     'phone_number'      => 'required',
        // ]);
        // if($validator->fails()){
        //     if($validator->errors()->first('username')){
        //         return ResponseFormatter::error([
        //             'id' => null,
        //             'message' => 'Validator Failed',
        //             'error'   => $validator->errors(),
        //         ],'Username has already been taken.', 403);
        //     }else{
        //         return ResponseFormatter::error([
        //             'id' => null,
        //             'message' => 'Failed',
        //             'error'   => $validator->errors(),
        //         ],'Internal Server Error', 500);
        //     }
        // }
        $user->update($data);

        return ResponseFormatter::success($user,'Profile Updated');

    }
    public function updateUsername(Request $request){
        $user = Auth::user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'username'          => 'required|unique:user|unique:merchant',
        ]);
        if($validator->fails()){
            if($validator->errors()->first('username')){
                return ResponseFormatter::error(null,'Username has already been taken.', 403);
            }else{
                return ResponseFormatter::error(
                    null
                ,'Internal Server Error', 500);
            }
        }
        $user->update($data);
        return ResponseFormatter::success($user,'Username Updated');
    }

    public function updatePhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'url_photo' => 'required|image|max:2048',//max 2MB
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Photo Fails', 401);            
        }

        // if validator passed
        if($request->file('url_photo')){
            $user = Auth::user();
            $file = $request->file('url_photo')->getClientOriginalName();

            //Delete Old Photos
            if($user->url_photo){
                Storage::delete('assets/user/'.$user->url_photo);
            }

            // File Saved in Laravel Folder 'storage\app\public\assets\user'
            $request->file('url_photo')->storeAs('assets/user/',$file,'public');

            //Save Url to database
            $user->url_photo = $file;
            $user->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }
    }
    
    public function logout(Request $request){
        if (Auth::check()) {
            $token = Auth::user()->token();
            $token->revoke();
         }
        return ResponseFormatter::success($token,'Token Revoked');
    }
    

    public function fetch(Request $request){
        $data = $request->user();
        $getAll = [];
            array_push($getAll,[
            'id'                =>$data->id,
            'first_name'        =>$data->first_name,
            'last_name'         =>$data->last_name,
            'username'          =>$data->username,
            'gender'            =>$data->gender,
            'email'             =>$data->email,
            'password'          =>$data->password,
            'phone_number'      =>$data->phone_number,
            'urlphoto'          =>$data->urlphoto,
            'bio'               =>$data->bio,
            'email_verified_at' =>$data->email_verified_at,
            'followers_count'   =>$data->followers_count,
            'following_count'   =>$data->following_count,
            'address'           =>$data->getAddress,
        ]);
        return ResponseFormatter::success($getAll,'Success Get Profile Data');
    }

    public function forgot(Request $request) {
        $credentials = request()->validate(['email' => 'required|email']);
        //check email found in database
        $email = User::where('email',$request->email)->first();
        if(empty($email)){
            return ResponseFormatter::error([
                'message' => 'Email Not Found in Database',
                'error' => $email,
            ],'Email Not Found', 422);
        }
        Password::sendResetLink($credentials);
        return ResponseFormatter::success(null,'Reset password link sent on your email id.');
    }

    public function reset(ResetPasswordRequest $request) {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return ResponseFormatter::error([
                'message' => 'Invalid Reset Password Token',
                'error'   => Password::INVALID_TOKEN,
            ],'Reset Password Failed', 500);
        }
        return ResponseFormatter::success(null,'Password has been successfully changed');
    }

    public function getUserById ($id){
        $data = User::where('id',$id)->first();
        return ResponseFormatter::success($data,'User Show By Id');
    }
    
}

