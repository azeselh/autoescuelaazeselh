<?php session_start();?>
<?php require_once "login.php";
$conexion=mysqli_connect($host,$user,$pass,$database);
if (!$conexion) {
    echo "Error de Conexion";
    exit();
}else {
    $uname = $_POST['ID'];
    $contra = $_POST['passwd'];
    $consulta="SELECT * FROM estudiantes WHERE DNI = '$uname'";
    $resultado = mysqli_query($conexion, $consulta);
    while ( $filas = mysqli_fetch_assoc($resultado) ) {
            $hash=$filas['Contrasena'];
            $nom=$filas['Nombre'];
    }
      if(password_verify($contra,$hash)) {
        $_SESSION["nombre"] = $nom;
        $_SESSION["id"] = $uname;
        header("location:./temario.php");
      }
      else {
         $_SESSION["Alerta"] = " Usuario O Contraseña Erronea";
         header("location:./signin.php");
      }
    }
 ?>