<?php

namespace App\Http\Controllers\FrontSide;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(CartService $cartService)
    {
        $board = Board::with('products')->first();
        $cart = $cartService->getCart();

       return view( 'pages.front-side.index', compact('board', 'cart'));
    }
}
