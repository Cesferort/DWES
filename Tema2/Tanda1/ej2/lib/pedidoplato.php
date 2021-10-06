<!DOCTYPE html>
<html lang="en">  
<?php
require_once "../gestores/libmenu.php";
session_start();
if(!isset($_SESSION["nomUser"]))
    header('Location: ../entrada.php?errLogin=true');

$tipo="";
if(isset($_GET["tipo"]))
    $tipo=$_GET["tipo"];
else
    header('Location: ../pedido.php?errTipo=true');

$cambiarPlato=false;
$platosElegidos=$_SESSION["platosElegidos"];
if($platosElegidos[$tipo]!="none")
{
    // Vamos a reemplazar un plato del mismo tipo anteriormente escogido
    $cambiarPlato=true;
    $oldPlato=$platosElegidos[$tipo];
}
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
    if($cambiarPlato==true)
        echo "<p>Va a cambiar su elección ".$oldPlato." por:</p>";
    ?>
    <form action="./pedido.php" method="post">
        <select name="selectPlatos">
            <?php
            foreach($platos as $nomPlato => $precioPlato)
                echo "<option value='$nomPlato'>$nomPlato - $precioPlato €</option>";
            ?>
        </select>
        <input type="hidden" name="tipo" value="<?php echo $tipo;?>">
        <input type="submit" name="elegirPlato" value="<?php echo 'ELEGIR '.$tipo;?>">
    </form>
</body>
</html>