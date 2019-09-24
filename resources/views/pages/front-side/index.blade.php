@extends('layouts.front-side')
@section('content')

<div class="shelf">
    <div class="shelf__image">
        <img  src="img/boards/shelf-low.jpg" data-full-src="img/boards/shelf.jpg">
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

    <script type="text/javascript">

        $(function(){
            ShelfShop.init();
        });
    </script>
@stop
