<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.admin-side.head')
</head>
<body>
<div id="app">

    @include('partials.admin-side.header')
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
