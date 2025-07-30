<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Hola {{$info['ReportadoPor']}}</p>
                <p>Tu reporte con consecutivo <strong>{{ $info['consecutivo'] }}</strong> fue rechazado por el siguiente motivo <strong>{{ $info['resuesta'] }}</strong></p>
                <hr />
                <small>Este correo fue generado automáticamente y no es necesario responder a este mensaje.</small>
                <small>Este correo fue generado automáticamente por el sistema de Reporta y Aporta de PANAL S.A.S</small>
            </div>
        </div>
    </div>
</body>

</html>
