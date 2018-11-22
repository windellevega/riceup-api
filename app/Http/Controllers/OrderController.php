<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::where('user_id', Auth::id())
                    ->where('order_status', '!=', '0')
                    ->orderBy('id', 'desc')
                    ->get();
        $order->load('ProductOrder');
        $order->load('ProductOrder.FarmerProduct.User');
        $order->load('ProductOrder.currentStatus');

        if($order->count() != 0) {
            return response()->json($order);
        }
        else {
            return response()->json([
                'message' => 'There are no orders found.'
            ]);
        }
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
        $currorder = Order::where('user_id', Auth::id()) //@todo: change 2 to Auth::id()
                        ->where('order_status', 0)
                        ->get();

        if($currorder->count() > 0) {
            $orderno = $currorder;
        }
        else {
            $order = new Order();

            $order->order_number = Auth::id() . str_pad(rand(1,999), 3, "0", STR_PAD_LEFT) . date('Ymd'); //@todo: change 2 to Auth::id()
            $order->user_id = Auth::id(); //@todo: change 2 to Auth::id()
            $order->order_status = 0;
            $order->products_ctr = 0;

            $order->save();

            $orderno = $order;
        }

        return response()->json([
            'order_number' => $orderno
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
        $order = Order::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();
        $order->load('ProductOrder.currentStatus','ProductOrder.FarmerProduct.User');

        if($order->count() != 0) {
            return response()->json($order);
        }
        else {
            return response()->json([
                'message' => "This order doesn't exist."
            ]);
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
        $order = Order::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->first();
        $order->order_date = Carbon::now();
        $order->mode_of_shipping = $request->shipping_mode;
        $order->order_status = $request->order_status;
        $order->sd_id = $request->sd_id;
        $order->remarks = $request->remarks;

        $order->save();

        return response()->json([
            'message' => "You have checked out your order."
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
