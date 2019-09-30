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
                        <th scope="col" class="text-right">Remove</th>
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
                            <td class="text-right">
                                <span
                                    data-product-id="{{$cartItem->id}}"
                                    class="cart-action bg-dark cart-item-remove">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </td>
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


                <div class="modal fade" id="cart-item-remove-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Remove product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h4>
                                    Do you want to remove this product from you cart?
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger cart-item-remove-yes">Yes</button>
                                <button type="button" class="btn btn-primary cancel-product" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
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
