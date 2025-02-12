<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('web.title', __('titles.brand'))</title>
    <link rel="icon" type="image/x-icon" sizes="152x152" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}?v={{ time() }}">
    <script src="{{ asset('assets/js/jQuery.js') }}"></script>
</head>

<body>

    <!-- Top navbar -->
    @include('layouts.includes.topNav')

    <!-- Main navbar -->
    @include('layouts.includes.mainNav')

    <!-- content -->
    @yield('content')

    <!-- Scripts -->
    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/custome.js') }}?v={{ time() }}"></script>

    <script>
        // تأكد من أن الـ DOM جاهز
        window.onload = function() {
            // الحصول على جميع العناصر التي تحتوي على الـ alert class
            var alertBoxes = document.querySelectorAll('.alert');

            // لكل alert، تنفيذ الكود بعد 3 دقائق (180000 ميلي ثانية)
            alertBoxes.forEach(function(alertBox) {
                setTimeout(function() {
                    $(alertBox).fadeOut('slow'); // تأثير الانزلاق لإخفاء الـ alert
                }, 180000); // 180000 ميلي ثانية = 3 دقائق
            });
        };
    </script>
</body>

</html>