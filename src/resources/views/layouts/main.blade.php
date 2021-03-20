<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Jobs</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab&family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/file-input.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    @stack('css')

</head>
<body>

    <main class="bt-flex-center-container">
        @include('components.validation_error_display')
        @include('flash::message')
        @yield('content')
    </main>

    <script src="https://kit.fontawesome.com/4cd8c58f6d.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/libs/inputmask/dist/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/system.js') }}"></script>
    <script src="{{ asset('js/file-input.js') }}"></script>

    @stack('js')
</body>
</html>