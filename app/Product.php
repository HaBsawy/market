<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'price', 'stock', 'brand', 'min_allowed_stock', 'description', 'image'
    ];

//    public int $id;
//    public int $user_id;
//    public User $user;
//    public int $category_id;
//    public Category $category;
//    public string $name;
//    public float $price;
//    public int $stock;
//    public string $brand;
//    public int $min_allowed_stock;
//    public string $description;
//    public string $image;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
