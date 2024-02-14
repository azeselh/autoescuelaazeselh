<?php require_once "login.php";
$conexion = mysqli_connect($host, $user, $pass, $database);


if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = $_POST['score'];
    $cantidad = $_POST['cantidad'];
    $id = $_POST['id'];
    $tema = $_POST['tema'];
    $insertar="INSERT INTO realizaciones VALUES ('$id','$tema','$score/$cantidad', now())";
    mysqli_query($conexion, $insertar);
    header("Location: Temario.php");
}
?>
