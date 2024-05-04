<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koko Rosa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</head>

<body>

    <div class="text-center py-3 my-3">
        <img class="rounded-circle mb-3" src="{{url('assets/logo.png')}}" height="128" width="128" style="">

    </div>

    <div class="text-center py-3 my-3">
        <header class="">

            @if (Route::has('login'))
            <nav class="">
                @auth
                <a href="{{ url('/home') }}" class="">
                </a>
                @else
                <a href="{{ route('login') }}" class="">
                    Acceder
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="">
                    Registrarse
                </a>
                @endif
                @endauth
            </nav>
            @endif
            @auth
            <script>
                window.location.href = "{{ url('/home') }}";
            </script>
            @endauth
        </header>

    </div>

</body>

</html>