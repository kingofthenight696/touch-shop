<?php namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    private $user_id;
    private $session_id;
    private $product_id;
    private $quantity;
    private $cart;


    public function __construct(Request $request, Cart $cart)
    {
        $this->user_id = $request->user() ? $request->user()->id : null;
        $this->product_id = $request->product_id;
        $this->quantity = $request->quantity ?? 1;


        $this->session_id = Session::get('session_key') ?? $this->setSession();
        $this->cart = $cart;

        $userCart = (!is_null($this->user_id))
            ? $this->cart->getCartByUser($this->user_id)
            : null;

        $sessionCart = $this->cart->getCartBySession($this->session_id);

        if ((!is_null($sessionCart) && !is_null($userCart)) && $sessionCart->diffAssoc($userCart)) {
            $this->mergeCarts($userCart, $sessionCart);
        }
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
        $cart = $this->checkUnexistingCart();


        $item = $cart->whereHas('cartItems', function ($query) {
            $query->where('product_id', $this->product_id);
        })->first();

        if ($item) {
            return $item->cartItems()->where('product_id', $this->product_id)->update(['quantity' => $this->quantity]);
        }
        $product = Product::find($this->product_id);

        $cart->cartItems()->create(
            [
                'product_id' => $product->id,
                'board_id' => $product->board_id,
                'price' => $product->price,
                'quantity' => $this->quantity,
                'title' => $product->title,
            ]
        );
        return true;
    }

    private function checkUnexistingCart()
    {
        if (!$cart = $this->cart->getCartByUserOrSession($this->user_id, $this->session_id)->first()) {
            $cart = Cart::create([
                'user_id' => ($this->user_id) ?? null,
                'session' => $this->session_id,
            ]);
        }

        return $cart;
    }

    public function removeCartItem($productId)
    {
        $cart = Cart::whereSession($this->session_id)->first();

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
