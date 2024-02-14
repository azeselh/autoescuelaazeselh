<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="navinicio">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./index.html"><img src="./Files/home.jpg" width="15%"></a></li>
        </ol>
        </nav>
    </div>
<form action="registro.php" method="post" class="registro">
    <legend align="center"><video src="./Files/AUTOESCUELA.mp4" width="20%" autoplay muted loop></video></legend>
        <table align="center">
            <tr>
                <td>DNI:</td>
                <td class="datos"><input type="text" name="DNI" required></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td class="datos"><input type="text" name="nombre" required></td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td class="datos"><input type="password" name="pass" required></td>
            </tr>
            <tr>
                <td>Fecha de Nacimiento:</td>
                <td class="datos"><input type="date" name="fnac" min="1900-01-01" max="2005-12-31" required></td>
            </tr>
            <tr>
                <td>Teléfono:</td>
                <td class="datos"><input type="tel" minlength="9" maxlength="9" name="tfno" required></td>
            </tr>
            <tr>
                <td>Código Verificador:</td>
                <td class="datos"><input type="text" name="verificador" required></td>
            </tr>
        </table>
        <br>
        <div align="center">
            <input class="button" type="submit" value="Registrarse"><input class="button" type="reset" value="Borrar">
        </div>
    </form>
    <?php if (isset($_SESSION["Alerta"])) {
    echo "<h1 align='center'>".$_SESSION['Alerta']."</h1>";
    }
    session_destroy(); ?>
</body>
</html>