<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<?php require_once "login.php";
session_start();
$conexion = mysqli_connect($host, $user, $pass, $database);


if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

// ID del usuario que ha iniciado sesión
$id_usuario = $_SESSION['id'];

$sql = "SELECT * FROM realizaciones WHERE DNI = '$id_usuario'";
$resultado = mysqli_query($conexion, $sql);
if (mysqli_num_rows($resultado) > 0) {
    echo "<h1 align='center'>ESTE ES TU REGISTRO DE PUNTUACIONES</h1><br>";
    echo "<table align='center' class='puntuaciones'>
                <tr>
                    <th>Tema</th>
                    <th>Fecha</th>
                    <th>Puntuación</th>
                </tr>";
    while($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                    <td>" . $fila["Tema"] . "</td>
                    <td>" . $fila["Fintento"] . "</td>
                    <td>" . $fila["Puntuacion"] . "</td>
                </tr>";
    }
    echo "</table>";  
} else {
    echo "<h1 align='center'>Aún no has realizado ningún test.</h1>";
}
mysqli_close($conexion);
?>
<body>
<br>
<h1 align='center'><a href="./temario.php"><button class="button">Volver al temario</button></a></h1>
</body>
</html>