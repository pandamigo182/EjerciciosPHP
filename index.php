<?php
// index.php
// Módulo 4 - Actividad 2 – Ejercicios de Lógica con Estructuras de Control y Funciones en PHP
// Autor: Edwin Efrain Juárez Mezquita, FullStack JR Grupo 31 - 2025

// ===================== Procesamiento de formularios ======================
$fibResult = '';$primeResult = '';$palResult = '';$openModal = ''; // guardará el id del modal que debe abrirse después del POST

// Funcion: generarFibonacci
// Recibe n (int) y devuelve un array con los primeros n términos de la serie Fibonacci.
function generarFibonacci(int $n): array {
    // Casos base
    if ($n <= 0) return [];
    if ($n === 1) return [0];
    $serie = [0, 1];
    // Generamos los términos restantes de forma iterativa para eficiencia
    for ($i = 2; $i < $n; $i++) {
        $serie[] = $serie[$i - 1] + $serie[$i - 2];
    }
    return array_slice($serie, 0, $n);
}

// Funcion: esPrimo
// Determina si un número entero es primo. Devuelve true/false.
function esPrimo(int $num): bool {
    if ($num <= 1) return false; // 0 y 1 no son primos
    if ($num <= 3) return true;  // 2 y 3 son primos
    if ($num % 2 === 0) return false; // pares >2 no son primos
    // Solo revisar impares hasta la raíz cuadrada para mejor rendimiento
    $r = (int) sqrt($num);
    for ($i = 3; $i <= $r; $i += 2) {
        if ($num % $i === 0) return false;
    }
    return true;
}

// Funcion: esPalindromo
// Normaliza la cadena (quita espacios y caracteres no alfanuméricos, pasa a minúsculas)
// y comprueba si se lee igual al derecho y al revés.
function esPalindromo(string $s): bool {
    // Convertir a minúsculas
    $s = mb_strtolower($s, 'UTF-8');
    // Eliminar todo lo que no sea letra o número (acentos se conservan hasta donde PHP lo permita)
    // Usamos preg_replace con \p{L}\p{N} para soportar caracteres Unicode (letras y números)
    $s = preg_replace('/[^\p{L}\p{N}]/u', '', $s);
    if ($s === false) return false; // fallo regex
    // Comparar con la cadena invertida
    $reversed = mb_strrev($s);
    return $s === $reversed;
}

// Helper: invertir string multibyte (PHP no tiene mb_strrev por defecto)
function mb_strrev(string $str): string {
    $r = '';
    for ($i = mb_strlen($str, 'UTF-8') - 1; $i >= 0; $i--) {
        $r .= mb_substr($str, $i, 1, 'UTF-8');
    }
    return  $r;
}

// Procesamiento al enviar cualquier formulario
if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fibonacci
    if (isset( $_POST['fib_submit'])) {
         $n = intval( $_POST['fib_n'] ?? 0);
        if ( $n <= 0) {
             $fibResult = 'Introduce un número entero mayor que 0.';
        } else {
             $arr = generarFibonacci( $n);
            // Convertir a cadena para mostrar
             $fibResult = implode(', ',  $arr);
        }
         $openModal = 'fibModal';
    }

    // Primo
    if (isset( $_POST['prime_submit'])) {
         $valor = trim( $_POST['prime_n'] ?? '');
        if ( $valor === '' || !is_numeric( $valor)) {
             $primeResult = 'Introduce un número válido (entero).';
        } else {
             $num = intval( $valor);
            if (esPrimo( $num)) {
                 $primeResult = "El número { $num} es primo.";
            } else {
                 $primeResult = "El número { $num} NO es primo.";
            }
        }
         $openModal = 'primeModal';
    }

    // Palíndromo
    if (isset( $_POST['pal_submit'])) {
         $texto = strval( $_POST['pal_text'] ?? '');
        if (trim( $texto) === '') {
             $palResult = 'Introduce una cadena de texto no vacía.';
        } else {
            if (esPalindromo( $texto)) {
                 $palResult = "La cadena \"" . htmlspecialchars( $texto) . "\" es un palíndromo.";
            } else {
                 $palResult = "La cadena \"" . htmlspecialchars( $texto) . "\" NO es un palíndromo.";
            }
        }
         $openModal = 'palModal';
    }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Módulo 4 - Actividad 2 – Ejercicios de Lógica en PHP</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/styles.css">
  
</head>
<body>
 <header class="py-4">
  <div class="container text-center">
    <img src="./assets/img/logo.png" alt="Logo de la empresa" style="max-height: 80px; margin-bottom: 15px;">
    <h1>Módulo 4 - Actividad 2 – Ejercicios de Lógica con Estructuras de Control y Funciones en PHP</h1>
    <small>Interfaz sencilla con 3 botones desplegables que abren modales para cada ejercicio</small>
  </div>
