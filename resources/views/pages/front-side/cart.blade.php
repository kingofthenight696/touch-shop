@extends('layouts.front-side')
@section('content')
    <div class="container marketing">
{{--        <!-- Three columns of text below the carousel -->--}}
        <div class="row">
            @if(!empty($cart->cartItems))
                <table class="table table-hover mt-5">
                    <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Qty</th>
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
            @else
                <h1>
                    Your cart is empty
                </h1>
            @endif
        </div><!-- /.row -->
{{--        <!-- START THE FEATURETTES -->--}}

{{--        <hr class="featurette-divider">--}}
{{--        <!-- /END THE FEATURETTES -->--}}

    </div><!-- /.container -->
@stop
