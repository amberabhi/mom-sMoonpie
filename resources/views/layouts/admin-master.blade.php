<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Moms Moonpie - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Moms Moonpie - Admin" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico') }}">

    @stack('css')
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>

<body data-layout="detached" data-topbar="colored">
    <!-- Begin page -->
    <div class="container-fluid">
        <div id="layout-wrapper">
            @include('layouts.admin.partials.topbar')
            @include('layouts.admin.partials.sidebar')
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('layouts.admin.partials.footer')
            </div>

        </div>
    </div>

    @include('layouts.admin.partials.right-sidebar')
    @include('layouts.admin.vendor-scripts')
</body>

</html>
