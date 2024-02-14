<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Proyecto</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="./imagenes/logo.jpeg"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a href="./puntuaciones.php"><img src="./Files/perfil.png" width="5%"/>
        
        <?php
        generateDropdownMenu("MECANICA", "MECANICA");
        generateDropdownMenu("CIRCULACION", "CIRCULACION");
        generateDropdownMenu("SENALES", "SENALES");
        generateDropdownMenu("TRAFICO", "TRAFICO");
        ?>
    </div>
</nav>
<?php

function generateDropdownMenu($temaNumero, $temaNombre) {
    echo <<<HTML
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <form action="./temario.php" method="post">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        $temaNombre
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <input type="hidden" name="tema" value="$temaNumero">
                            <input type="submit" class="dropdown-item" value="Tests">
                        </li>
                    </ul>
                </li>
            </ul>
        </form>
    </div>
HTML;
}
?>
</body>
</html>

<?php require_once "login.php";
$conexion = mysqli_connect($host, $user, $pass, $database);


if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
if (isset($_POST["tema"])) {
    $tema = $_POST["tema"];

$consulta = "SELECT IDpregunta, Imagen, pregunta, RespuestaCorrecta, Respuesta1,Respuesta2,Respuesta3
             FROM preguntas,tests where tests.id=preguntas.idtest
             and tema='$tema'
             ORDER BY IDpregunta";

$resultado = $conexion->query($consulta);
$preguntas = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $id = $fila['IDpregunta'];

    if (!isset($preguntas[$id])) {
        // 0: id, 1: imagen, 2: texto, 3: opciones, 4: correcta
        $preguntas[$id] = [$fila['IDpregunta'], $fila['Imagen'], $fila['pregunta'], [], $fila['RespuestaCorrecta']];
    }

    if (!empty($fila['Respuesta1'])) $preguntas[$id][3][] = $fila['Respuesta1'];
    if (!empty($fila['Respuesta2'])) $preguntas[$id][3][] = $fila['Respuesta2'];
    if (!empty($fila['Respuesta3'])) $preguntas[$id][3][] = $fila['Respuesta3'];
}
if (isset($preguntas)) {
    $preguntas = array_values($preguntas);

}
?>
<form id="testForm">

    <?php foreach ($preguntas as $pregunta): ?>
        <div class="row">
        <h1 align="center" text>Pregunta <?= $pregunta[0]; ?></h1>
        <hr>
        <div class="container izq">
            <h3 text><?= $pregunta[2]; ?></h3>
                <p class="respuestas">
                <?php foreach ($pregunta[3] as $opcion): ?>
                    <label><input type="radio" class="" name="respuesta_<?= $pregunta[0]; ?>" value="<?= $opcion; ?>"> <span><?= $opcion; ?></span></label><br>
                <?php endforeach; ?>
                </p>
                <span class='correcta' hidden><?= $pregunta[4]; ?></span>
            </div>
            <div class="container der">
                <?php 
                    if (isset($pregunta[1])) {
                        echo "<img src='data:image/jpg; base64,", base64_encode($pregunta[1]), "' class='imgtest'>";
                    }
                ?>
            </div>
        </div>
        <br>
        <br>
    <?php endforeach; ?>
    <input type="hidden" id="score" name="score">
    <input type="hidden" id="cantidad" name="cantidad">
    <input type="hidden" id="id" name="id" value="<?php echo $_SESSION['id']; ?>">
    <input type="hidden" id="tema" name="tema" value="<?php echo $tema; ?>">
    <h1 align="center"><button id="corregir" type="button" class="button" onclick="corregirTest()">Corregir</button><input id="guardar" type="submit" class="button" value="Guardar" hidden></h1>
</form>
<script>
function corregirTest() {
    var preguntas = document.querySelectorAll("#testForm > div");
    var score = 0;

    preguntas.forEach(function(pregunta) {
        var respuestaCorrecta = pregunta.querySelector(".correcta").textContent;
        var opciones = pregunta.querySelectorAll("input[type='radio']");
        var respuestaUsuario = '';

        opciones.forEach(function(opcion) {
            if (opcion.checked) {
                respuestaUsuario = opcion.value;
            }
        });

        if (respuestaUsuario === respuestaCorrecta) {
            score++;
            pregunta.style.color = 'green';
        } else {
            pregunta.style.color = 'red';
            var correcta = pregunta.querySelector(".correcta");
            correcta.hidden = false;
        }

    });
    document.getElementById("score").value = score;
    document.getElementById("cantidad").value = preguntas.length;
    document.getElementById("corregir").hidden = true;
    document.getElementById("guardar").hidden = false;
    document.getElementById("testForm").action="./corrector.php";
    document.getElementById("testForm").method="POST";

}
</script>
<?php }else{echo "<br><br><br><br><h1 align='center'>Bienvenido ".$_SESSION["nombre"]."</h1>";} ?>