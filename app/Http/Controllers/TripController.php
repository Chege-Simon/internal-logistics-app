<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Trip;
use App\Models\Trip_Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *t
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = Trip::with('bag')->with('items')->with('trip_logs')->get();
        $branches = User::all()->where('role', 'like', "branch")->pluck('name', 'id');
        $users = User::all();
        $bags = Bag::with('user')->get();
        $filteredTrips = $trips;
        if (Auth::check() & (Auth::User()->role == "branch" | Auth::User()->role == "receiving")) {
            $filteredTrips = $trips->filter(function ($trip) {
                return $trip->trip_logs->last()->status != 'At HQ Packaging' || $trip->trip_logs->last()->status == 'Bag Dispatch To Branch' || $trip->trip_logs->last()->status == 'Bag Dispatch To HQ' & (Auth::User()->id == $trip->to | Auth::User()->role == "admin");
            });
        }
        if (Auth::check() & (Auth::User()->role == "branch" | Auth::User()->role == "packaging")) {
            $filteredTrips = $trips->filter(function ($trip) {
                return $trip->trip_logs->last()->status == 'At Branch Packaging' || $trip->trip_logs->last()->status == 'At HQ Packaging' & (Auth::User()->id == $trip->from | Auth::User()->role == "admin");
            });
        }
        return view('trips/trips', ['trips' => $filteredTrips->sortByDesc('id'), 'branches' => $branches, 'bags' => $bags, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'bag_id' => 'required',
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lastBagTrip = Trip::with('bag')->with('items')->with('trip_logs')
            ->where('bag_id', '=', $request->bag_id)->latest()->first();
        if (!is_null($lastBagTrip)) {
            if (($lastBagTrip->trip_logs->last()->status == 'Received At HQ'
                    & (Auth::User()->role == "packaging" | Auth::User()->role == "admin")) |
                ($lastBagTrip->trip_logs->last()->status != 'Received At Branch' &
                    (Auth::User()->role == "branch" | Auth::User()->role == "admin"))
            ) {
                return redirect()->back()->withErrors(['msg' => 'Trip Already Initialized']);
            }
        }
        $The_trip = Trip::create([
            'from' => $request->from,
            'to' => $request->to,
            'bag_id' => $request->bag_id,
        ]);

        if (Auth::check() & (Auth::User()->role == "packaging" | Auth::User()->role == "admin")) {
            Trip_Log::create([
                'trip_id' => $The_trip->id,
                'status' => "At HQ Packaging"
            ]);
        } elseif (Auth::check() & (Auth::User()->role == "branch")) {
            Trip_Log::create([
                'trip_id' => $The_trip->id,
                'status' => "At Branch Packaging"
            ]);
        }
        Session::flash('message', 'Successfully Registered a Trip!');
        return redirect()->route('trip.edit', ['id' => $The_trip->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Trip = Trip::with('items')->with('bag')->with('trip_logs')->findOrFail($id);
        $branches = User::all()->where('role', 'like', "branch");
        return view('trips/items', ['trip' => $Trip, 'items' => $Trip->items, 'branches' => $branches]);
    }

    /**
     * Show the form for receiving the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive($id)
    {
        $Trip = Trip::with('items')->with('bag')->with('trip_logs')->findOrFail($id);
        $branches = User::all()->where('role', 'like', "branch");
        if (Trip_Log::where('trip_id', $Trip->id)
            ->where('status', 'like', 'Received At%')->exists()
        ) {
            return redirect()->back()
                ->withErrors(['msg' => 'Bag Already Received!'])
                ->withInput();
        }

        if (Auth::check() & (Auth::User()->role == "branch")) {
            Trip_Log::create([
                'trip_id' => $Trip->id,
                'status' => "Received At Branch"
            ]);
        } elseif (Auth::check() & (Auth::User()->role == "receiving")) {
            Trip_Log::create([
                'trip_id' => $Trip->id,
                'status' => "Received At HQ"
            ]);
        }
        Session::flash('message', 'Successfully Received!');
        return redirect()->route('trip.edit', ['id' => $Trip->id]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required',
            'status' => 'required'
        ]);

        $The_Trip = Trip::with('items')->findOrFail($id);
        // Create trip_log model
        Trip_Log::create([
            'trip_id' => $The_Trip->id,
            'status' => $request->status
        ]);
        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->status == 'Bag Dispatch To Branch' || $request->status == 'Bag Dispatch To HQ') {
            foreach ($The_Trip->items as $item) {
                // Fill item model
                $item->fill([
                    'status' => "Sent",
                ]);

                // Save item to database
                $item->save();
            }
        }
        Session::flash('message', 'Successfully Updated Trip Status!');
        return redirect()->route('trips');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
