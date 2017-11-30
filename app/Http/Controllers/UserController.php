<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\FarmerProduct;

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
        //
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
    public function update(Request $request, $id)
    {
        //
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
