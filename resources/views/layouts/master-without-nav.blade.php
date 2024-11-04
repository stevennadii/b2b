<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>B2B Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="B2B Dashboard" name="description" />
    <meta content="PT. Evo Nusa Bersaudara" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="">
    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
