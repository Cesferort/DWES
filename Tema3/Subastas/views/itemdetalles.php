<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_imagen.php";
require_once "../BD/gestorBD_puja.php";
require_once "../BD/gestorBD_usuario.php";
require_once "../lib/formato.php";

// No se permite el uso de la página sin haber recibido un identificador de item cuyos
// detalles podamos visualizar
if(isset($_GET["idItem"]))
{
    $idItem=$_GET["idItem"];
    $_SESSION["puntoPartida"]="./itemdetalles?idItem=${idItem}.php";

    // Recuperamos información del item deseado y sus imágenes
    $item=getItemById($conn, $idItem);
    if(isset($_SESSION["idUser"]))
        $idUser=$_SESSION["idUser"];
    $nomItem=$item["nombre"];
    $precioPartida=$item["preciopartida"];
    $descItem=$item["descripcion"];
    $fechaFin=$item["fechafin"];
    $listaImgItem=getImagesOfItem($conn, $idItem);

    // Recuperamos información de pujas asociadas con el item
    $pujaData=getPujaDataOfItem($conn, $idItem);
    $cantPujas=$pujaData[0];
    $maxPuja=$pujaData[1];
    $precioActual=$precioPartida;
    if($maxPuja>$precioPartida)
        $precioActual=$maxPuja;

    // Valores lógicos que utilizaremos para guardar el resultado de diferentes validaciones
    $pujaValida=true;
    $pujaBaja=false;
    $maxPujaAlcanzado=false;
    $fechaLimiteAlcanzada=false;
    if(isset($_POST["enviarPuja"]))
    {
        $cantidad=$_POST["cantidad"];
        $date = date("Y-m-d");
        if($date >= $fechaFin)              // La puja no puede ser anterior a la fecha actual
            $fechaLimiteAlcanzada=true;
        elseif(!is_numeric($cantidad))      // La cantidad de dinero pujada debe ser numérica
            $pujaValida=false;
        else if($cantidad <= $precioActual) // La cantidad pujada debe ser superior al precio más alto del item
            $pujaBaja=true;
        else if(count(getPujasOfUserFromToday($conn, $idUser, $date)) >= 3) // Un usuario no puede realizar más de 3 pujas el mismo día
            $maxPujaAlcanzado=true;
        else                                // Añadimos la puja a la base de datos
            addPuja($conn, $idItem, $idUser, $cantidad, $date);
    }
    
    // En caso de que el usuario haya iniciado sesión veremos información adicional sobre las pujas relacionadas al item
    $loggedInUser=false;
    if(isset($_SESSION["nomUser"]) && isset($_SESSION["idUser"]))
    {
        $loggedInUser=true;
        $listaPujas=getPujasOfItem($conn, $idItem);
    }
?>
<body>
    <?php
    $html="<h1>$nomItem</h1>";
    $html.="<h2>Número de pujas: $cantPujas - Precio actual: ".formatMoney($precioActual)." - Fecha fin para jugar: ".formatDate($fechaFin)."</h2>";
    for($i=0; $i < count($listaImgItem); $i++)
    {
        $src=$listaImgItem[$i];
        if($i < 10)
            $html.="<img src='../images/$src' alt='${nomItem}_0$i' width='150px' height='150px'>";       
        else
            $html.="<img src='../images/$src' alt='${nomItem}_$i' width='150px' height='150px'>";       
    }
    $html.="<h2>$descItem</h2>";
    $html.="<h1>Puja por este item</h1>";
    echo $html;

    // Comprobamos si el usuario ha iniciado sesión o no. Los usuarios no logueados no pueden
    // realizar nuevas pujas
    if(!$loggedInUser)
        echo "<h2>Para pujar, debes autenticarte <a href='./login.php'>aquí</a></h2>";
    else 
    {
        echo "<h2>Añade tu puja en el cuadro inferior</h2>";
    ?>
    
    <form action="<?php echo $_SERVER["PHP_SELF"]."?idItem=$idItem";?>" method="post">
        <table>
            <tr>
                <td><input type="text" name="cantidad" id="cantidad"></td>
                <td>
                    <input type="submit" name="enviarPuja" value="¡Puja!">
                    <?php
                    // Comprobamos posibles errores a mostrar por pantalla
                    if($fechaLimiteAlcanzada == true)
                        echo "<p style='color:red'>Se ha agotado el tiempo para realizar pujas sobre este item</p>";
                    else if($pujaValida == false)
                        echo "<p style='color:red'>El valor introducido no es numérico</p>";
                    else if($pujaBaja == true)
                        echo "<p style='color:red'>¡Puja muy baja!</p>";
                    else if($maxPujaAlcanzado==true)
                        echo "<p style='color:red'>Límite de 3 pujas por día</p>";
                    ?>
                </td>
            </tr>
        </table>
        <h2>Historial de la puja</h2>
        <ul>
            <?php
            // Comprobamos si existen pujas realizas por el item 
            if(count($listaPujas) == 0)
                echo "<li>No se han realizado pujas para este item</li>";
            else
            {
                for($i=0; $i < count($listaPujas); $i++)
                {
                    $puja=$listaPujas[$i];
                    $idUserPuja=$puja["id_user"];
                    $cantidadPuja=$puja["cantidad"];
                    echo "<li>".getUserFromId($conn, $idUserPuja)["username"]." - ".formatMoney($cantidadPuja)."</li>";
                }
            }
            ?>
        </ul>
    </form>
<?php
    }
}
?>
</body>
</html>
<?php require_once "./footer.php" ?>