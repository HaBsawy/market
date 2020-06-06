<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = ['user_id', 'status', 'totalPrice'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'checkout_product', 'checkout_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkoutProducts()
    {
        return $this->hasMany(CheckoutProduct::class);
    }
}
