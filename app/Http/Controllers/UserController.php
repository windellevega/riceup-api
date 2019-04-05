<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\FarmerProduct;
use App\ShippingDetail;

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
                'message' => 'Invalid user type.'
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
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'address_lat' => 'numeric|nullable',
            'address_long' => 'numeric|nullable',
            'mobile_number' => 'numeric|regex:/(09)[0-9]{9}/',
            'email' => 'email|unique:users,email',
            'years_bus' => 'integer',
            'years_farm' => 'integer',
            'is_farmer' => 'required|boolean'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = new User();

        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->address = "";
        $user->business_name = $request->bus_name;
        $user->email = $request->email;
        $user->years_in_business = $request->years_bus;

        /*if(isset($request->photo)) {
            $fileName = Carbon::now()->timestamp . '.' . $request->photo->getClientOriginalExtension();
            $imageFile = $request->photo->move(public_path('photos/profile/'), $fileName);
            $user->photo_url = 'public/photos/profile/' . $fileName;
        }
        else {
            $user->photo_url = 'public/photos/profile/default.jpg';
        }*/

        $user->photo_url = isset($request->photo_url) ? $request->photo_url : 'public/photos/profile/default.jpg';
        
        $user->is_farmer = $request->is_farmer;
        $user->history = $request->history;
        $user->years_in_farming = $request->years_farm;
        $user->current_lat = $request->address_lat;
        $user->current_long = $request->address_long;

        $user->save();

        $shippingDetail = new ShippingDetail();
        $shippingDetail->user_id = $user->id;
        $shippingDetail->shipping_address = $request->address;
        $shippingDetail->address_lat = $request->address_lat;
        $shippingDetail->address_long = $request->address_long;
        $shippingDetail->mobile_no = $request->mobile_no;

        $shippingDetail->save();

        return response()->json([
            'message' => 'Registered Successfully.'
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
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'address_lat' => 'numeric|nullable',
            'address_long' => 'numeric|nullable',
            'mobile_number' => 'numeric|regex:/(09)[0-9]{9}/',
            'email' => 'email',
            'years_bus' => 'integer',
            'years_farm' => 'integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = User::find(Auth::id());

        $user->username = $user->username;
        //$user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->address = "";
        $user->business_name = $request->bus_name;
        $user->email = $request->email;
        $user->years_in_business = $request->years_bus;

        $user->photo_url = isset($request->photo_url) ? $request->photo_url : 'public/photos/profile/default.jpg';
        
        $user->is_farmer = $request->is_farmer;
        $user->history = $request->history;
        $user->years_in_farming = $request->years_farm;
        $user->address_lat = $request->address_lat;
        $user->address_long = $request->address_long;
        //$user->current_lat = $request->address_lat;
        //$user->current_long = $request->address_long;

        $user->save();

        /*$shippingDetail = ShippingDetail::where('user_id', Auth::id())
                            ->first();
        $shippingDetail->shipping_address = $request->address;
        $shippingDetail->address_lat = $request->address_lat;
        $shippingDetail->address_long = $request->address_long;
        $shippingDetail->mobile_no = $request->mobile_no;

        $shippingDetail->save();*/


        return response()->json([
            'message' => 'Profile Updated Successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'oldpassword' => 'required',
            'newpassword' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $user = User::find(Auth::id());
        if(!Hash::check($request->oldpassword, $user->password)) {
            return response()->json([
                'message' => 'Old password is invalid.'
            ]);
        }

        if(Hash::check($request->newpassword, $user->password)) {
            return response()->json([
                'message' => 'New password should not be the same as old password.'
            ]);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return response()->json([
            'message' => 'Your password was updated successfully.'
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


    /***
     * Update the specific shipping details of user
     */
    public function storeShippingDetail(Request $request)
    {
        $shippingDetail = new ShippingDetail();

        $shippingDetail->user_id = Auth::id();
        $shippingDetail->shipping_address = $request->address;
        $shippingDetail->address_lat = $request->address_lat;
        $shippingDetail->address_long = $request->address_long;
        $shippingDetail->mobile_no = $request->mobile_no;

        $shippingDetail->save();

        return response()->json([
            'message' => 'Your shipping detail was added successfully.'
        ]);
    }

    /***
     * Update the specific shipping details of user
     */
    public function updateShippingDetail(Request $request, $id)
    {
        $shippingDetail = ShippingDetail::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        $shippingDetail->shipping_address = $request->address;
        $shippingDetail->address_lat = $request->address_lat;
        $shippingDetail->address_long = $request->address_long;
        $shippingDetail->mobile_no = $request->mobile_no;

        $shippingDetail->save();

        return response()->json([
            'message' => 'Your shipping detail was updated successfully.'
        ]);
    }

    /***
     * Display shipping details of user
     */
    public function destroyShippingDetail($id)
    {
        $shippingDetail = ShippingDetail::find($id);
        $shippingDetail->delete();
        
        return response()->json([
            'message' => 'Shipping detail has beed removed successfully.'
        ]);
    }

    /***
     * Display shipping details of user
     */
    public function getShippingDetails()
    {
        $shippingDetail = ShippingDetail::where('user_id', Auth::id())
                            ->get();
        if($shippingDetail->count() != 0)
        {
            return response()->json($shippingDetail);
        }
        else
        {
            return response()->json([
                'message' => 'You don\'t have any shipping detail.'
            ]);
        }
    }

    /***
     * Display shipping details of user
     */
    public function getShippingDetail($id)
    {
        $shippingDetail = ShippingDetail::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->get();

        if($shippingDetail->count() != 0)
        {
            return response()->json($shippingDetail);
        }
        else
        {
            return response()->json([
                'message' => 'No shipping detail found.'
            ]);
        }
    }
}
