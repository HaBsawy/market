<?php

namespace App\Http\Controllers;

use App\Checkout;
use App\CheckoutProduct;
use App\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
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

    }

    public function destroy(Checkout $checkout)
    {

    }
}
