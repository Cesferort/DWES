<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Diccionario que vincula productos con sus respectivos precios
$productosPrecio=
[
    "Prod1" => 10,
    "Prod2" => 20,
    "Prod3" => 10,
    "Prod4" => 30
];

// En caso de que no exista un diccionario que vincula producto con la cantidad elegida por el usuario
// lo creamos
if(!isset($_SESSION["productosCantidad"]))
{
    $_SESSION["productosCantidad"]=
    [
        "Prod1" => 0,
        "Prod2" => 0,
        "Prod3" => 0,
        "Prod4" => 0
    ];
}

// Comprobamos si se están intentando añadir unidades al carro
if(isset($_POST["aniadirUnidades"]))
{
    // Iteramos por todos los productos comprobando si sus respectivos checbox han sido seleccionados
    foreach($productosPrecio as $producto => $precio)
    {
        $checkbox="check_".$producto;
        if(isset($_POST[$checkbox]))
        {
            // Recuperamos cantidad seleccionada del producto seleccionada y procedemos a aplicar 
            // cambios en el diccionario productosCantidad. Diccionario que vincula producto con
            // cantidad seleccionada de este
            $select="select_".$producto;
            $cantidad=intval($_POST[$select]);
            if($cantidad!=0)
                $_SESSION["productosCantidad"][$producto]+=$cantidad;
        }
    }
}
// Comprobamos si el usuario desea vaciar el carro
else if(isset($_POST["vaciarCarro"]))
{
    // Reseteamos valores del diccionario
    $_SESSION["productosCantidad"]=
    [
        "Prod1" => 0,
        "Prod2" => 0,
        "Prod3" => 0,
        "Prod4" => 0
    ];
}

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro</title>
</head>
<body>
    <?php
    // Comprobamos si el usuario desea formalizar la compra
    if(isset($_POST["formalizarCompra"]))
    {
        // Formateamos correctamente los resultados de la compra haciendo uso de dos diccionarios
        // 1) productosPrecio: Vincula productos con sus respectivos precios
        // 2) productosCantidad: Array de session que vincula productos con cantidad seleccionada
        $precioTotal=0;
        $txt="<h2>Tu pedido</h2>";
        $txt.="<ul>";
        foreach($productosPrecio as $producto => $precio)
        {
            $txt.="<li>";
            $cantidadPedida=intval($_SESSION["productosCantidad"][$producto]);
            $txt.=$producto.",".$cantidadPedida." unidades a ".$precio."€";
            $txt.="</li>";
            $precioTotal+=$precio*$cantidadPedida;
        }
        $txt.="</ul>";
        $txt.="<p>TOTAL: ".$precioTotal." EUROS</p>";    
        echo $txt;
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <th></th>
                <th>PRODUCTO</th>
                <th>PRECIO</th>
                <th>ELIJA CANTIDAD</th>
                <th>PEDIDO ACTUAL</th>
            </tr>
            <?php
            // Formateamos correctamente toda la tabla/form accediendo a los valores de dos diccionarios
            // 1) productosPrecio: Vincula productos con sus respectivos precios
            // 2) productosCantidad: Array de session que vincula productos con cantidad seleccionada
            $txt="";
            foreach($productosPrecio as $producto => $precio)
            {
                $txt.="<tr>";
                $txt.="<td><input type='checkbox' name='check_".$producto."'></td>";
                $txt.="<td>".$producto."</td>";
                $txt.="<td>".$precio." €</td>";
                $txt.="<td><select name='select_".$producto."'>";
                for($nOption=0;$nOption<=10;$nOption++)
                    $txt.="<option>$nOption</option>";
                $txt.="</select></td>";
                $txt.="<td>".$_SESSION["productosCantidad"][$producto]." uds pedidas</td>";
                $txt.="</tr>";
            }
            echo $txt;
            ?>
        </table>
        <input type="submit" name="aniadirUnidades" value="AÑADIR UNIDADES">
        <input type="submit" name="formalizarCompra" value="FORMALIZAR COMPRA">
        <input type="submit" name="vaciarCarro" value="VACIAR CARRO">
    </form>
</body>
</html>