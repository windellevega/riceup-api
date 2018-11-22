<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductOrder;
use App\FarmerProduct;
use App\CartProductStatus;
use Illuminate\Support\Facades\Auth;

define('STATUS_PENDING', 0);
define('STATUS_PACKED', 1);
define('STATUS_DELIVERED', 2);
define('STATUS_CANCELLED', 3);
define('STATUS_RECEIVED', 4);

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
        $product = FarmerProduct::find($request->productid);

        $availablestocks = $product->stocks_available - $product->reserved;
        
        if($availablestocks < $request->qty) {
            return response()->json([
                'message' => 'Insufficient stocks available'
            ]);
        }

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
        }

        $product->reserved += $request->qty;
        $product->save();
        $cart->save();

        $cartprodstatus = new CartProductStatus();
        $cartprodstatus->po_id = $cart->id;
        $cartprodstatus->product_status = STATUS_PENDING;
        $cartprodstatus->details = "Product is being processed.";
        $cartprodstatus->save();

        return response()->json([
            'message' => 'Product successfully added to cart.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithCurrentStatus($id)
    {
        /*$cart = ProductOrder::with('FarmerProduct')
                ->where('status', 0)
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereHas('Order', function($q) {
                    $q->where('order_status', 1);
                })
                ->get();
        $cart->load('FarmerProduct');
        $cart->load('Order.User');
        if($cart->count()) {
            return response()->json($cart);
        }
        else {
            return response()->json([
                'message' => "There are no items for dispatch."
            ]);
        }*/

        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereHas('Order', function($q) {
                    $q->where('order_status', 1);
                })
                ->get();
        $withPending = $cart->where('currentStatus.product_status', STATUS_PENDING);
        $withPending->load('FarmerProduct');
        $withPending->load('Order.User');

        if($withPending->count()) {
            return response()->json($withPending);
        }
        else {
            return response()->json([
                'message' => "There are no items for dispatch."
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
        $cart = ProductOrder::find($id);
        $product = FarmerProduct::find($cart->fp_id);
        $reservedafter = $product->reserved + ($request->qty - $cart->quantity); //8+(5-8) = 5

        if($product->stocks_available < $reservedafter) {
            return response()->json([
                'message' => 'Unable to add more quantity to the product.'
            ]);
        }

        $product->reserved = $reservedafter;
        $cart->quantity = $request->qty;

        $product->save();
        $cart->save();

        return response()->json([
            'message' => 'Product quantity successfully updated on cart.'
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
        $product = FarmerProduct::find($cart->fp_id);
        $cartprodstatus = CartProductStatus::where('po_id', $id);
        $cartprodstatus->delete();

        $product->reserved = $product->reserved - $cart->quantity;

        $product->save();
        $cart->delete();

        return response()->json([
            'message' => 'Product removed from cart.'
        ]);
    }

    public function displayProductsForDispatch()
    {
        /*$cart = ProductOrder::with('FarmerProduct')
                ->where('status', 0)
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereHas('Order', function($q) {
                    $q->where('order_status', 1);
                })
                ->get();
        $cart->load('FarmerProduct');
        $cart->load('Order.User');
        if($cart->count()) {
            return response()->json($cart);
        }
        else {
            return response()->json([
                'message' => "There are no items for dispatch."
            ]);
        }*/
        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->with('currentStatus')
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->get();
        $withPending = $cart->where('currentStatus.product_status', STATUS_PENDING);
        $withPending->load('FarmerProduct');
        $withPending->load('Order.User');

        if($withPending->count()) {
            return response()->json($withPending);
        }
        else {
            return response()->json([
                'message' => "There are no items for dispatch."
            ]);
        }
    }

    public function dispatchProduct($id)
    {
        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->with('currentStatus')
                ->where('id', $id)
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->first();
        //return response()->json($cart->id);
        if($cart->currentStatus->product_status == STATUS_PENDING || $cart->currentStatus->product_status == STATUS_PACKED) {
            if($cart->quantity <= $cart->FarmerProduct->stocks_available) {
                $cart->FarmerProduct->stocks_available -= $cart->quantity;
                $cart->FarmerProduct->reserved -= $cart->quantity;

                $cartProdStatus = new CartProductStatus();
                $cartProdStatus->po_id = $cart->id;
                $cartProdStatus->product_status = STATUS_DELIVERED;
                $cartProdStatus->details = 'Your product has been delivered';

                $cart->save();
                $cart->FarmerProduct->save();
                $cartProdStatus->save();
                return response()->json([
                    'message' => "Product has been dispatched."
                ]);
            }
            else {
                return response()->json([
                    'message' => "Stock is insufficient. Unable to dipatch product."
                ]);
            }     
        }
        else {
            return response()->json([
                'message' => "Unable to dispatch product."
            ]);
        }
    }

    public function packProduct($id)
    {
        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->with('currentStatus')
                ->where('id', $id)
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->first();
        //return response()->json($cart->id);
        if($cart->currentStatus->product_status == STATUS_PENDING) {
            if($cart->quantity <= $cart->FarmerProduct->stocks_available) {

                $cartProdStatus = new CartProductStatus();
                $cartProdStatus->po_id = $cart->id;
                $cartProdStatus->product_status = STATUS_PACKED;
                $cartProdStatus->details = 'Your product has been packed';

                $cart->save();
                return response()->json([
                    'message' => "Product has been packed."
                ]);
            }
            else {
                return response()->json([
                    'message' => "Stock is insufficient. Unable to pack product."
                ]);
            }     
        }
        else {
            return response()->json([
                'message' => "Unable to pack product."
            ]);
        }
    }

    public function cancelProduct($id)
    {
        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->with('currentStatus')
                ->where('id', $id)
                ->whereHas('FarmerProduct')
                ->first();
        //return response()->json($cart->id);
        if($cart->currentStatus->product_status == STATUS_PENDING) {
                $cart->FarmerProduct->reserved -= $cart->quantity;

                $cartProdStatus = new CartProductStatus();
                $cartProdStatus->po_id = $cart->id;
                $cartProdStatus->product_status = STATUS_CANCELLED;
                $cartProdStatus->details = 'You have cancelled this product';

                $cart->FarmerProduct->save();
                $cartProdStatus->save();
                return response()->json([
                    'message' => "Product has been cancelled."
                ]);  
        }
        else {
            return response()->json([
                'message' => "Unable to cancel. Product is already out for delivery."
            ]);
        }
    }
    public function displayProductOrdersPerFarmer($status = -1)
    {
        $cart = ProductOrder::with('FarmerProduct')
                ->has('currentStatus')
                ->with('currentStatus')
                ->whereHas('FarmerProduct', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereHas('Order', function($q) {
                    $q->where('order_status', 1);
                })
                ->get();
        if($status >= 0) 
        {
            $cart = $cart->where('currentStatus.product_status', $status);
        }
        $cart->load('FarmerProduct');
        $cart->load('Order.User');

        if($cart->count()) {
            return response()->json($cart);
        }
        else {
            return response()->json([
                'message' => "There are no items."
            ]);
        }
    }
}
