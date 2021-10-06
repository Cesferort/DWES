<!DOCTYPE html>
<html lang="en">  
<?php
session_start();
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

$tipoValido=true;
if(isset($_POST["errTipo"]))
    $tipoValido=false;

$hayPlatosSeleccionados=false;
if(isset($_GET["newPedido"]) || !isset($_SESSION["platosElegidos"]))
{
    $_SESSION["platosElegidos"]=
    [
        "Primero" => "none",
        "Segundo" => "none",
        "Postre" => "none",
        "Bebida" => "none"
    ];
}
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
    if($tipoValido==false)
        echo "<p class='rojo'>Se ha intentado seleccionar un tipo de plato no permitido.</p>"
    ?>
    <a href="./pedidoplato.php?tipo=Primero">PRIMER PLATO</a><br><br>
    <a href="./pedidoplato.php?tipo=Segundo">SEGUNDO PLATO</a><br><br>
    <a href="./pedidoplato.php?tipo=Postre">POSTRE</a><br><br>
    <a href="./pedidoplato.php?tipo=Bebida">BEBIDA</a>
    <?php
    if(isset($_SESSION["platosElegidos"]) && count($_SESSION["platosElegidos"])>0)
    {
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
    }
    ?>
    <?php
    if($hayPlatosSeleccionados==true)
    {
        echo "<form action='./finpedido.php' method='post'>";
        echo "<input type='submit' name='enviarPedido' value='Enviar'>";
        echo "</form>";
    }
    ?>
</body>
</html>