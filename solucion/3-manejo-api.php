<?php include '../cabecera.php'; ?>

<section class="container"></section>

<pre class="italic">

Plantea una función que simule el consumo de un API:
•	Manejar errores (por ejemplo: fallo en la respuesta)
•	Retornar un resultado controlado sin romper la aplicación


________________________________________
4. Criterio técnico
•	¿Cómo evitarías hacer múltiples llamadas a un mismo API cuando la información no cambia frecuentemente?
•	¿Dónde implementarías esta solución y por qué?


________________________________________
5. Adaptación a cambios
•	Si los datos del API empiezan a llegar incompletos o con campos adicionales, ¿cómo ajustarías tu solución?
________________________________________


</pre>

<?php

$urlEndPoint = "https://jsonplaceholder.typicode.com/posts/1";


//Generé una función para envío de headers , acá iría token de autenticación o cualquier otro header si se necesitara
function generarHeaders()
{
    return [
        "http" => [
            "method" => "GET",
            "header" => implode("\r\n", [
                "Accept: application/json",
                "Content-Type: application/json"
            ]),
            "timeout" => 5
        ]
    ];
}

/*
Se realiza la petición y se blinda con los siguientes tipos de validaciones
- Validación de errores en la respuesta (si file_get_contents devuelve false, se captura el error con error_get_last())
- Validar código de estado HTTP (si no es 2xx, se considera un error)
- Validación de errores al decodificar el JSON (si json_decode devuelve un error, se captura con json_last_error() y json_last_error_msg())
*/

function realizarPeticion($urlEndPoint)
{

    $contexto = stream_context_create(generarHeaders());


    $respuesta = file_get_contents($urlEndPoint, false, $contexto);

    if ($respuesta === false) {
        $error = error_get_last();

        return [
            'success' => false,
            'error' => $error['message'] ?? 'Error desconocido'
        ];
    }

    $statusCode = null;

    if (isset($http_response_header[0])) {
        preg_match('{HTTP/\S*\s(\d{3})}', $http_response_header[0], $match);
        $statusCode = $match[1] ?? null;
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        return [
            'success' => false,
            'error' => 'Respuesta HTTP no válida',
            'status_code' => $statusCode
        ];
    }

    $datos = json_decode($respuesta, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return  [
            'success' => false,
            'error' => 'Error al decodificar JSON: ' . json_last_error_msg()
        ];
    }

    return [
        'success' => true,
        'data' => $datos
    ];
}



?>

<p class="text-3xl font-bold">Solución</p>


<p class="text-lg mt-4 text-red-500 font-bold">Por lo general para esta solución yo suelo utilizar CURL, pero suponiendo que
    se revisará la prueba en un entorno limpio sin extensiones activas, di solución al punto con file_get_contents:</p>

<p class="text-lg mt-4 text-red-500 font-bold">Usé JSON Placeholder como API de prueba</p>

<p class="text-2xl font-bold mt-4">3. Manejo de API (práctico)</p>

<div class="bg-gray-100 p-8 rounded">
    <p class="text-md mt-4">
        Para manejar la petición al API,
        Generé dos funciones:<br><br>
        <strong>generarHeaders()</strong>: Se encarga de generar los headers necesarios para la petición
        (<i>En el ejemplo no sería necesario pero simulé un entorno real </i>)
        <br>
        <strong>realizarPeticion($urlEndPoint): Se encarga de realizar la petición al API y manejar los posibles errores</strong>



    </p>

    <p class="text-md mt-8">
        Para blindar la función <strong>realizarPeticion()</strong>, implementé las siguientes validaciones:<br><br>

    <ul class="list-disc list-inside space-y-2">
        <li>Validación de errores en la respuesta (si file_get_contents devuelve false, se captura el error con error_get_last())</li>
        <li>Validar código de estado HTTP (si no es 2xx, se considera un error)</li>
        <li>Validación de errores al decodificar el JSON (si json_decode devuelve un error, se captura con json_last_error() y json_last_error_msg())</li>
    </ul>

    </p>

    <p class="text-md mt-8">
        Como respuesta controlada y que no se rompe la aplicación, la función retorna un array con una clave
        'success' que indica si la petición fue exitosa o no, y en caso de error,
        una clave 'error' con el mensaje del error.
        En caso de éxito, retorna los datos decodificados del JSON en la clave 'data'.<br><br>

        se vería de la forma: <br><br>
    <pre>
                 [
                    'success' => true,
                    'data' => [....]
                ]
            </pre>
    </p>

    <p class="text-md mt-8">En el código se puede ver cómo se usa la variable success para decidir si mostrar la data
        o mostrar el código de error
    </p>
