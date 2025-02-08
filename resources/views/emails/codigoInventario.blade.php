<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PLANTILLA - MERLA</title>
    </head>
    <body>
        <?php
        use App\Models\codValidacion;
        $password = rand(1000, 9999);
        $codigo = [];
        $codigo['codigo'] = $password;
        codValidacion::create($codigo);
        ?>
        <h1>Codigo de verificación</h1>
        <p>Código de verificación: {{$password}}</p>
        <p>Folio del pedido: {{$folio}}</p>
        <br>
        <p>Porfavor tenga su codigo a la mano el dia de entrega</p>
        <br>
        <img src="{{ asset('assets/bannerMerla.png') }}" alt="Logo MERLA" width="1088" height="262">

    </body>
</html>