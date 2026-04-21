<?php include '../cabecera.php'; ?>

<section class="container"></section>

<pre class="italic">

Se tienen los siguientes arreglos:
Usuarios:
[
  {"id": 1, "nombre": "Juan"},
  {"id": 2, "nombre": "Ana"}
]

Órdenes:
[
  {"id": 101, "usuario_id": 1, "total": 50000},
  {"id": 102, "usuario_id": 1, "total": 30000},
  {"id": 103, "usuario_id": 2, "total": 20000}
]


Requerimientos:
•	Asociar las órdenes a cada usuario
•	Calcular el total acumulado por usuario
•	Retornar una estructura organizada con esta información



</pre>

<?php

$usuarios = [
    ["id" => 1, "nombre" => "Juan"],
    ["id" => 2, "nombre" => "Ana"]
];


$ordenes = [
    ["id" => 101, "usuario_id" => 1, "total" => 50000],
    ["id" => 102, "usuario_id" => 1, "total" => 30000],
    ["id" => 103, "usuario_id" => 2, "total" => 20000]
];

//Recorre todos los usuarios y filtra las ordenes de cada usuario
//Calcula de una vez el total acumulado por usuario aprovechando la función array_sum y array_column para
//sumar los totales de las ordenes de cada usuario
function organizarData($usuarios, $ordenes)
{

    $resultado = [];

    foreach ($usuarios as $usuario) {
        $usuarioOrdenes = array_filter($ordenes, function ($orden) use ($usuario) {
            return $orden['usuario_id'] === $usuario['id'];
        });

        $usuario = [
            "id" => $usuario['id'],
            "nombre" => $usuario['nombre'],
            "ordenes" => array_values($usuarioOrdenes),
            "total_acumulado" => array_sum(array_column($usuarioOrdenes, 'total'))
        ];

        $resultado[] = $usuario;
    }

    return $resultado;
}

$resultado = organizarData($usuarios, $ordenes);


?>

<p class="text-3xl font-bold">Solución</p>

<table class=" w-full border border-gray-300 border-collapse mt-6 text-sm" cellpadding=" 8">
    <thead class="bg-gray-100">
        <tr>
            <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
            <th class="border border-gray-300 px-4 py-2 text-left">Usuario</th>
            <th class="border border-gray-300 px-4 py-2 text-left">Total</th>
            <th class="border border-gray-300 px-4 py-2 text-left">Órdenes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $user): ?>
            <tr class="border-b  border-gray-300">
                <td><?= $user['id']; ?></td>
                <td><?= $user['nombre']; ?></td>
                <td><?= $user['total_acumulado']; ?></td>
                <td><?php
                    foreach ($user['ordenes'] as $orden) {
                        echo "Orden ID: " . $orden['id'] . " - Total: " . $orden['total'] . "<br>";
                    }
                    ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="mt-5 font-bold text-lg"> En formato JSON</p>
<pre class="bg-gray-100 p-4 rounded mt-2"><?= json_encode($resultado, JSON_PRETTY_PRINT); ?></pre>


<?php include '../footer.php'; ?>