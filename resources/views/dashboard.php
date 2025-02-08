<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Simple en PHP</title>
</head>
<body>
    <h1>¡Bienvenido a mi página PHP simple!</h1>
    <p>La fecha y hora actual es: 
        <?php
        // Muestra la fecha y hora actual
        echo date('Y-m-d H:i:s');
        ?>
    </p>
    <form method="post" action="">
        <label for="nombre">Ingresa tu nombre:</label>
        <input type="text" id="nombre" name="nombre">
        <button type="submit">Enviar</button>
    </form>
    <?php
    // Maneja el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
        $nombre = htmlspecialchars($_POST['nombre']);
        echo "<p>Hola, $nombre. ¡Gracias por visitar esta página!</p>";
    }
    ?>
</body>
</html>
