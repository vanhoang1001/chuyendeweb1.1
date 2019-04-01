<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Register extends Model implements AuthenticatableContract{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    use Authenticatable;
    
    protected $fillable = [
        'user_first_name', 'user_last_name', 'user_email', 'user_password','user_phone',
    ];
    
    protected $hidden = [
        'user_password', 'remember_token',
    ];
}
