<!DOCTYPE html>
<html lang="en">  
<?php
require_once "../gestores/libmenu.php";
session_start();
// Comprobamos que se ha iniciado sesión. En caso contrario redirigimos a la página de entrada
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

// Comprobamos que se ha recibido un tipo de plato. En caso contrario redirigidmos al usuario a
// la página para realizar pedidos. Se añade una variable que representa la ocurrencia de este suceso. 
// Este fallo podría ocurrir en caso de que el usuario inicie sesión y posteriormente intenta acceder 
// manualmente a la dirección de esta página. Porque la estupidez humana no tiene límites...y por
// ciberseguridad claro, por eso también
$tipo="";
if(isset($_GET["tipo"]))
    $tipo=$_GET["tipo"];
else
    header('Location: ../pedido.php?errTipo=true');

// Se comprueba si había un plato de mismo tipo ya seleccionado anteriormente
$cambiarPlato=false;
$platosElegidos=$_SESSION["platosElegidos"];
if($platosElegidos[$tipo]!="none")
{
    // Vamos a reemplazar un plato del mismo tipo
    $cambiarPlato=true;
    $oldPlato=$platosElegidos[$tipo];
}

//Recuperamos todos los platos del tipo escogido
$platos=damePlatos($tipo);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Plato</title>
</head>
<body>
    <?php
    // Mostramos mensaje en caso de que estemos cambiando un plato de mismo tipo anteriormente elegido
    if($cambiarPlato==true)
        echo "<p>Va a cambiar su elección ".$oldPlato." por:</p>";
    ?>
    <form action="./pedido.php" method="post">
        <select name="selectPlatos">
            <?php
            foreach($platos as $nomPlato => $precioPlato)
            {
                // Seleccionamos por defecto un plato en caso de que este ocurriendo un reemplazo y la
                // opción sea igual al plato anteriormente escogido
                if($cambiarPlato==true&&$nomPlato==$oldPlato)
                    echo "<option value='$nomPlato' selected>$nomPlato - $precioPlato €</option>";
                else
                    echo "<option value='$nomPlato'>$nomPlato - $precioPlato €</option>";
            }
            ?>
        </select>
        <!-- Utilizaremos este input oculto para conocer el tipo de plato que se ha elegido -->
        <input type="hidden" name="tipo" value="<?php echo $tipo;?>">
        <input type="submit" name="elegirPlato" value="<?php echo 'ELEGIR '.$tipo;?>">
    </form>
</body>
</html>