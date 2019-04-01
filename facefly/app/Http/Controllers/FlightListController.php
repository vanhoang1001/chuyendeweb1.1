<?php

namespace App\Http\Controllers;

use App\Model\Flight_list;
use App\Model\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class FlightListController extends Controller {

    public function flight_list(Request $request) {
        $citylists = City::get();


        $flightlists = DB::table('flight_list')
                ->join('cities', 'cities.city_id', '=', 'flight_list.fl_city_from_id')
                ->join('airlines', 'flight_list.fl_airline_id', '=', 'airlines.airline_id')
                ->join('transits', 'transits.transit_fl_id', '=', 'flight_list.fl_id')
                ->where('flight_list.fl_city_from_id', '=',$request->from)
                ->where('flight_list.fl_city_to_id', '=',$request->to)
                ->get();

        $transits = DB::table('flight_list')
                ->join('transits', 'transits.transit_fl_id', '=', 'flight_list.fl_id')
                 ->select(DB::raw('COUNT(transits.transit_fl_id) as count'), 'transits.transit_fl_id')
                ->groupBy('transits.transit_fl_id')
                ->get();
        Session::put('fc_id', $request->flight_class);

        return view('/flight-list', compact('flightlists', 'citylists', 'transits'));
    }

}
