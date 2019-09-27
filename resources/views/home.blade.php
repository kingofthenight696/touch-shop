@extends('layouts.app')

@section('content')

<div class="shelf" data-board-id="{{$board->id}}">
    <div class="shelf__image">
        <img id="board" src="{{ asset('img/boards/'.$board->path) }}" data-full-src="{{ asset('img/boards/'.$board->path) }}">

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
            <button class="btn btn-primary product-edit">
                <span><i class="fa fa-edit"></i></span>
            </button>
            <button class="btn btn-danger product-remove">
                <span><i class="fa fa-times"></i></span>
            </button>
        </div>
    </div>
</div>

<div class="container marketing">
    <div class="row">
        <div class="mr-auto"></div>
        <div class="btn-group mt-3" role="group" aria-label="Basic example">
            <a href="{{route('downloadProduct')}}" download class="btn btn-primary product-search" ><i class="fa fa-download mr-1"></i>Download products</a>
            <form action="{{route('uploadProduct')}}" class="product-upload" method="post" enctype="multipart/form-data">
                <input class="product-upload" type='file' hidden/>
                <button type="button" class="btn btn-primary product-upload"><i class="fa fa-upload mr-1"></i>Upload products</button>
            </form>
            <form action="{{route('uploadBoard')}}" class="board-upload" method="post" enctype="multipart/form-data">
                <input class="board-upload" type='file' hidden/>
                <button type="button" class="btn btn-primary board-upload"><i class="fa fa-upload mr-1"></i>Upload board image</button>
            </form>
        </div>

{{--        <div class="dropdown mt-3">--}}
{{--            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                Dropdown button--}}
{{--            </button>--}}
{{--            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                    <a href="{{route('downloadProduct')}}" download class=" product-search" ><i class="fa fa-download mr-1"></i>Download products</a>--}}
{{--                    <form action="{{route('uploadProduct')}}" class="product-upload" method="post" enctype="multipart/form-data">--}}
{{--                        <input class="product-upload" type='file' hidden/>--}}
{{--                        <button type="button" class="btn btn-primary product-upload"><i class="fa fa-upload mr-1"></i>Upload products</button>--}}
{{--                    </form>--}}
{{--                    <form action="{{route('uploadProduct')}}" class="board-upload" method="post" enctype="multipart/form-data">--}}
{{--                        <input class="board-upload" type='file' hidden/>--}}
{{--                        <button type="button" class="btn btn-primary board-upload"><i class="fa fa-upload mr-1"></i>Upload board image</button>--}}
{{--                    </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
@if(!empty($board) && (!$board->products->isEmpty()))
    <div class="container marketing">
        <div class="row">

            <table class="table table-hover mt-3">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
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
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success product-search" data-product-id="{{$product->id}}"><i class="fa fa-search"></i></button>
                                <button type="button" class="btn btn-primary product-edit" data-product-id="{{$product->id}}"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger product-remove" data-product-id="{{$product->id}}"><i class="fa fa-times"></i></button>
                            </div>
                        </td>
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

<div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Do you need to add selected area as product?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="product-form" id="my-awesome-dropzone">
                    <input type="number" hidden name="coordinates[top]" class="top">
                    <input type="number" hidden name="coordinates[left]" class="left">
                    <input type="number" hidden name="coordinates[width]" class="width">
                    <input type="number" hidden name="coordinates[height]" class="height">
                    <input type="number" hidden name="board_id" class="board-id">
                    <div class="input-group mb-3">
                        <label for="product-title">Product title</label>
                        <input id="product-title" type="text" name="title" class="product-title form-control" placeholder="Title" aria-label="Title" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <label for="product-description">Product description</label>
                        <input id="product-description" type="text" name="description" class="product-description form-control" placeholder="Description" aria-label="Description" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <label for="product-price">Product price</label>
                        <input id="product-price" type="number" name="price" step="0.01" min="0" class="product-price form-control" placeholder="Price" aria-label="Price" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary product-save">Add product</button>
                <button type="button" class="btn btn-secondary cancel-product" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product-remove-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    Do you want to remove this product?
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger product-remove-yes">Yes</button>
                <button type="button" class="btn btn-primary cancel-product" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection
