<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckoutProduct extends Model
{
    protected $fillable = ['checkout_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
