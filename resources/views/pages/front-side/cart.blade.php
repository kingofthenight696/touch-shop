@extends('layouts.front-side')
@section('content')
            @if(!empty($cart->cartItems) && (!$cart->cartItems->isEmpty()))
                <div class="container marketing">
                    <div class="row">

                    <table class="table table-hover mt-5">
                    <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-center">Qty</th>
                        <th scope="col">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->cartItems as $cartItem)
                        <tr>
                            <td>{{$cartItem->title}}</td>
                            <td>
                                <div class="qty">
                                    <span class="minus bg-dark">-</span>
                                    <input type="number" class="count" name="qty" value="{{$cartItem->quantity}}" data-product_id="{{$cartItem->product_id}}">
                                    <span class="plus bg-dark">+</span>
                                </div>
                            </td>
                            <td>{{$cartItem->price}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="p-2 bg-dark w-100">
                    <div class="text-right text-white">Total: $
                        <span class="total_price">
                            {{$cart->total_price}}
                        </span></div>
                </div>
                    </div><!-- /.row -->
                </div><!-- /.container -->
            @else
                <div class="container h-100">
                    <div class="row h-100 justify-content-center align-items-center">
                        <h1>
                            Your cart is empty
                        </h1>
                    </div>
                </div>
            @endif
@stop
