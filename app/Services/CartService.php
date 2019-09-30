<?php namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    private $session_id;
    private $product_id;
    private $quantity;
    private $cart;


    public function __construct(Request $request, Cart $cart)
    {
        $this->product_id = $request->product_id;
        $this->quantity = $request->quantity ?? 1;
        $this->cart = $cart;

        $this->session_id = Session::get('session_key') ?? $this->setSession();
    }

    private function setSession()
    {
        $session_id = Str::random(40);
        Session::put('session_key', $session_id);

        return $session_id;
    }

    public function getCart()
    {
        return Cart::where('session', $this->session_id)
            ->with('cartItems')
            ->latest('created_at')
            ->first();
    }

    public function changeCartItemQuantity()
    {
        Log::info('start');
        $cart = $this->checkUnexistingCart();
        Log::info('1');
        Log::info(print_r($cart->toArray(), true));

        $item = $cart->whereHas('cartItems', function ($query) {
            $query->where('product_id', $this->product_id);
        })->with(['cartItems'])->first();

        if ($item) {
            $res = $item->cartItems()->where('product_id', $this->product_id)->update(['quantity' => $this->quantity]);

            return $res;
        }

        Log::info('3');
        $product = Product::find($this->product_id);

        Log::info('4');
        $result = $cart->cartItems()->create(
            [
                'product_id' => $product->id,
                'board_id' => $product->board_id,
                'price' => $product->price,
                'quantity' => $this->quantity,
                'title' => $product->title,
            ]
        );

       Log::info($result);
        Log::info('finish');
        return true;
    }

    private function checkUnexistingCart()
    {
        if (!$cart = $this->cart->getCartBySession($this->session_id)->first()) {
            $cart = Cart::create([
                'session' => $this->session_id,
            ]);
        }

        return $cart;
    }

    public function removeCartItem($productId)
    {
        $cart = $this->cart->getCartBySession($this->session_id)->first();

        if ($cart->cartItems()->count() === 1) {
            $this->removeCart();

        } else {
            $cart->cartItems()->where('product_id', $productId)->delete();
        }
        return true;
    }

    public function removeCart()
    {
        return Cart::whereSession($this->session_id)->delete();
    }

    protected function clearCartItem($cartItems)
    {
        return $cartItems->transform(function ($item) {
            return $item->only([
                'product_id',
                'price',
                'total_price',
                'quantity',
                'preview',
                'title'
            ]);
        });
    }
}
