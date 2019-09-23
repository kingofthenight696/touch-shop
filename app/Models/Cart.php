<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $appends = ['total_price', 'total_quantity'];

    protected $fillable = [
        'user_id',
        'session',
        'created_at',
        'updated_at',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCartBySession($sessionId)
    {
        return Cart::bySession($sessionId)->first();
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session', $sessionId);
    }

    public function getTotalPriceAttribute()
    {
        return $this->cartItems()->sum(DB::raw('quantity * price'));
    }

    public function getTotalQuantityAttribute()
    {
        return $this->cartItems()->sum(DB::raw('quantity'));
    }

    public function getCartByUserOrSession(int $user_id = null, string $session_id)
    {
        return Cart::when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->orWhere('session', $session_id)->with([
            'cartItems',
        ]);
    }
}
