<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'price', 'stock', 'brand', 'min_allowed_stock', 'description', 'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class, 'checkout_product', 'product_id');
    }

    public function checkoutProducts()
    {
        return $this->hasMany(CheckoutProduct::class);
    }
}
