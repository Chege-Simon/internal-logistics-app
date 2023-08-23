<?php

namespace App\Http\Controllers\Api;

use App\Models\Bag;
use App\Models\Trip;
use App\Models\User;
use App\Models\Trip_Log;
use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getbags(Request $request)
    {
        $req_from = $request->route('from');
        $req_to = $request->route('to');
        $from = date($req_from);
        $to = date($req_to);
        $Bags = Bag::whereBetween('updated_at', [$from, $to])->get();
        return $this->sendResponse($Bags, 'Bags retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gettrip_logs(Request $request)
    {
        $req_from = $request->route('from');
        $req_to = $request->route('to');
        $from = date($req_from);
        $to = date($req_to);
        $Trip_logs = Trip_Log::whereBetween('updated_at', [$from, $to])->get();
        return $this->sendResponse($Trip_logs, 'Trip Logs retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *t
     * @return \Illuminate\Http\Response
     */
    public function gettrips(Request $request)
    {
        $req_from = $request->route('from');
        $req_to = $request->route('to');
        $from = date($req_from);
        $to = date($req_to);
        $Trips = Trip::whereBetween('updated_at', [$from, $to])->get();
        return $this->sendResponse($Trips, 'Trips retrieved successfully.');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function getusers(Request $request)
    {
        $req_from = $request->route('from');
        $req_to = $request->route('to');
        $from = date($req_from);
        $to = date($req_to);
        $Users = User::whereBetween('updated_at', [$from, $to])->get();
        return $this->sendResponse($Users, 'Users retrieved successfully.');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function getitems(Request $request)
    {
        $req_from = $request->route('from');
        $req_to = $request->route('to');
        $from = date($req_from);
        $to = date($req_to);
        $Items = Item::whereBetween('updated_at', [$from, $to])->get();
        return $this->sendResponse($Items, 'Items retrieved successfully.');
    }
}
