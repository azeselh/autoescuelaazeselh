<?php session_start();?>
<?php require_once "login.php";
$conexion=mysqli_connect($host,$user,$pass,$database);
if (!$conexion) {
    echo "Error de Conexion";
    exit();
}else {
    $DNI=$_POST["DNI"];
    $Nombre=$_POST["nombre"];
    $Fnac=$_POST["fnac"];
    $telefono=$_POST["tfno"];
    $verificador=$_POST["verificador"];
    $passxd = $_POST['pass'];
    $cifrada = password_hash($passxd,PASSWORD_DEFAULT);

        $consulta = "select Codigo from codigosregistro where DNI='$DNI'";
        $ejecucion = mysqli_query($conexion, $consulta);
        while ( $filas = mysqli_fetch_assoc($ejecucion) ) {
            $verifcodigo=$filas["Codigo"];
     }

     if ($verificador==$verifcodigo) {
        $consulta2 = "select DNI from estudiantes where DNI = '$DNI'";
        $ejecucion2 = mysqli_query($conexion, $consulta2);
        while ( $filas = mysqli_fetch_assoc($ejecucion2) ) {
            $existe=$filas["DNI"];
     }
        if (isset($existe)) {
            echo "Estudiante ya registrado";
        }else {
            $consulta3 = "INSERT INTO estudiantes VALUES ('$DNI','$Nombre','$telefono','$Fnac','$cifrada')";
            $ejecucion3 = mysqli_query($conexion, $consulta3);
            header('location:./signin.php');
        }
     }else {
        $_SESSION["Alerta"]="PIDA SU CODIGO AL ADMINISTRADOR";
        header('location:./signup.php');
     }
    }
    
    session_destroy();
?>