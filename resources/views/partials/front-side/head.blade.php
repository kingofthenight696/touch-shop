<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Shelfshop</title>

<!-- Bootstrap core CSS -->

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" >
<link href="{{ asset('fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" >
<link href="{{ asset('plugins/tooltipster/css/tooltipster.bundle.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet" >

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/panzoom.js')}}"></script>
<script src="{{asset('plugins/tooltipster/js/tooltipster.bundle.min.js')}}"></script>
<script src="{{asset('js/utils.js')}}"></script>
<script src="{{asset('js/shelfshop.js')}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @if(!empty($board))
    let board = @json($board);
    @endif
</script>

<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
