<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AddressController extends Controller
{
    
    public function index()
    {
        $address = Address::all();
        return $address;
    }
    public function showbyuser()
    {
        $id = Auth::user()->id;
        $filtered = Address::where('id_user',$id)->get();
        return ResponseFormatter::success($filtered,'Address Showed by user login');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $iduser = Auth::user()->id;
        $validator = Validator::make($input,[
        'address_save_name' => 'required',
        'address'           => 'required',
        'postal_code'       => 'required',
        'city'              => 'required',
        'province'          => 'required',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Register Failed', 401);     
        }
        
        $input['id_user'] = $iduser;
        $data = Address::create($input);
        return ResponseFormatter::success($data,'Address Created');
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'address_save_name' => 'required',
            'address'           => 'required',
            'postal_code'       => 'required',
            'city'              => 'required',
            'province'          => 'required',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Failed', 401);     
        }

        $input['id_user'] = Auth::user()->id;
        $data = Address::where('id',$id)->update($input);

        return ResponseFormatter::success($data,'Address Updated');
    }

    public function destroy(Address $id)
    {
        $id->delete();
        return ResponseFormatter::success($id,'Address Deleted');
    }
}
