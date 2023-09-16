<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    @include('partials.styles')
</head>

<body>
    @yield('content')
    @include('partials.scripts')
    @stack('script')
</body>

</html>
