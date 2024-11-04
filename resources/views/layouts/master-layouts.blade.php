<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-layout-style=""
    data-layout-position="fixed" data-topbar="light">

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

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.customizer')
    <!-- END Right Sidebar -->

    @include('layouts.vendor-scripts')
</body>

</html>
