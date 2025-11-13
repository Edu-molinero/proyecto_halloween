<?php
// Para trabajar con fechas se utiliza la siguiente función
echo date("Y-m-d");
echo "<br>";
/* Distintas formas de representar fechas
d → Día (01–31)

m → Mes en número (01–12)

Y → Año completo (2025)

y → Año corto (25)

H → Hora (00–23)

h → Hora (01–12)

i → Minutos (00–59)

s → Segundos (00–59)

l → Día de la semana en texto (Monday, Tuesday, etc.)

F → Mes en texto (January, February, etc.)
*/
//Tambien se pueden representar fechas con el timestamp (fecha en milisegundos?)
$timestamp = strtotime("2000-01-01");
echo date("Y-M-d H-i-s", $timestamp);
echo "<br>";

//Funcion rand, genera numeros aleatorios
echo rand();
echo "<br>";

//tambien funcionan con limites superiores e inferiores
echo rand(0, 10);
echo "<br>";
//Funcion para mostrar directorio actual
echo getcwd();
echo "<br>";

$archivo = "ejemplo.txt";

// Abrir el archivo en modo escritura ("w" sobrescribe, "a" agrega al final, r solo lo lee)
$fichero = fopen($archivo, "w");

$texto = "prueba de lectura";

// Escribir en el archivo
fwrite($fichero, $texto);
//Leer archivos, con nombre archivo y tamaño, que se calcula con la funcion filesize

// Cerrar el archivo
fclose($fichero);

// Leer archivos
$fichero2 = fopen("ejemplo.txt", 'r');
$pruba = fread($fichero2, filesize("ejemplo.txt"));
fclose($fichero2);
echo $pruba;
echo "<br>";


echo "Se ha escrito en el archivo correctamente.";
echo "<br>";

//Funciones o metodos, trozos de codigo que se "invocan", pueden o no necesitar variables y pueden o no devolver variables
function saludar($nombre){
    echo "Hola ". $nombre;
    echo "<br>";
}
saludar("Alejandro");
function calcularNumeroPar($numero){
    if($numero%2 == 0){
        $mensaje = "es par";
    }
    else{
        $mensaje = "no es par";
    }
    return $mensaje;
}
$resultado = calcularNumeroPar(7);
echo $resultado;
?>

