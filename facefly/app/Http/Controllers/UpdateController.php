<?php

namespace App\Http\Controllers;

use App\Model\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UpdateController extends Controller {

    public function index() {
        return view('/update');
    }

    public function getInfor() {
        $gInfor = DB::table('users')->where([
                    ['user_email', Session::get('user_email')],
                ])->get();
        return view('/update', compact('gInfor'));
    }

    public function postUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_first_name' => 'required|string',
                    'user_last_name' => 'required|string',
                    'user_password' => '',
                    'user_phone' => 'integer',
                        ], [
        ]);

        if ($validator->fails()) {
            return redirect()->route('update')->withErrors($validator);
        } else {
            $email = Session::get('user_email');
            $users = Login::where('user_email', $email)->first();
            if ($request->user_password == null) {
                $pass = $users->user_password;
            } else {
                $pass = $request->user_password;
            }
            DB::table('users')
                    ->where('user_email', $email)
                    ->update([
                'user_first_name' => $request->user_first_name,
                'user_last_name' => $request->user_last_name,
                'user_password' => bcrypt($pass),
                'user_phone' => $request->user_phone,
            ]);
            return redirect()->route('update')->with('success', 'Cập nhật thành công!');
        }
    }

}