</header>


  <main class="container mt-4 flex: 1">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <h5>Serie Fibonacci</h5>
          <p>Genera los primeros <strong>n</strong> términos de la serie Fibonacci (0,1,1,2,3...)</p>

          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownFib" data-bs-toggle="dropdown" aria-expanded="false">
              Abrir ejercicio
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownFib">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#fibModal">Abrir modal</a></li>
            </ul>
          </div>

        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3">
          <h5>Números Primos</h5>
          <p>Determina si un número es primo (solo divisible por 1 y por sí mismo)</p>
          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownPrime" data-bs-toggle="dropdown" aria-expanded="false">
              Abrir ejercicio
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownPrime">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#primeModal">Abrir modal</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3">
          <h5>Palíndromos</h5>
          <p>Comprueba si una cadena es palíndromo (ignora espacios y signos)</p>
          <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownPal" data-bs-toggle="dropdown" aria-expanded="false">
              Abrir ejercicio
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownPal">
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#palModal">Abrir modal</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== Modales ====== -->

    <!-- Fibonacci Modal -->
    <div class="modal fade" id="fibModal" tabindex="-1" aria-labelledby="fibModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fibModalLabel">Problema: Serie Fibonacci</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>Enunciado: Escribe una función <code>generarFibonacci(n)</code> que reciba <strong>n</strong> y genere los primeros n términos de la serie Fibonacci (0, 1, ...).</p>
            <form method="post" action="">
              <div class="mb-3">
                <label for="fib_n" class="form-label">Número de términos (n)</label>
                <input type="number" class="form-control" id="fib_n" name="fib_n" min="1" value="<?php echo isset($_POST['fib_n']) ? htmlspecialchars(
                 $_POST['fib_n']) : '10'; ?>">
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="fib_submit">Generar</button>
              </div>
            </form>

            <?php if ( $fibResult !== ''): ?>
              <hr>
              <h6>Resultado:</h6>
              <p><?php echo htmlspecialchars( $fibResult); ?></p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

    <!-- Primo Modal -->
    <div class="modal fade" id="primeModal" tabindex="-1" aria-labelledby="primeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="primeModalLabel">Problema: Números Primos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>Enunciado: Implementa <code>esPrimo(num)</code> que indique si <strong>num</strong> es primo.</p>
            <form method="post" action="">
              <div class="mb-3">
                <label for="prime_n" class="form-label">Número (entero)</label>
                <input type="number" class="form-control" id="prime_n" name="prime_n" value="<?php echo isset(
                 $_POST['prime_n']) ? htmlspecialchars( $_POST['prime_n']) : '17'; ?>">
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" name="prime_submit">Comprobar</button>
              </div>
            </form>

            <?php if ( $primeResult !== ''): ?>
              <hr>
              <h6>Resultado:</h6>
              <p><?php echo htmlspecialchars( $primeResult); ?></p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

    <!-- Palíndromo Modal -->
    <div class="modal fade" id="palModal" tabindex="-1" aria-labelledby="palModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="palModalLabel">Problema: Palíndromos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>Enunciado: Implementa <code>esPalindromo(texto)</code> que determine si la cadena es palíndromo. Debe ignorar espacios y signos.</p>
            <form method="post" action="">
              <div class="mb-3">
                <label for="pal_text" class="form-label">Texto</label>
                <input type="text" class="form-control" id="pal_text" name="pal_text" value="<?php echo isset(
                 $_POST['pal_text']) ? htmlspecialchars( $_POST['pal_text']) : 'Anita lava la tina'; ?>">
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-warning" name="pal_submit">Comprobar</button>
              </div>
            </form>

            <?php if ( $palResult !== ''): ?>
              <hr>
              <h6>Resultado:</h6>
              <p><?php echo htmlspecialchars( $palResult); ?></p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>

  </main>

  <footer class="py-3 mt-5 text-center margin-top: auto">
    <div class="container">
      <small>Edwin Efrain Juárez Mezquita, FullStack JR Grupo 31 - 2025</small>
    </div>
  </footer>

  <!-- Bootstrap JS (bundle incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script para reabrir el modal que corresponde después de un POST -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (!empty( $openModal)): ?>
        var modalEl = document.getElementById('<?php echo  $openModal; ?>');
        if (modalEl) {
          var m = new bootstrap.Modal(modalEl);
          m.show();
        }
      <?php endif; ?>
    });
  </script>

</body>
</html>
