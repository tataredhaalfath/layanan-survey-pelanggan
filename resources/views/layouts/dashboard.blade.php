<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="https://via.placeholder.com/50" type="image/x-icon" />

    @include('partials.dashboard.styles')
    <title>@yield('title')</title>
    @stack('style')
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">
                <a href="index.html" class="logo">
                    <img src="https://via.placeholder.com/100x35" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            {{-- navbar header --}}
            @include('partials.dashboard.navbar')
            {{-- end navbar header --}}
        </div>

        @include('partials.dashboard.sidebar')

        <div class="main-panel">
            <div class="container">
                <div class="page-inner mt-5">
                    @yield('content')
                </div>
            </div>
            @include('partials.dashboard.footer')
        </div>
    </div>
    @include('partials.dashboard.scripts')
    @stack('script')
</body>

</html>
