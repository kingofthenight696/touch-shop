@extends('layouts.app')

@section('content')

<div class="shelf">
    <div class="shelf__image">
        <img id="board" src="img/boards/shelf-low.jpg" data-full-src="img/boards/shelf.jpg">
    </div>
    <div class="shelf__zoom">
        <i class="shelf__zoom-button shelf__zoom-plus fas fa-search-plus"></i>
        <i class="shelf__zoom-button shelf__zoom-minus fas fa-search-minus"></i>
    </div>
</div>


<div class="tooltip_templates">
    <div class="shelf__tooltip__content" data-tooltip-base="true">
        <h3 class="shelf__tooltip__text"></h3>
        <div class="shelf__tooltip__action">
            <a class="button button--green button--ajax" href="/">
                <img src="img/loading_white_green.gif">
                <span>Add to cart</span>
            </a>
        </div>
    </div>
</div>

@if(!empty($board) && (!$board->products->isEmpty()))
    <div class="container marketing">
        <div class="row">

            <table class="table table-hover mt-5">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($board->products as $product)
                    <tr>
                        <td>{{$product->title}}</td>
                        <td>
                            {{$product->description}}
                        </td>
                        <td>{{$product->price}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="p-2 bg-dark w-100">
                <div class="text-right text-white">Product count:
                    <span class="product_count">
                        {{$board->products->count()}}
                    </span>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
@else
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <h1>
                Shelf is empty
            </h1>
        </div>
    </div>
@endif

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Do you need to add selected area as product?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="product-form">
                    <input type="number" hidden name="coordinates[]top" class="top">
                    <input type="number" hidden name="coordinates[]left" class="left">
                    <input type="number" hidden name="coordinates[]width" class="width">
                    <input type="number" hidden name="coordinates[]height" class="height">
                    <div class="input-group mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Title" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="description" class="form-control" placeholder="Description" aria-label="Description" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="price" step="0.01" min="0" class="form-control" placeholder="Price" aria-label="Price" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add-product">Add product</button>
                <button type="button" class="btn btn-secondary cancel-product" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
