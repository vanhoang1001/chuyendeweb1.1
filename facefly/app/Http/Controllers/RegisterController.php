<?php
namespace App\Http\Controllers;

use App\Model\Register;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller{
    
    public function index(){
        return view('/register');
    }
    
    public function postRegister(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_email' => 'required|email|unique:users',
                    'user_password' => 'required|min:8',
                    'user_first_name' => 'required',
                    'user_last_name' => 'required',
                    'user_phone' => 'required',
                        ], [
                'user_email.required'=>'Email không hợp lệ !',
                'user_password.required'=>'Password từ 8 kí tự trở lên',
                'user_first_name.required'=>'Tên không hợp lệ',
                'user_last_name.required'=>'Họ không hợp lệ',
                'user_phone.required'=>'Số điện thoại không hợp lệ',
        ]);
        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->route('register')->withErrors($validator);
        } else {
            DB::table('users')->insert([
                'user_email' => $request->user_email,
                'user_password' => bcrypt($request->user_password),
                'user_first_name' => $request->user_first_name,
                'user_last_name' => $request->user_last_name,
                'user_phone' => $request->user_phone,
            ]);
            return redirect()->route('register')->with('success', 'Đăng ký thành công!');
        }
    }
    
}
