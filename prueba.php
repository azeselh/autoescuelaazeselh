<?php require_once "login.php";
$conexion = mysqli_connect($host, $user, $pass, $database);

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

// La consulta SQL para obtener las preguntas y opciones
$consulta = "SELECT IDpregunta, pregunta, RespuestaCorrecta, Respuesta1,Respuesta2,Respuesta3
             FROM preguntas
             ORDER BY IDpregunta";

$resultado = $conexion->query($consulta);
$preguntas = [];
while ($fila = $resultado->fetch_assoc()) {
    // Asumiendo que cada pregunta puede tener múltiples filas (una por opción),
    // agrupamos por ID de pregunta
    if (!isset($preguntas[$fila['IDpregunta']])) {
        $preguntas[$fila['IDpregunta']] = [
            'id' => $fila['IDpregunta'],
            'texto' => $fila['pregunta'],
            'opciones' => [],
            'correcta' => $fila['RespuestaCorrecta']
        ];
    }
    if (!empty($fila['Respuesta1'])) $preguntas[$fila['IDpregunta']]['opciones'][] = $fila['Respuesta1'];
    if (!empty($fila['Respuesta2'])) $preguntas[$fila['IDpregunta']]['opciones'][] = $fila['Respuesta2'];
    if (!empty($fila['Respuesta3'])) $preguntas[$fila['IDpregunta']]['opciones'][] = $fila['Respuesta3'];
}

// Como usamos el ID como clave, los valores extraen las preguntas en sí mismas
$preguntas = array_values($preguntas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Tus estilos y otros elementos de <head> aquí -->
</head>
<body>

<form id="testForm">
    <?php foreach ($preguntas as $pregunta): ?>
        <div>
            <p><?= $pregunta['texto']; ?></p>
            <?php foreach ($pregunta['opciones'] as $opcion): ?>
                echo "<h2 align='center'><img src='data:image/jpg; base64,", base64_encode($filas2["Imagen"]), "'width='50%'></h2><br><br>";
                <label><input type="radio" name="respuesta_<?= $pregunta['id']; ?>" value="<?= $opcion; ?>"> <?= $opcion; ?></label><br>
            <?php endforeach; ?>
            <span class='correcta' style='display:none;'><?= $pregunta['correcta']; ?></span>
        </div>
    <?php endforeach; ?>
    <button type="button" onclick="corregirTest()">Enviar respuestas</button>
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
        }
    });

    alert("Tu puntuación es: " + score + "/" + preguntas.length);
}
</script>

</body>
</html>
