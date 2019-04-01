<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model{
    protected $table = 'flight_booking';
    protected $primaryKey = 'fb_id';
}
