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
            <li class="breadcrumb-item"><a href="./index.html"><img src="./Files/home.png" width="10%"></a></li>
        </ol>
        </nav>
    </div>
    <h1 align="center"><video src="./Files/AUTOESCUELA.mp4" width="20%" autoplay muted loop></video></h1>
    <form action="./verificador.php" method="post" class="inises">
        <fieldset>
            <legend align="center">INICIO DE SESIÓN</legend>
        <div align="center"><hr></div>
        <table align="center">
            <tr>
                <td class="datos"><p align="center">DNI</p><input type="text" name="ID" pattern="[0-9]{8}[a-zA-z]{1}" required></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td class="datos"><p align="center">Contraseña</p><input type="password" name="passwd" required></td>
            </tr>
        </table>
        </fieldset>
        <h1 align="center"><input class="button" type="submit" value="Iniciar"><input class="button" type="reset" value="Borrar"></h1>
    </form>
    
    <?php if (isset($_SESSION["Alerta"])) {echo "<h1 align='center'>".$_SESSION["Alerta"]."</h1>";}?>
</body>
</html>
<?php session_destroy();?>