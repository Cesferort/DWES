<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>EJ5</title>
</head>
<?php
define('DATA_CONVERSION', './files/data.txt');
$cantidad='';
$cantidadEmpty=false;
$cantidadEsNum=true;
$envioCorrecto=false;
$resultado=0;

if(isset($_POST['convertir']))
{
    $cantidad=$_POST['cantidad'];
    $moneda=$_POST['moneda'];
    
    if($cantidad!='')
    {
        if(is_numeric($cantidad))
        {
            $envioCorrecto=true;
            $resultado=convertir($cantidad, $moneda);
        }
        else
            $cantidadEsNum=false;
    }
    else
        $cantidadEmpty=true;
}

function convertir($cantidad, $moneda)
{
    if(file_exists(DATA_CONVERSION))
    {
        $f = fopen(DATA_CONVERSION, "r");
        $conversor=floatval(trim(fgets($f)));
        fclose($f);

        if($moneda=='€')
            $cantidad=$cantidad*$conversor;
        else if($moneda=='$')
            $cantidad=$cantidad/$conversor;
        return $cantidad;
    }
}
?>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td rowspan="2">Cantidad:</td>
                <td rowspan="2">
                    <input type="text" name="cantidad" id="cantidad" 
                    value=
                    '<?php 
                    if($envioCorrecto==true)
                        echo $cantidad;
                    else
                        echo "";
                    ?>'>
                    <?php 
                    if($cantidadEmpty==true)
                    {
                        $txt=
                        "
                        <span style='color:red;'>
                            ¡VACÍO!
                        </span>
                        ";
                        echo $txt;
                    }
                    else if($cantidadEsNum==false)
                    { 
                        $txt=
                        "
                        <span style='color:red;'>
                            ¡NO NUMÉRICO!
                        </span>
                        ";
                        echo $txt;
                    }
                    ?>
                </td>
                <td>
                <?php
                if(isset($_POST['convertir']) && $_POST['moneda']=='$')
                {
                    $txt=
                    "
                    <input type = 'radio' name = 'moneda' value = '€'/>
                    Euros a dólares
                    ";
                    echo $txt;
                }
                else
                {
                    $txt=
                    "
                    <input type = 'radio' name = 'moneda' value = '€' checked/>
                    Euros a dólares
                    ";
                    echo $txt;
                }
                ?> 
                </td>
            </tr>
            <tr>
                <td>
                <?php
                if(isset($_POST['convertir']) && $_POST['moneda']=='$')
                {
                    $txt=
                    "
                    <input type = 'radio' name = 'moneda' value = '$' checked/>
                    Dólares a euros
                    ";
                    echo $txt;
                }
                else
                {
                    $txt=
                    "
                    <input type = 'radio' name = 'moneda' value = '$'/>
                    Dólares a euros
                    ";
                    echo $txt;
                }
                ?> 
                </td>
            </tr>
        </table>
        <h3>
        <?php 
        if($envioCorrecto==true)
            echo $resultado;
        ?>
        </h3>
        <input type="submit" value="Convertir" name="convertir">
    </form>
</body>
</html>