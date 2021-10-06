<!DOCTYPE html>
<html lang="en">  
<?php
require_once "../gestores/libmenu.php";
session_start();
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

$platosElegidos=$_SESSION["platosElegidos"];
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin Pedido</title>
</head>
<body>
    <?php
    echo "<h2>SU ELECCIÓN:</h2>";
    $txt="";
    $precioTotal=0;
    foreach($_SESSION["platosElegidos"] as $tipo => $plato)
    {
        if($plato!="none")
        {
            $txtLi="";
            if($tipo == "Primero")
                $txtLi="Primer plato: ";
            elseif($tipo == "Segundo")
                $txtLi="Segundo plato: ";
            else 
                $txtLi=$tipo.": ";

            $precioPlato=damePrecio($plato);
            $precioTotal+=floatval($precioPlato);
            $txt.="<p>$txtLi $plato ${precioPlato}€</p>";
        }
    }
    echo $txt;
    echo "<strong>Precio Total: ${precioTotal}€</strong><br>";
    ?>
    <a href="./pedido.php?newPedido=true">Realizar otro pedido</a>
</body>
</html>