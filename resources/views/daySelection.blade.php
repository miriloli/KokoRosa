<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selecciona fecha y hora</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
                        <a class="btn btn-dark nav-link rounded active" href="./home">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="btn btn-dark nav-link rounded active" href="./profile">Perfil</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="btn btn-dark nav-link rounded active" href="./yourAppointments">Tus citas</a>
                    </li>
                </ul>
            </nav>

        </div>

        <div class="text-center py-3 my-3">
            <img class="rounded-circle mb-3" src="{{url('assets/logo.png')}}" height="128" width="128">

        </div>
        <div class="container mt-5">


            <div class="form-group">
                <label for="datetimepicker">Seleccionar Fecha:</label>

                <div class="input-group date" id="datetimepicker" data-target-input="nearest">

                    <input id="date" type="date" class="form-control datetimepicker-input" data-target="#datetimepicker" @if(isset($date)) value="{{$date}}" @endif />

                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">

                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>

            @if(isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
            @endif

            @if (isset($finallyAvailableHours))

            <div id="availableHoursContainer">
                <div class="form-group">
                    <label>Seleccionar Hora:</label>
                </div>

                @foreach ($finallyAvailableHours as $hour)
                <p>
                    <a class="hours" role="button">{{ substr($hour, 0, 5) }}</a>
                </p>
                @endforeach
            </div>
            @endif

        </div>
     
        <script>
            var selectedDate;

            document.addEventListener('DOMContentLoaded', function() {
                var inputDate = document.getElementById('date');

                inputDate.addEventListener('input', function() {
                    let date = inputDate.value;
                    selectedDate = date.split('-').reverse().join('-');
                    fetch('/appointment', {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            date: date
                        })
                    }).then(response => {
                        if (response.ok) {

                            return response.text();
                        } else {
                            console.error('Error en la solicitud:', response.statusText);
                        }
                    }).then(data => {
                        document.open();
                        document.write(data);
                    }).catch(error => {
                        console.error('Error en el fetch:', error);
                    });
                });
            });


            var buttonHours = document.getElementsByClassName('hours');
            buttonHours = Array.from(buttonHours);
            buttonHours.forEach(element => {
                element.addEventListener('click', function() {

                    let selectedService = localStorage.getItem('selectedService');
                    fetch('/confirmation', {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            hour: element.innerText.trim()+':00',
                            service: selectedService,
                            date: selectedDate
                        })
                    }).then(response => {
                        if (response.ok) {
                            return response.text();
                        } else {
                            console.error('Error en la solicitud:', response.statusText);
                        }
                    }).then(data => {
                        document.open();
                        document.write(data);
                        document.close();
                    }).catch(error => {
                        console.error('Error en el fetch:', error);
                    });
                });
            });
        </script>

        <footer class="footer">
            <p>© KokoRosa 2024</p>
        </footer>

    </div> <!-- /container -->


</body>