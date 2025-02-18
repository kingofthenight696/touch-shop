<?php

namespace App\Http\Controllers\FrontSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Board;
use App\Services\CartService;
use \Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request, CartService $cartService)
    {
        $cart = $cartService->getCart();
        $board = Board::first();

        return view('pages.front-side.cart', compact('cart', 'board'));
    }

    public function changeCartItem(Request $request, CartService $cartService)
    {
        try {
            $cartService->changeCartItemQuantity();
        } catch (Exception $exception) {
            return response()->json($exception);
        }

        return response()->json( new CartResource($cartService->getCart()));
    }

    public function removeCartItem(Request $request, $productId, CartService $cartService)
    {
        try {
            $cartService->removeCartItem($productId);
        } catch (Exception $exception) {
            return response()->json($exception);
        }

        return response()->json(new CartResource($cartService->getCart()));
    }

    public function removeCart(Request $request, CartService $cartService)
    {
        try {
            $cartService->removeCart();
        } catch (Exception $exception) {
            return response()->json($exception);
        }
        return response()->json( new CartResource($cartService->getCart()));
    }
}
