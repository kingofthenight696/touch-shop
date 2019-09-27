<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.front-side.head')
    </head>
<body cz-shortcut-listen="true">
<main role="main">
    @include('partials.front-side.header')
    @yield('content')
</main>
</body>
</html>
