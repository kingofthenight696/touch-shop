<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $appends = ['total_price'];

    protected $fillable = [
        'cart_id',
        'product_id',
        'board_id',
        'price',
        'quantity',
        'title',
        'created_at',
        'updated_at',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }


    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

}
