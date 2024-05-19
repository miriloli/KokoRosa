<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>
        {{$appointment->service->name}}
    </p>
    <p>
        {{$appointment->date}}
    </p>
    @dump($service)
</body>

</html>