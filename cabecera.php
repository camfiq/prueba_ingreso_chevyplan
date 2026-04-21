<?php
define('BASE_URL', '/chevyplan-prueba/'); // en localhost
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de ingreso ChevyPlan</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <base href="<?php echo BASE_URL; ?>">
</head>

<body class="bg-gray-50">


    <header class="bg-white shadow">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">ChevyPlan</h1>
            <div class="flex gap-4 text-lg">
                <a href="<?= BASE_URL ?>index.php">Inicio</a>

                <a href="<?= BASE_URL ?>solucion/1-normalizacion_datos.php">Normalización</a>

                <a href="<?= BASE_URL ?>solucion/2-Debugging.php">Debugging</a>

                <a href="<?= BASE_URL ?>solucion/3-manejo-api.php">Manejo de APIs</a>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">