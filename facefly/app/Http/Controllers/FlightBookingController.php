<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\FlightClass;
use App\Model\FlightBooking;
use App\Model\Customers;
use App\Model\Login;
use Illuminate\Support\Facades\Session;

class FlightBookingController extends Controller{
    public function index(){
        $key = Session::get('user_email');
        $users= Login::get()->where('user_email',$key);     
 
        $fbook = FlightBooking::all();
        $cus = Customers::all();
        $cities = City::all();
        $flight_classes = FlightClass::all();
     
        return view('flight-book', compact('fbook','cus','cities','flight_classes','users') );
    }
}