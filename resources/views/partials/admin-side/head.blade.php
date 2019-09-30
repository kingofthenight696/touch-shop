<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" >
<link href="{{ asset('fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" >
<link href="{{ asset('plugins/tooltipster/css/tooltipster.bundle.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">

<link href="{{asset('plugins/imageareaselect/css/imgareaselect-animated.css')}}" rel="stylesheet">

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/panzoom.js')}}"></script>
<script src="{{asset('plugins/tooltipster/js/tooltipster.bundle.min.js')}}"></script>
<script src="{{asset('js/utils.js')}}"></script>
<script  type="text/javascript"  src="{{asset('plugins/imageareaselect/scripts/jquery.imgareaselect.pack.js')}}"></script>
<script src="{{asset('js/initAdmin.js')}}"></script>

<script type="text/javascript">

        @if(!empty($board))
    let board = @json($board);
    @endif

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
