<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inicio</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <style>
        .border {
            border: 1px solid black;
            height: 150px;
        }

        .btn-cita {
            border-radius: 24px;
            width: 170px;
        }
    </style>
</head>

<body class="">

    <div class="container p-3">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills float-right">
                    <li class="nav-item mx-2">
                        <a class="btn btn-dark nav-link active rounded" href="./">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="btn btn-dark nav-link active rounded" href="./profile">Perfil</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="btn btn-dark nav-link active rounded" role="button" id="yourAppointments">Tus citas</a>
                    </li>
                </ul>
            </nav>

        </div>

        <div class="text-center py-3 my-3">
            <img class="rounded-circle mb-3" src="{{url('assets/logo.png')}}" height="128" width="128" style="">
            <p>
                <a class="btn btn-lg btn-dark btn-cita" href="./services" role="button">Pedir cita</a>
            </p>
        </div>

        <div class="row marketing text-center">

            <div class=" col-6 border d-flex align-items-center justify-content-center">
                <div class="row">
                    <i class="bi bi-geo-alt text-danger col-12 my-1" style="font-size: 1.6rem; font-weight: bold;""></i>
                    <span class=" col-12 my-1">Calle Inventada Nº 14, 08009 Barcelona</span>
                </div>
            </div>
            <div class=" col-6 border d-flex align-items-center justify-content-center">
                <div class="row">
                    <i class="bi bi-telephone text-danger col-12 my-1" style="font-size: 1.6rem; font-weight: bold;""></i>
                    <span class=" col-12 my-1"> 600203040 </span>
                </div>
            </div>
        </div>

        <footer class="footer row fixed-bottom justify-content-center">
            <p>© KokoRosa 2024</p>
        </footer>

    </div> 

    <script>
        document.getElementById('yourAppointments').addEventListener('click',
            function() {
                fetch('/yourAppointments', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        console.error('Error en la solicitud:', response.statusText);
                        return response.text();
                    }
                }).then(data => {
                    document.open();
                    document.write(data);
                    document.close();
                }).catch(error => {
                    console.error('Error en el fetch:', error);
                });
            }
        );
    </script>
</body>