</div>

<?php
$datos = realizarPeticion($urlEndPoint);

if (!$datos['success']) {
    echo "<p class='text-red-500 font-bold'>Error: " . $datos['error'] . "</p>";
    if (isset($datos['status_code'])) {
        echo "<p class='text-red-500 font-bold'>Código de estado HTTP: " . $datos['status_code'] . "</p>";
    }
    return;
}

if (is_string($datos)) {
    echo "<p class='text-red-500 font-bold'>" . $datos . "</p>";
} else {
    echo "<p class='text-green-500 font-bold'>Datos obtenidos correctamente del API.</p>";
}
echo "<pre class='bg-gray-100 p-4 rounded'>" . print_r($datos, true) . "</pre>";
?>

<p class="text-2xl font-bold mt-10">4. Criterio técnico</p>

<div class="bg-gray-100 p-8 rounded">
    <p class="text-lg mt-4">
        <strong> ¿Cómo evitarías hacer múltiples llamadas a un mismo API cuando la información no cambia frecuentemente?</strong>
    </p>

    <p class="text-md mt-8">
        La forma en la que lo manejaría sería utilizando un sistema de caché donde se almacene la información temporalmente.
        Esto permite validar si los datos que ya tenemos siguen siendo válidos o si es necesario hacer una nueva llamada al API.
        <br><br>
        Dependiendo del sistema, la caché podría manejarse en memoria, en archivos o incluso en una base de datos como redis.
        Además, agregaría un tiempo de expiración para evitar trabajar con información desactualizada.
        <br><br>
        En caso de que la información cambie o se realice alguna acción que la afecte, simplemente se invalida la caché y se consulta nuevamente el API.
    </p>


    <p class="text-lg mt-10">
        <strong> ¿Dónde implementarías esta solución y por qué?</strong>
    </p>

    <p class="text-md mt-8">
        Yo escogería una solución de Redis, debido a que si el volumen de datos es muy grande ,
        la caché en memoria o en archivos podría no ser suficiente o eficiente y crear un colapso peor que llamar a la misma API.
        <br><br>
        Al usar redis se podrían manejar grandes cantidades de datos, que a su vez pueden estar autoalojados en el servidor ( si no es externo)
        y así sería considerablemente más rápida la respuesta.

        <br><br>
        Identificaría cuáles datos son los que requieren una respuesta rápida, y a su vez consuman muchos llamados de API,
        para implementar este sistema de caché, y así optimizar el rendimiento de la aplicación.

        <br><br>
        No considero que todas las peticiones sean candidatas a este sistema, habría un análisis de cuáles requerirían
        esta solución
    </p>

</div>

<p class="text-2xl font-bold mt-10">5. Adaptación a cambios</p>

<div class="bg-gray-100 p-8 rounded">
    <p class="text-lg mt-4">
        <strong> Si los datos del API empiezan a llegar incompletos o con campos adicionales, ¿cómo ajustarías tu solución?</strong>
    </p>

    <p class="text-md mt-8">
        Yo tendría un archivo tipo "interface" que viene siendo la estructura de lo que se conoce responde la API,
        pondría una pequeña validación para verificar que los campos que necesito estén presentes.
        <br><br>En caso de que lleguen campos adicionales, simplemente los ignoraría ( más si dejaría registro de que existen campos extra).

        <br><br>
        En caso de que los datos lleguen incompletos, dependiendo de la criticidad de la información,
        podría implementar una lógica para manejar esos casos, como por ejemplo: enviar una notificación al administrador del sitio,
        registrarlo en el log de errores.
        <br><br>

        De igual forma gracias a esta interface si no se obtiene algún campo requerido u obligatorio,
        no se podría entregar la respuesta, más no se rompería el sitio, y se requeriría la corrección de la interfaz
        y analizar cómo se va a proceder ya sea con los campos extra o aún más critico siendo la falta de campos.

    </p>



</div>


<?php include '../footer.php'; ?>
