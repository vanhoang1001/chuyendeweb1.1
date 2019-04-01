<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class Airport extends Model
{
    protected $table = 'airports';
    protected $fillable = ['airport_id', 'airport_name'];
    public $timestamps = false;
}