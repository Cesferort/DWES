<?php
require_once "cabecera.php";
require_once "../lib/formato.php";
require_once "../BD/gestorBD_imagen.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_puja.php";

// No se permite el uso de la página en caso de no recibir el identificador de un item cuyos
// detos podremos editar
if(!isset($_GET["idItem"]) && !isset($_POST["idItem"]))
    header("Location: ./index.php");

// Recuperamos el identificador
if(isset($_GET["idItem"]))
    $idItem=$_GET["idItem"];
else if(isset($_POST["idItem"]))
    $idItem=$_POST["idItem"];

// Recuperamos item de la base de datos gracias a su identificador
$item=getItemById($conn, $idItem);

$idItemUser=$item["id_user"];
if($_SESSION["idUser"] != $idItemUser)
    header("Location: ./index.php");

$_SESSION["puntoPartida"]="./editaritem.php?idItem=$idItem";

$nomItem=$item["nombre"];
$preciopartida=$item["preciopartida"];
$descripcion=$item["descripcion"];
$fechafin=$item["fechafin"];

// Eliminamos imagen
if(isset($_GET["deletePathImg"]))
{
    $deletePathImg=$_GET["deletePathImg"];
    deleteImagen($conn, $idItem, $deletePathImg);
}

// Validamos nuevo precio y lo asignamos
$cambioPrecioValido=true;
if(isset($_POST["bajarPrecio"]) || isset($_POST["subirPrecio"]))
{
    $cambioPrecio=$_POST["cambioPrecio"];
    if(is_numeric($cambioPrecio))
    {
        if(isset($_POST["bajarPrecio"]))
            $nuevoPrecio=$preciopartida-$cambioPrecio;
        else 
            $nuevoPrecio=$preciopartida+$cambioPrecio;
        setPriceOfItem($conn, $idItem, $nuevoPrecio);
    }
    else 
        $cambioPrecioValido=false;
}

// Cambiamos fecha de fin para las pujas
if(isset($_POST["finPuja_aumentarHora"]) || isset($_POST["finPuja_aumentarDia"]))
{
    if(isset($_POST["finPuja_aumentarHora"]))
    {
        $nuevaFechaFin=date_create($fechafin);
        date_modify($nuevaFechaFin, '+1 hour');
        $nuevaFechaFin=date_format($nuevaFechaFin, 'Y-m-d H:i:s'); 
    }
    else 
    {
        $nuevaFechaFin=date_create($fechafin);
        date_modify($nuevaFechaFin, '+1 day');
        $nuevaFechaFin=date_format($nuevaFechaFin, 'Y-m-d H:i:s'); 
    }
    setEndDateOfItem($conn, $idItem, $nuevaFechaFin);
}

// Guardamos imagen en el directorio images y subimos a la base de datos
if(isset($_POST["subirImgItem"]))
{    
    if(isset($_FILES["nuevaImgItem"]))
    {
        $f=$_FILES["nuevaImgItem"];
        if($f != null)
        {
            $fName=$f["name"];
            $target="../images/".$fName;
            $path=$fName;
            for($i=0; file_exists($target); $i++)
            {
                $fNameSeccionado=explode(".", $fName);
                $name=$fNameSeccionado[0];
                $ext=$fNameSeccionado[1];
                if($i < 10)
                    $path=$name."_0$i.".$ext;
                else 
                    $path=$name."_$i.".$ext;
                $target="../images/".$path;
            }
            move_uploaded_file($_FILES['nuevaImgItem']['tmp_name'], $target);
            addImagen($conn, $idItem, $path);
        }
    }
}

// Volvemos a recuperar el item para actualizar así su información por cualquier modificación
// que haya podido ocurrir
$item=getItemById($conn, $idItem);
$nomItem=$item["nombre"];
$preciopartida=$item["preciopartida"];
$descripcion=$item["descripcion"];
$fechafin=$item["fechafin"];
?>
<body>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <h2><?php echo $nomItem;?></h2>
        <table>
            <tr>
                <td>Precio de salida: <?php echo formatMoney($preciopartida);?></td>
                <td>
                    <?php
                    // Mostramos posibilidad a modoficiar precio inicial solo en caso de que no
                    // existan pujas sobre el item
                    if(getPujaDataOfItem($conn, $idItem)[0] == 0)
                    {
                        $html="<input type='text' name='cambioPrecio'>";
                        $html.="<input type='submit' name='bajarPrecio' value='BAJAR'>";
                        $html.="<input type='submit' name='subirPrecio' value='SUBIR'>";
                        if($cambioPrecioValido==false)
                            $html.="<p style='color:red'>Valor numérico esperado</p>";
                        echo $html;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Fecha fin para pujar: <?php echo formatDate($fechafin);?></td>
                <td>
                    <?php
                    $html="<input type='submit' name='finPuja_aumentarHora' value='POSPONER 1 HORA'>";
                    $html.="<input type='submit' name='finPuja_aumentarDia' value='POSPONER 1 DIA'>";
                    echo $html;
                    ?>
                </td>
            </tr>
        </table>
        <h2>Imágenes actuales</h2>
        <?php
        $listaImagenes=getImagesOfItem($conn, $idItem);
        // Comprobamos que existan imágenes vinculadas al item
        if(count($listaImagenes) <= 0)
            echo "<p>No hay imágenes del item.</p>";
        else 
        {
            $html="<table>";
            for($i=0; $i < count($listaImagenes); $i++)
            {
                $src=DIR_IMAGES.$listaImagenes[$i];
                $deletePathImg=$listaImagenes[$i];
                $html.="<tr>";
                $html.="<td><img src='$src' alt='$nomItem"."_$i"."' width='100' height='100'></td>";
                $html.="<td><a href='?deletePathImg=$deletePathImg&idItem=$idItem'>[BORRAR]</a></td>";
                $html.="</tr>";
            }
            $html.="</table>";
            echo $html;
        }
        ?>
        <table>
            <tr>
                <td>Imagen a subir</td>
                <td><input type="file" name="nuevaImgItem" accept="image/*"></td>
            </tr>
            <tr>
                <td colspan="2"><input style='width:100%' type='submit' name='subirImgItem' value='Subir'></td>
            </tr>
        </table>
        <input type="hidden" name="idItem" value="<?php echo $idItem;?>">
    </form>
</body>
</html>
<?php require_once "./footer.php" ?>