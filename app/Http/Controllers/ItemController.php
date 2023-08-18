<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'trip_id' => 'required',
            'item_code' => 'required',
            'item_type' => 'required',
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $item_exists = Item::where('trip_id', $request->trip_id)
        ->where('item_code', $request->item_code)
        ->where('item_type', $request->item_type)->exists();
        // if fails redirects back with errors
        if ($item_exists) {
            return redirect()->back()
                ->withErrors(['msg' => 'Item Already exists in this Trip!'])
                ->withInput();
        }
        Item::create([
            'trip_id' => $request->trip_id,
            'item_code' => $request->item_code,
            'item_type' => $request->item_type,
            'status' => "In Bag",
        ]);
        Session::flash('message', 'Successfully Added Item');
        return redirect()->route('trip.edit', ['id' => $request->trip_id ]);
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
        //
    }

    /**
     * Show the form for receiving the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receive($id)
    {
        $Item = Item::with('trip')->findOrFail($id);
        // Fill bag model
        $Item->fill([
            'status' => "Received",
        ]);
        // Save user to database
        $Item->save();

        Session::flash('message', 'Successfully Updated Item Status!');
        return redirect()->route('trip.edit', ['id' => $Item->trip->id ]);
    }

    /**
     * Show the form for receiving the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function not_receive($id)
    {
        $Item = Item::with('trip')->findOrFail($id);
        // Fill bag model
        $Item->fill([
            'status' => "Not Received",
        ]);
        // Save user to database
        $Item->save();

        Session::flash('message', 'Successfully Updated Item Status!');
        return redirect()->route('trip.edit', ['id' => $Item->trip->id ]);
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
        
        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required',
            'item_code' => 'required',
            'item_type' => 'required',
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $item_exists = Item::where('trip_id', $request->trip_id)
        ->where('item_code', $request->item_code)
        ->where('item_type', $request->item_type)->exists();
        // if fails redirects back with errors
        if ($item_exists) {
            return redirect()->back()
                ->withErrors(['msg' => 'Item Already exists in this Trip!'])
                ->withInput();
        }
        
        $item = Item::findOrFail($id);
        // Fill item  model
        $item->fill([
            'trip_id' => $request->trip_id,
            'item_code' => $request->item_code,
            'item_type' => $request->item_type,
            'status' => "In Bag",
        ]);

        // Save item to database
        $item->save();

        // Redirect to route
        Session::flash('message', 'Successfully Edited Item Details');
        return redirect()->route('trip.edit', ['id' => $request->trip_id ]);
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
