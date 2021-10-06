<!DOCTYPE html>
<html lang="en">  
<?php
require_once "../gestores/libmenu.php";
session_start();
// Comprobamos que se ha iniciado sesión. En caso contrario redirigimos a la página de entrada
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

// Recuperamos los platos elegidos por el usuario
$platosElegidos=$_SESSION["platosElegidos"];
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin Pedido</title>
</head>
<body>
    <h2>SU ELECCIÓN:</h2>
    <?php
    $precioTotal=0;
    $txt="";
    foreach($_SESSION["platosElegidos"] as $tipo => $plato)
    {
        // Comprobamos que este tipo de plato tiene un plato elegido
        if($plato!="none")
        {
            // Formateamos correctamente el resultado
            $txtLi="";
            if($tipo == "Primero")
                $txtLi="Primer plato: ";
            elseif($tipo == "Segundo")
                $txtLi="Segundo plato: ";
            else 
                $txtLi=$tipo.": ";

            //Recuperamos el precio del plato y actualizamos el precio total de los platos elegidos
            $precioPlato=damePrecio($plato);
            $precioTotal+=floatval($precioPlato);

            // Añadimos línea de datos al desglose final
            $txt.="<p>$txtLi $plato ${precioPlato}€</p>";
        }
    }
    // Mostramos resultados
    echo $txt;
    echo "<strong>Precio Total: ${precioTotal}€</strong><br>";

    // Mostramos precio final con descuento aplicado en caso de no ser un invitado
    if($_SESSION["esInvitado"]!=true)
    {
        $nuevoPrecioTotal=($precioTotal*(100-floatval($_SESSION["dctoUser"])))/100;
        echo "<strong>Precio Total (con DCTO aplicado): ${nuevoPrecioTotal}€</strong><br><br>";
    }
    ?>
    <!-- Este enlace redirecciona al usuario para realizar otro pedido. La variable newPedido
    representa que el pedido ha sido finalizado y sus datos deben ser eliminados para proceder
    con un nuevo pedido -->
    <a href="./pedido.php?newPedido=true">Realizar otro pedido</a>
</body>
</html>