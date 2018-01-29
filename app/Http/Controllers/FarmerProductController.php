<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\FarmerProduct;
use App\User;

use Carbon\Carbon;

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
            $products->load('User');
        }

        if($products->count() <= 0) {
            return response()->json([
                'message' => 'No products are found!'
            ]);
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

        $product->user_id = Auth::id(); //@todo: replace with id of logged in user using Auth::id()
        $product->product_name = $request->name;

        /*if(isset($request->image)) {
            $fileName = Carbon::now()->timestamp . '.' . $request->image->getClientOriginalExtension();
            $imageFile = $request->image->move(public_path('photos/product'), $fileName);
            $product->photo_url = 'public/photos/product/' . $fileName;
        }
        else {
            $product->photo_url = 'public/photos/product/default.jpg';
        }*/
        $product->photo_url = isset($request->photo_url) ? $request->photo_url : 'public/photos/product/default.jpg';
        
        $product->product_desc = $request->desc;
        $product->unit_type = $request->unit;
        $product->price_per_unit = $request->price;
        $product->stocks_available = $request->stocks;
        $product->date_of_harvest = $request->harvest_date;

        

        $product->save();

        return response()->json([
            'message' => 'Product successfully added.'
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
        if($product->count() <= 0) {
            return response()->json([
                'message' => 'No product found.'
            ]);
        }
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

        $product = FarmerProduct::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();

        $product->product_name = $request->name;

        /*if(isset($request->image)) {
            $fileName = Carbon::now()->timestamp . '.' . $request->image->getClientOriginalExtension();
            $imageFile = $request->image->move(public_path('photos/product'), $fileName);
            $product->photo_url = 'public/photos/product/' . $fileName;
        }
        else {
            $product->photo_url = 'public/photos/product/default.jpg';
        }*/
        $product->photo_url = isset($request->photo_url) ? $request->photo_url : 'public/photos/product/default.jpg';
        
        $product->product_desc = $request->desc;
        $product->unit_type = $request->unit;
        $product->price_per_unit = $request->price;
        $product->stocks_available = $request->stocks;
        $product->date_of_harvest = $request->harvest_date;

        $product->save();

        return response()->json([
            'message' => 'Product successfully updated.'
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
        $product = FarmerProduct::where('id', $id)
                    ->where('user_id', Auth::id());
        if($product->count()) {
            $product->delete();
            return response()->json([
                'message' => 'Product successfully removed.'
            ]);
        }
        else {
            return response()->json([
                'message' => 'Either product doesn\'t exist or you are unauthorized to delete this product.'
            ]);
        }        
    }
}
