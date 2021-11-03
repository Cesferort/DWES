<?php
// require_once "./mierda.php";
// header("Location: ./sitio.php");

/**
 * SQL QUERIES
 */
// Select
function getExpiredItems($conn)
{
    $resultItem=[];
    // Se seledccionan los items cuya fecha fin de las pujas sea 1 segundo superior o más
    // a la fecha actual
    $queryItem="SELECT * FROM item WHERE TIMESTAMPDIFF(SECOND, fechafin, now()) > 1;";

    $st=$conn -> prepare($queryItem);
    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stExecuted) 
    {
        $stResult=$st -> get_result();
        while($item=$stResult -> fetch_assoc()) 
            $resultItem[]=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItem;
}

// Insert
function addImagen($conn, $idItem, $imagen)
{
    $queryImagen="INSERT INTO imagen(id_item, imagen) VALUES(?,?);";
    
    $st=$conn -> prepare($queryImagen);
    $stPrepared=$st -> bind_param("is", $idItem, $imagen); 
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
}

// Update
function setPriceOfItem($conn, $idItem, $nuevoPrecio)
{
    // Se activa al usuario en la base de datos
    $queryItem="UPDATE item SET preciopartida = ? WHERE id = ?;";
            
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("di", $nuevoPrecio, $idItem);
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
}

// Delete y Documentación
/**
 * Elimina un item de la base de datos y toda la información relacionada encontrable en las 
 * tablas imagen y puja. Para esto recibe el identificador del mismo.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item a eliminar de la base de datos
 * @return boolean                  Valor lógico que representa si la eliminación se ha 
 *                                  completado correctamente
 */
function deleteItem($conn, $idItem)
{
    $queryItem="DELETE FROM item WHERE id=?";
   
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();

    // Cerramos statement y devolvemos resultado
    if($stPrepared && $stExecuted)
        return true;
    return false;
}



/**
 * SESIONES
 */
session_start();
$_SESSION["mierda"]="mierda";
unset($_SESSION["mierda"]);
session_unset();
session_destroy();

setcookie('mierda', "mucho texto");
if(isset($_COOKIE["mierda"]));



/**
 * FILES & DIRECTORIES
 */
if(file_exists("mierda.php"))           // Comprueba si existe
    unlink("mierda.php");               // Borra archivo
    
mkdir("mierda");                        // Crea carpeta
if(is_dir("mierda"));                   // Comprueba si es una carpeta
    rmdir("mierda");                    // Borra carpeta

// Leer fichero
if(file_exists("./mierda.txt"))
{
    $f = fopen("./mierda.txt", "r");
    while(!feof($f)) 
        $linea = fgets($f); 
    fclose($f);
}

// Escribir en fichero
if(file_exists("./mierda.txt"))
{
    $f = fopen("./mierda.txt", "w"); // 'a' para apendizar
    fwrite($f, "mucha mierda");
    fclose($f);
}

// Move uploaded file
if(isset($_FILES['fileMierda']))
{
    $file=$_FILES['fileMierda'];
    $target="./".$file['name'];
    if($file['size'] > 0)
        move_uploaded_file($_FILES['fileMierda']['tmp_name'], $target);
}



/**
 * TIME / FORMAT / DATETIME
 */
// Timezone
date_default_timezone_set('Europe/Madrid'); 

// Formatos
define("DATE_FORMATS", 
[
    "AM_PM" => "A",
    "MILLISECONDS" => "v",
    "SECONDS" => "s",
    "MINUTES" => "i",
    "HOUR_12" => "h",
    "HOUR_24" => "H",
    "DAY" => "d",
    "DAY_TEXT" => "l",
    "MONTH" => "m",
    "MONTH_TEXT" => "F",
    "YEAR" => "Y"
]);
function getFormatedDate($datestr, $format) // getFormatedDate("2/11/2021 1:2:58", DATE_FORMATS["HOUR_12"]);
{
    $date=new Datetime($datestr);
    return $date -> format($format);
}

// Diff
$dateComparar1=new DateTime(); 
$dateComparar2=new DateTime("12/4/2024 22:08:05"); // MES/DIA/AÑO
$diff=$dateComparar1 -> diff($dateComparar2); 

$diffAnios=$diff -> y;
$diffMeses=$diff -> m;
$diffDias=$diff -> d;
$diffHoras=$diff -> h;
$diffMinutos=$diff -> i;
$diffSegundos=$diff -> s;


if($dateComparar1 > $dateComparar2);



/**
 * COLECCIONES DE DATOS
 */
$arr=["mierda"=>"mas mierda"];
if(array_key_exists("mierda", $arr));   

// Crear y recorrer un diccionario
$map=
[
    "key1" => "value",
    "key2" => "value"
];
foreach($map as $key => $value)
    $output="key:".$key." value:".$value;

// array_rand y shuffle
$valores=["patata","zanahoria","cebolla","pimiento","carne","manzana","tomate"];
$indicesRand=array_rand($valores, 3);   // Te devuelve indices aleatorios
foreach($indicesRand as $indice)
    $valorRand=$valores[$indice];

shuffle($valores);                      // Mezcla una colección



/**
 * STRINGS
 */
$input="Puta mierda";
$output=strlen($input);
$output=str_replace('ñ','gn',$input);
$output=strtoupper($input);
$output=trim($input);

$inputSeccionado=explode(" ", $input);   // Genera array seccionando con un separador
implode($inputSeccionado);               // Une elementos de array

empty("");              // true
empty("texto");         // false
is_numeric($input);

join("mierda", $inputSeccionado);

function generateRandomString($size) 
{
    $result='';
    $permittedChars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length=strlen($permittedChars);
    for($i=0; $i<$size; $i++) 
    {
        $random_character=$permittedChars[mt_rand(0, $length-1)];
        $result.=$random_character;
    }
    return $result;
}

// Casting
$output=intval($input);
$output=doubleval($input);

// ASCII
ord("h");
chr(104);

// Rand
srand(time());
$arr = [];
for($i=0; $i < 5; $i++)
    $randNumber=rand(0, 100);   // Límites mínimos y máximos



/**
 * MAIL
 */
$destinatario="mierda@gmail.com";
$enlace="http://mierda";
$msg=<<<MAIL
            Hola, haznos publicidad de esta mierda:
            $enlace
            Gracias
        MAIL;

$subject  = "Publicidad de ";
$headers  = 'From: phpalas4am@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
// mail($destinatario, $subject, $msg, $headers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apuntes</title>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
        <input type="checkbox" name="chckMierda[]">
        <input type="radio" name="radMierda">
        <input type="file" name="fileMierda">
        <input type="submit" name="enviarMierda" value="ENVIAR">
    </form>
</body>
</html>