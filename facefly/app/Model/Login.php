<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Login extends Model{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    
    public static function getUser($email){
        return Login::where('user_email', $email)->get();
    }

    public static function firstUser($email){
        return Login::where('user_email', $email)->first();
    }

    public static function updateTime($email){
        Login::where('user_email', $email)
            ->update(['user_last_access'=>date('Y-m-d H:i:s'),
                'user_attempt' => 0,
                'user_status' => 1]);
    }
    
    public static function updateUser($pass, $user_first_name, $user_last_name, $phone){
        Login::where('user_email', Session::get('user_email'))
            ->update([
                'user_password'=>bcrypt($pass),
                'user_first_name'=>$user_first_name,
                'user_last_name'=>$user_last_name,
                'user_phone'=>$phone,
            ]);
    }

}
