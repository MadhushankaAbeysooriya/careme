<x-laravel-ui-adminlte::adminlte-layout>

    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name') }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.css') }}">


        <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])


        @yield('third_party_stylesheets')

        @stack('page_css')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('images/logo.png');}}"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->fname }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="{{ asset('images/logo.png');}}"
                                    class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->fname }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            @stack('scripts')

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; 2014-2023 InfoMark.</strong> All rights
                reserved.
            </footer>
        </div>

            <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
            {{-- <script src="{{ asset('plugins/jquery/jquery.js') }}" defer></script> --}}
            <script src="{{ asset('plugins/toastr/toastr.min.js') }}" defer></script>

            @yield('third_party_scripts')

            @stack('page_scripts')

            @if(session()->has('info'))
            <script>
                $(document).ready(function(){
                    toastr.options = {
                        "progressBar": true,
                        "closeButton": true,
                    };
                    toastr.info({{ session()->get('info') }})
                });
            </script>
            @endif

            @if(session()->has('danger'))
            <script>
                $(document).ready(function(){
                    toastr.options = {
                        "progressBar": true,
                        "closeButton": true,
                    };
                toastr.error('{{ session()->get('danger') }}')
            });
            </script>
            @endif

            @if(session()->has('success'))
            <script>
                $(document).ready(function(){
                    toastr.options = {
                        "progressBar": true,
                        "closeButton": true,
                    };
                toastr.success('{{ session()->get('success') }}')
            });
            </script>
            @endif

            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
