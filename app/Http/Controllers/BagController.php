<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $bags = Bag::with('user')->with('trip')->with('trip.trip_logs')->get();
        return view('bags/bags', ['bags' => $bags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $branches = User::all()->where('role', 'like', "branch")->pluck('name', 'id');
        return view('bags/bag_create', ['branches' => $branches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = $request->bag_label . "@" . $request->user_id;
        $request->request->add(['bag_tag' => $tag]);

        // Validate the data submitted by user
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'bag_label' => 'required|max:225',
            'bag_tag' => 'required|max:225|' . Rule::unique('bags'),
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Bag::create([
            'user_id' => $request->user_id,
            'bag_label' => $request->bag_label,
            'bag_tag' => $tag,
        ]);
        Session::flash('message', 'Successfully Created Bag!');
        return redirect()->route('bags');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bag = Bag::findOrFail($id);
        return view('bags/bag', ['bag' => $bag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bag = Bag::findOrFail($id);
        $branches = User::all()->where('role', 'like', "branch")->pluck('name', 'id');
        return view('bags/bag_update', ['bag' => $bag, 'branches' => $branches]);
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
        $tag = $request->bag_label . "@" . $request->user_id;
        $request->request->add(['bag_tag' => $tag]);
        // Validate the data submitted by bag
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'bag_label' => 'required|max:225',
            'bag_tag' => 'required|max:225|' . Rule::unique('bags'),
        ]);

        // if fails redirects back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $bag = Bag::findOrFail($id);
        // Fill bag model
        $bag->fill([
            'user_id' => $request->user_id,
            'bag_label' => $request->bag_label,
            'bag_tag' => $tag,
        ]);

        // Save user to database
        $bag->save();

        // Redirect to route
        Session::flash('message', 'Successfully Update Bag Details!');
        return redirect()->route('bags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bag = Bag::findOrFail($id);
        // Delete Bag from database
        $bag->delete();

        // Redirect to route
        Session::flash('message', 'Successfully Deleted Bag!');
        return redirect()->route('bags');
    }
}
