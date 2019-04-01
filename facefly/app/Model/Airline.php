<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Airline extends Model
{
    protected $table = 'airlines';
    protected $fillable = ['airline_id', 'airline_name'];
    public $timestamps = false;
}