<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductOrder;
use Illuminate\Support\Facades\Auth;

class ProductOrderController extends Controller
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
        $cart = ProductOrder::where('order_id', $request->orderid)
                    ->where('fp_id', $request->productid)
                    ->first();
                    
        if($cart) {
            $cart->quantity = $cart->quantity + $request->qty;
        }
        else {
            $cart = new ProductOrder();
            
            $cart->order_id = $request->orderid;
            $cart->fp_id = $request->productid;
            $cart->quantity = $request->qty;
            $cart->status = 0;
        }
        
        $cart->save();

        return response()->json([
            'message' => 'Product successfully added to cart!'
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cart = ProductOrder::find($id);
        $cart->quantity = $request->qty;
        $cart->status = (isset($request->status)? $request->status : $cart->status);
        $cart->save();

        return response()->json([
            'message' => 'Product updated!'
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
        $cart = ProductOrder::find($id);
        $cart->delete();

        return response()->json([
            'message' => 'Product removed from cart!'
        ]);
    }

    public function displayProductsForDispatch()
    {
        $cart = ProductOrder::with('FarmerProduct')
                ->where('status', 0)
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->get();
        $cart->load('FarmerProduct');
        $cart->load('Order.User');
        if($cart->count()) {
            return response()->json($cart);
        }
        else {
            return response()->json([
                'message' => "There are no items for dispatch!"
            ]);
        }
    }
}
