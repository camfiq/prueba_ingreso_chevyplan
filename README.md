# prueba_ingreso_chevyplan

Anotación  

La aplicación está configurada para ejecutarse en un entorno local bajo la ruta:

http://localhost/chevyplan-prueba/

Esto se gestiona mediante la constante BASE_URL, definida en el archivo cabecera.php:

define('BASE_URL', '/chevyplan-prueba/');

En caso de desplegar la aplicación en un dominio o entorno diferente (por ejemplo, un virtual host como miapp.test), es necesario ajustar esta constante a:

define('BASE_URL', '/');

Esto garantiza que las rutas internas funcionen correctamente independientemente del entorno.


Contexto:


1. Decidí hacer la prueba en PHP 8.2 que considero que era una versión estable para la prueba y de fácil despliegue en un entorno local
2. Debido a lo que se evalua no consideré necesario implementar algún tipo de framework 
3. Puse un CDN a Tailwind, solamente para que se viera agradable la prueba.
4. Se crearon dos archivos para no repetir el HTML básico 
5. Cada solución la podrás revisar en su correspondiente URL 

Solución

Punto 1: Encontrado en solucion/1-normalizacion_datos.php (Anotación en la práctica así no se mostrarían los datos de las ordenes pero por facilidad decidír mostrarlo así)

Punto 2: Encontrado en solucion/2-Debugging.php , se puede ver en el código la solución, se imprime el resultado 

Punto 3,4,5: La solución se encuentra en un mismo archivo solucion/3-manejo-api.php