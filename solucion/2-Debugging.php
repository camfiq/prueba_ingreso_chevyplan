<?php include '../cabecera.php'; ?>

<section class="container"></section>

<pre class="italic">

Analiza y corrige la siguiente función:
function obtenerTotales($ordenes) {
    $total = 0;

    for ($i = 0; $i <= count($ordenes); $i++) {
        $total += $ordenes[$i]['total'];
    }

    return $total;
}
•	Identificar el error
•	Corregirlo
•	Explicar brevemente qué ocurría


</pre>

<?php

/**
function obtenerTotales($ordenes) {
    $total = 0;

    for ($i = 0; $i <= count($ordenes); $i++) {
        $total += $ordenes[$i]['total'];
    }

    return $total;
}
 */

$ordenes = [
    ["id" => 101, "usuario_id" => 1, "total" => 50000],
    ["id" => 102, "usuario_id" => 1, "total" => 30000],
    ["id" => 103, "usuario_id" => 2, "total" => 20000]
];

function obtenerTotales($ordenes)
{
    $total = 0;

    for ($i = 0; $i < count($ordenes); $i++) {
        $total += $ordenes[$i]['total'];
    }

    return $total;
}



?>

<p class="text-3xl font-bold">Solución</p>

<p class="text-lg mt-4">El error que sucedía es que como todos los arrays inician en cero, el bucle for estaba intentando
    acceder a un índice que no existía en la última iteración.</p>

<p class="text-lg mt-3">Al cambiar la condición del bucle a <i>$i < count($ordenes)</i> se asegura que el bucle solo itere hasta
            el último índice válido del array.</p>

<p class="mt-3 font-bold text-lg"> Resultado: <?= obtenerTotales($ordenes); ?></p>


<?php include '../footer.php'; ?>