@extends('layouts.front-side')
@section('content')

{{--    <div class="container marketing">--}}

{{--        <!-- Three columns of text below the carousel -->--}}
{{--        <div class="row">--}}

{{--            <div class="shelf">--}}
{{--                <div class="shelf__image">--}}
{{--                    <img src="img/boards/shelf-low.jpg" data-full-src="img/boards/shelf.jpg">--}}
{{--                </div>--}}
{{--                <div class="shelf__zoom">--}}
{{--                    <i class="shelf__zoom-button shelf__zoom-plus fas fa-search-plus"></i>--}}
{{--                    <i class="shelf__zoom-button shelf__zoom-minus fas fa-search-minus"></i>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="tooltip_templates">--}}
{{--                <div class="shelf__tooltip__content" data-tooltip-base="true">--}}
{{--                    <h3 class="shelf__tooltip__text"></h3>--}}
{{--                    <div class="shelf__tooltip__action">--}}
{{--                        <a class="button button--green button--ajax" href="/">--}}
{{--                            <img src="img/loading_white_green.gif">--}}
{{--                            <span>Add to cart</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div><!-- /.row -->--}}
{{--        <!-- START THE FEATURETTES -->--}}

{{--        <hr class="featurette-divider">--}}
{{--        <!-- /END THE FEATURETTES -->--}}

{{--    </div><!-- /.container -->--}}

{{--    <!-- FOOTER -->--}}
{{--    <footer class="container">--}}
{{--        <p class="float-right"><a href="#">Back to top</a></p>--}}
{{--        <p>© 2017-2019 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>--}}
{{--    </footer>--}}



<div class="cart">
    Cart: <span>0</span> item(s).
</div>

<div class="shelf">
    <div class="shelf__image">
        <img src="img/boards/shelf-low.jpg" data-full-src="img/boards/shelf.jpg">
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
