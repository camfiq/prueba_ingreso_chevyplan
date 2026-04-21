<?php include 'cabecera.php'; ?>


<section class="text-center">
    <h2 class="text-6xl font-bold text-gray-900 mb-4 mt-4">Bienvenido</h2>
    <p class=" text-gray-600 text-[20px]">Prueba de ingreso Camilo Andrés Fique.</p>

    <p class="font-bold text-lg mt-10">Escoge una de las opciones del menú</p>

    <div class="flex gap-4 flex-col text-lg mt-4">
        <a href="<?= BASE_URL ?>index.php">Inicio</a>

        <a href="<?= BASE_URL ?>solucion/1-normalizacion_datos.php">Normalización</a>

        <a href="<?= BASE_URL ?>solucion/2-Debugging.php">Debugging</a>

        <a href="<?= BASE_URL ?>solucion/3-manejo-api.php">Manejo de APIs</a>
    </div>

</section>


<?php include 'footer.php'; ?>