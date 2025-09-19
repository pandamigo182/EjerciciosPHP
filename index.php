<?php
// -------------------------------
// Funciones de los ejercicios
// -------------------------------

// 1. Lista Invertida
function listaInvertida($array) {
    return array_reverse($array);
}

// 2. Suma de Números Pares
function sumaPares($array) {
    $suma = 0;
    foreach ($array as $num) {
        if ($num % 2 == 0) {
            $suma += $num;
        }
    }
    return $suma;
}

// 3. Frecuencia de Caracteres
function frecuenciaCaracteres($cadena) {
    $resultado = [];
    $chars = str_split($cadena); // divide en caracteres
    foreach ($chars as $char) {
        if (isset($resultado[$char])) {
            $resultado[$char]++;
        } else {
            $resultado[$char] = 1;
        }
    }
    return $resultado;
}

// 4. Pirámide de Asteriscos
function imprimirPiramide($filas) {
    $salida = "";
    for ($i = 1; $i <= $filas; $i++) {
        // espacios
        for ($j = $i; $j < $filas; $j++) {
            $salida .= "&nbsp;";
        }
        // asteriscos
        for ($k = 1; $k <= (2 * $i - 1); $k++) {
            $salida .= "*";
        }
        $salida .= "<br>";
    }
    return $salida;
}

// -------------------------------
// Manejo de formularios
// -------------------------------
$invertidaResult = '';
$paresResult = '';
$frecuenciaResult = '';
$piramideResult = '';
$openModal = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['lista'])) {
        $array = explode(",", $_POST['lista']);
        $invertidaResult = implode(", ", listaInvertida($array));
        $openModal = 'invertidaModal';
    }

    if (isset($_POST['numeros'])) {
        $array = explode(",", $_POST['numeros']);
        $paresResult = sumaPares($array);
        $openModal = 'paresModal';
    }

    if (isset($_POST['cadena'])) {
        $arrayFrecuencia = frecuenciaCaracteres($_POST['cadena']);
        foreach ($arrayFrecuencia as $car => $freq) {
            $frecuenciaResult .= "'$car' => $freq <br>";
        }
        $openModal = 'frecuenciaModal';
    }

    if (isset($_POST['filas'])) {
        $piramideResult = imprimirPiramide($_POST['filas']);
        $openModal = 'piramideModal';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Módulo 4 - Actividad 3 – Ejercicios de lógica en PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="./assets/css/styles.css" rel="stylesheet">
</head>
<body>
<header>
  <div class="container py-5">
    <img src="./assets/img/logo.png" alt="Logo Kodigo">
    <h1 class="text-center mb-4">Módulo 4 - Actividad 3 – Ejercicios de lógica con estructuras de datos en PHP <i class="fa-brands fa-php"></i></h1>
</header>

  <!-- Botones -->
  <div class="button d-flex flex-wrap gap-3 justify-content-center">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invertidaModal"><i class="fa-solid fa-arrow-rotate-left"></i> Lista Invertida</button>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paresModal"><i class="fa-solid fa-plus"></i>Suma de Números Pares</button>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#frecuenciaModal"><i class="fa-solid fa-font"></i>Frecuencia de Caracteres</button>
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#piramideModal"><i class="fa-solid fa-triangle-exclamation"></i>Pirámide de Asteriscos</button>
  </div>

  <!-- Modal Lista Invertida -->
  <div class="modal fade" id="invertidaModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <h5>Problema de Lista Invertida</h5>
        <form method="post">
          <label>Ingresa números separados por coma:</label>
          <input type="text" name="lista" class="form-control" required>
          <button type="submit" class="btn btn-primary mt-3"> <i class="fa-solid fa-paper-plane"></i>Procesar</button>
        </form>
        <?php if ($invertidaResult) echo "<div class='mt-3 alert alert-info'>Resultado: $invertidaResult</div>"; ?>
      </div>
    </div>
  </div>

  <!-- Modal Suma Pares -->
  <div class="modal fade" id="paresModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <h5>Problema de Suma de Números Pares</h5>
        <form method="post">
          <label>Ingresa números separados por coma:</label>
          <input type="text" name="numeros" class="form-control" required>
          <button type="submit" class="btn btn-success mt-3"> <i class="fa-solid fa-paper-plane"></i>Procesar</button>
        </form>
        <?php if ($paresResult !== '') echo "<div class='mt-3 alert alert-info'>Resultado: $paresResult</div>"; ?>
      </div>
    </div>
  </div>

  <!-- Modal Frecuencia -->
  <div class="modal fade" id="frecuenciaModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <h5>Problema de Frecuencia de Caracteres</h5>
        <form method="post">
          <label>Ingresa una cadena de texto:</label>
          <input type="text" name="cadena" class="form-control" required>
          <button type="submit" class="btn btn-warning mt-3"> <i class="fa-solid fa-paper-plane"></i>Procesar</button>
        </form>
        <?php if ($frecuenciaResult) echo "<div class='mt-3 alert alert-info'>Resultado:<br>$frecuenciaResult</div>"; ?>
      </div>
    </div>
  </div>

  <!-- Modal Pirámide -->
  <div class="modal fade" id="piramideModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content p-3">
        <h5>Problema de Pirámide de Asteriscos</h5>
        <form method="post">
          <label>Ingresa número de filas:</label>
          <input type="number" name="filas" class="form-control" required>
          <button type="submit" class="btn btn-danger mt-3"> <i class="fa-solid fa-paper-plane"></i>Procesar</button>
        </form>
        <?php if ($piramideResult) echo "<div class='mt-3 alert alert-info'><pre>$piramideResult</pre></div>"; ?>
      </div>
    </div>
  </div>

</div>

<footer class="text-center bg-dark text-white py-3 mt-auto">
  <i class="fa-solid fa-user"></i> Edwin Efrain Juárez Mezquita, <i class="fa-solid fa-chalkboard"></i> FullStack JR Grupo 31 - 2025
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Reabrir modal después de submit
<?php if ($openModal): ?>
  var modal = new bootstrap.Modal(document.getElementById('<?php echo $openModal; ?>'));
  modal.show();
<?php endif; ?>
</script>
</body>
</html>
