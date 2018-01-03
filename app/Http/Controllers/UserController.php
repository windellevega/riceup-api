<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\FarmerProduct;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type='all')
    {
        // TODO: Add number of products to the response
        
        if($type == 'all') {
            $users = User::all();
        }
        else if($type == 'farmer') {
            /*$users = User::where('is_farmer', 1)
                        ->get();
            $users->count('FarmerProduct');*/
            $users = User::with('productsCount')
                        ->where('is_farmer', 1)
                        ->get();
            //$users->productsCount;
        }
        else if($type == 'consumer') {
            $users = User::where('is_farmer', 0)
                        ->get();
        }
        else {
            return response()->json([
                'message' => 'Invalid user type!'
            ]);
        }

        return response()->json($users);
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
        $validator = \Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'address_lat' => 'numeric',
            'address_long' => 'numeric',
            'mobile_number' => 'numeric|regex:/(09)[0-9]{9}/',
            'email' => 'email',
            'years_bus' => 'integer',
            'years_farm' => 'integer',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'is_farmer' => 'boolean'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = new User();

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = isset($request->middlename) ? $request->middlename : null;
        $user->lastname = $request->lastname;
        $user->address = $request->address;
        $user->address_lat = $request->address_lat;
        $user->address_long = $request->address_long;
        $user->business_name = isset($request->bus_name) ? $request->bus_name : null;
        $user->mobile_no = isset($request->mobile_no) ? $request->mobile_no : null;
        $user->email = isset($request->email) ? $request->email : null;
        $user->years_in_business = isset($request->years_bus) ? $request->years_bus : null;

        /*if(isset($request->photo)) {
            $fileName = Carbon::now()->timestamp . '.' . $request->photo->getClientOriginalExtension();
            $imageFile = $request->photo->move(public_path('photos/profile/'), $fileName);
            $user->photo_url = 'public/photos/profile/' . $fileName;
        }
        else {
            $user->photo_url = 'public/photos/profile/default.jpg';
        }*/

        $user->photo_url = isset($request->photo_url) ? $request->photo_url : null;
        
        $user->is_farmer = isset($request->is_farmer) ? $request->is_farmer : null;
        $user->history = isset($request->history) ? $request->history : null;
        $user->years_in_farming = isset($request->years_farm) ? $request->years_farm : null;
        $user->current_lat = $request->address_lat;
        $user->current_long = $request->address_long;

        $user->save();

        return response()->json([
            'message' => 'Registered Successfully!'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = 0)
    {
        if($id == 0) {
            return $request->user();
        }
        else {
            $user = User::where('id', $id)
                        ->get();
            return response()->json($user);
        }
        
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'address_lat' => 'numeric',
            'address_long' => 'numeric',
            'mobile_number' => 'numeric|regex:/(09)[0-9]{9}/',
            'email' => 'email',
            'years_bus' => 'integer',
            'years_farm' => 'integer',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = User::find(Auth::id());

        $user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = isset($request->middlename) ? $request->middlename : null;
        $user->lastname = $request->lastname;
        $user->address = $request->address;
        $user->address_lat = isset($request->address_lat) ? $request->address_lat : null;
        $user->address_long = isset($request->address_long) ? $request->address_long : null;
        $user->business_name = isset($request->bus_name) ? $request->bus_name : null;
        $user->mobile_no = isset($request->mobile_no) ? $request->mobile_no : null;
        $user->email = isset($request->email) ? $request->email : null;
        $user->years_in_business = isset($request->years_bus) ? $request->years_bus : null;

        /*if(isset($request->photo)) {
            $fileName = Carbon::now()->timestamp . '.' . $request->photo->getClientOriginalExtension();
            $imageFile = $request->photo->move(public_path('photos/profile/'), $fileName);
            $user->photo_url = 'public/photos/profile/' . $fileName;
        }
        else {
            $user->photo_url = 'public/photos/profile/default.jpg';
        }*/

        $user->photo_url = isset($request->photo_url) ? $request->photo_url : null;
        
        $user->history = isset($request->history) ? $request->history : null;
        $user->years_in_farming = isset($request->years_farm) ? $request->years_farm : null;
        $user->current_lat = isset($request->address_lat) ? $request->address_lat : null;
        $user->current_long = isset($request->address_long) ? $request->address_long : null;

        $user->save();

        return response()->json([
            'message' => 'Profile Updated Successfully!'
        ]);
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
