<?php

namespace App\Http\Controllers;

use App\Checkout;
use App\CheckoutProduct;
use App\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $checkouts = Checkout::all();
        $data = [];
        foreach ($checkouts as $checkout) {
            $data[] = [
                'id' => $checkout->id,
                'user' => $checkout->user->name,
                'status' => $checkout->status,
                'totalPrice' => $checkout->totalPrice,
            ];
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $checkout = new Checkout();
        $checkout->user_id = auth()->user()->id;
        $checkout->status = 'preparing';
        $checkout->totalPrice = 0;

        if ($checkout->save()) {
            $totalPrice = 0;
            for($i = 0; $i < $request->numberOfProducts; $i++) {
                $checkoutProduct = new CheckoutProduct();
                $checkoutProduct->checkout_id = $checkout->id;
                $checkoutProduct->product_id = request('product_id'.$i);
                $checkoutProduct->quantity = request('product_quantity'.$i);
                $totalPrice += (integer)request('product_totalPrice'.$i);

                $product = Product::where('id', request('product_id'.$i))->first();
                $product->stock -= (integer)request('product_quantity'.$i);

                $product->save();
                $checkoutProduct->save();
            }
            $checkout->totalPrice = $totalPrice;
            $checkout->save();

            return response()->json([
                'message' => 'checkout is sent',
                'checkout' => [
                    'id' => $checkout->id,
                    'user' => $checkout->user->name,
                    'status' => $checkout->status,
                    'products' => $checkout->checkoutProducts
                ]
            ], 201);
        }
    }

    public function update(Checkout $checkout, Request $request)
    {
        if (auth()->user()->role == 'customer') {
            return response()->json([
                'message' => 'you have not permission to update checkout'
            ], 403);
        }

        $this->validate($request, [
            'status' => 'required|in:preparing,sending,delivered'
        ]);

        $checkout->status = $request->status;

        if($checkout->save()) {
            return response()->json([
                'message' => 'checkout is updated successfully',
                'checkout' => [
                    'id' => $checkout->id,
                    'user' => $checkout->user->name,
                    'status' => $checkout->status
                ]
            ], 202);
        }
    }

    public function destroy(Checkout $checkout)
    {
        if (auth()->user()->role == 'customer') {
            return response()->json([
                'message' => 'you have not permission to delete checkout'
            ], 403);
        }

        $checkoutProducts = $checkout->checkoutProducts;
        $errors = 0;

        foreach ($checkoutProducts as $checkoutProduct) {
            $checkoutProduct->product->stock += (integer)$checkoutProduct->quantity;
            $checkoutProduct->product->save();
            if(!$checkoutProduct->delete()) {
                $errors++;
            }
        }

        if($errors === 0) {
            if($checkout->delete()) {
                return response()->json([
                    'message' => 'checkout is deleted successfully'
                ], 200);
            }
        }
    }
}
