<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
    @include('includes.styles')
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main-panel">
            @include('partials.navbar')
            <div class="container">
                <div class="page-inner">

                    @yield('content')
                </div>
            </div>
            @include('partials.footer')
        </div>

       @include('partials.custom')
    </div>
    @stack('scripts')
    @include('includes.scripts')
</body>

</html>
