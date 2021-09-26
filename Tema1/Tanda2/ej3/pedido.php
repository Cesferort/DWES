<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>EJ3</title>
</head>
<?php
define('DIR', './files/articulos.txt');
$GLOBALS["precioTotal"]=0;
$GLOBALS["listaFicheros"]=getListaFicheros();
$datosArticuloCorrectos=true;

if(isset($_GET['nuevoTotal']))
    $GLOBALS["precioTotal"]=$_GET['nuevoTotal'];

if(isset($_POST['aniadirArt']))
{   
    if(!crearNuevoArt())
        $datosArticuloCorrectos=false;
}   

function getListaFicheros()
{
    $listaFicheros=[];

    $files=scandir('./files');
    foreach($files as $f)
    {
        if(is_file('./files/'.$f))
        {
            if($f!="pedido.php")
                $listaFicheros[]=explode('.',$f)[0];
        }
    }

    return $listaFicheros;
}

function generarTablaPedido()
{
    $GLOBALS["listaFicheros"]=getListaFicheros();
    if(file_exists(DIR))
    {
        $f = fopen(DIR, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(';', $linea);
            if(count($lineaSeccionada)==2)
            {
                $nomArt=$lineaSeccionada[0];
                $precioArt=floatval($lineaSeccionada[1]);
                $nuevoTotal=$GLOBALS["precioTotal"]+$precioArt;
                
                $articuloRow=
                "
                    <tr>
                        <td>$nomArt</td>
                        <td>${precioArt}€</td>
                        <td>
                            <a href='?nuevoTotal=${nuevoTotal}'>Añadir unidad</a>
                        </td>
                ";
                if(in_array($nomArt, $GLOBALS["listaFicheros"]))
                {
                    $articuloRow.=
                    "
                        <td>
                            <a href='./files/${nomArt}.txt' target='_blank'>Ver archivo</a>
                        </td>
                    ";
                }
                $articuloRow.=
                "
                    </tr>
                ";

                echo $articuloRow;
            }
        }
        fclose($f);
    }
    else
        echo "*El archivo contenedor de información sobre pedidos no ha sido encontrado";
}

function crearNuevoArt()
{
    $fNuevoArt = isset($_FILES["fNuevoArt"]) ? $_FILES["fNuevoArt"] : null;
    $nomArt = $_POST["nomArt"];
    $precioArt = floatval($_POST["precioArt"]);
    if($nomArt != '' && $precioArt > 0 && !in_array($nomArt, $GLOBALS['listaFicheros']))
    {
        $f = fopen(DIR, "a");

        $linea="\n".$nomArt.";".$precioArt;
        fwrite($f, $linea); 
        fclose($f);

        if($fNuevoArt!=null)
        {
            $f=$_FILES["fNuevoArt"];
            $fName=$nomArt.".txt";

            $target = './files/'.$fName;
            move_uploaded_file($_FILES['fNuevoArt']['tmp_name'], $target);
        }
        return true;
    }
    return false;
}
?>
<body>
    <table>
        <tr>
            <td colspan=3><h3>ELIGE TU PEDIDO</h3></td>
        </tr>
        <?php
            generarTablaPedido();
        ?>    
        <tr>
            <td colspan=3><h3><?php echo"TOTAL: ".$precioTotal."€"?></h3></td>
        </tr>  
    </table>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td colspan=3><h3>AÑADE ARTÍCULO</h3></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td>Precio(€)</td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="nomArt">
                </td>
                <td>
                    <input type="text" name="precioArt">
                </td>
                <td>
                    <input type="submit" value="AÑADIR" name="aniadirArt">
                </td>
            </tr>
            <tr>
                <td colspan=3>
                    <input type="file" name="fNuevoArt" accept=".txt"/>
                </td>
            </tr>
            <?php
                if($datosArticuloCorrectos==false)
                {
                    echo 
                    "
                        <tr>
                            <td colspan=3>(*)Los datos introducidos no son compatibles\n
                            o el artículo a insertar ya existe en la base</td>
                        </tr>
                    ";
                    $datosArticuloCorrectos=true;
                }
            ?>
        </table>    
    </form>
</body>
</html>