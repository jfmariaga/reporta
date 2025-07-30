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
                <p>Se ha generado un nuevo reporte, el cual debes gestionar</p>
                <ul>
                    <li><strong>Reportado por: </strong>{{ $info['ReportadoPor'] }}.</li>
                    <li><strong>Consecutivo del reporte: </strong>{{ $info['consecutivo'] }}.</li>
                    <li><strong>Area del reporte: </strong>{{ $info['area'] }}.</li>
                    <li><strong>Zona del reporte: </strong>{{ $info['zona'] }}.</li>
                    <li><strong>Prioridad: </strong>{{ $info['prioridad'] }}.</li>
                </ul>

                <p>Para aceptar o rechar este reporte ingresa con tus credenciales de acceso a  <a href="https://reporta.panalapp.com/login">R&A</a></p>
                <hr />

                <small>Este correo fue generado automáticamente y no es necesario responder a este mensaje.</small>
                <small>Este correo fue generado automáticamente por el sistema de Reporta y Aporta de PANAL S.A.S</small>
            </div>
        </div>
    </div>
</body>

</html>
