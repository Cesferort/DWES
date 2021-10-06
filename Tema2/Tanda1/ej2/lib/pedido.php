<!DOCTYPE html>
<html lang="en">  
<?php
session_start();
// Comprobamos que se ha iniciado sesión. En caso contrario redirigimos a la página de entrada
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

// Comprobamos que no se ha recibido un error de tipo de plato al cargar la página
$tipoValido=true;
if(isset($_POST["errTipo"]))
    $tipoValido=false;

// Variable que representa si se han elegido platos o no. La utilizaremos para permitir o no al usuario
// realizar el pedido. No nos interesa que realice un pedido sin platos
$hayPlatosSeleccionados=false;

// Comprobamos si se está realizando un nuevo pedido 
if(isset($_GET["newPedido"])||!isset($_SESSION["platosElegidos"]))
{
    // Creamos un diccionario que vincule tipo de plato con plato elegido
    $_SESSION["platosElegidos"]=
    [
        "Primero" => "none",
        "Segundo" => "none",
        "Postre" => "none",
        "Bebida" => "none"
    ];
}
// Buscamos el nuevo plato elegido por el usuario y lo añadimos al diccionario
if(isset($_POST["selectPlatos"]))
{
    $platoElegido=$_POST["selectPlatos"];
    $_SESSION["platosElegidos"][$_POST["tipo"]]=$platoElegido;
    $hayPlatosSeleccionados=true;
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
</head>
<style>.rojo{color:red;}</style>
<body>
    <?php
    // En caso de haber ocurrido un error relacionado con el tipo de plato, se muestra este mensaje
    if($tipoValido==false)
        echo "<p class='rojo'>Se ha intentado seleccionar un tipo de plato no permitido.</p>"
    ?>
    <!-- Los enlaces envían consigo una variable que representa el tipo de plato a seleccionar -->
    <a href="./pedidoplato.php?tipo=Primero">PRIMER PLATO</a><br><br>
    <a href="./pedidoplato.php?tipo=Segundo">SEGUNDO PLATO</a><br><br>
    <a href="./pedidoplato.php?tipo=Postre">POSTRE</a><br><br>
    <a href="./pedidoplato.php?tipo=Bebida">BEBIDA</a>
    <?php
    // En caso de que haya un plato elegido o más
    if($hayPlatosSeleccionados==true)
    {
        // Formateamos y mostramos correctamente la lista de platos elegidos
        echo "<h2>SU ELECCIÓN:</h2>";
        $txt="<ul>";
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
                
                $txt.="<li>$txtLi $plato</li>";
            }
        }
        $txt.="</ul>";
        echo $txt;
        
        // Damos la posibilidad a realizar el pedido
        echo "<form action='./finpedido.php' method='post'>";
        echo "<input type='submit' name='enviarPedido' value='Enviar'>";
        echo "</form>";
    }
    ?>
</body>
</html>