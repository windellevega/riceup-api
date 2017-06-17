<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FarmerProduct;
use App\User;
use Illuminate\Support\Facades\Auth;

class FarmerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id='all')
    {
        if($id == 'all') {
            $products = FarmerProduct::all();
            $products->load('User');
        }
        else {
            $products = FarmerProduct::where('user_id', $id)
                            ->get();
            $product->load('User');
        }
        
        
        return response()->json($products);
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
            'name' => 'required',
            'desc' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
            'stocks' => 'required|numeric',
            'harvest_date' => 'required|date'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->all());
        }

        $product = new FarmerProduct();

        $product->user_id = '2'; //@todo: replace with id of logged in user using Auth::id()
        $product->product_name = $request->name;
        $product->photo_url = (isset($request->photo_url) ? $request->photo_url : '/photos/product/default.jpg');
        $product->product_desc = $request->desc;
        $product->unit_type = $request->unit;
        $product->price_per_unit = $request->price;
        $product->stocks_available = $request->stocks;
        $product->date_of_harvest = $request->harvest_date;+
        $product->save();

        return response()->json([
            'message' => 'Product successfully added!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = FarmerProduct::where('id', $id)
                        ->get();
        return response()->json($product);
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
