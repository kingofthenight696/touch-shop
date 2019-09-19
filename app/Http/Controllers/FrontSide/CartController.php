<?php

namespace App\Http\Controllers\FrontSide;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request, CartService $cartService)
    {
        return view('pages.front-side.index', $cartService->getCart());
    }

    public function changeCartItem(Request $request, CartService $cartService)
    {
        try {
            $cartService->changeCartItemQuantity($request->only(['product_id', 'quantity']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function removeCartItem(Request $request, $productId, CartService $cartService)
    {
        try {
            $cartService->removeCartItem($productId);
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function removeCart(Request $request, $productId, CartService $cartService)
    {
        try {
            $cartService->removeCart($productId);
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }
}
