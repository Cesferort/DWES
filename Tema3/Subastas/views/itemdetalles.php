<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_imagen.php";
require_once "../BD/gestorBD_puja.php";
require_once "../lib/formato.php";

$_SESSION["puntoPartida"]="./itemdetalles.php";

if(isset($_GET["idItem"]))
{
    $idItem=$_GET["idItem"];
    $item=getItemById($conn, $idItem);

    $idUser=$item["id_user"];   // IMPORTANT Puede que no sea necesario
    $nomItem=$item["nombre"];
    $precioPartida=$item["preciopartida"];
    $descItem=$item["descripcion"];
    $fechaFin=$item["fechafin"];
    $listaImgItem=getImagesOfItem($conn, $idItem);

    $pujaData=getPujaDataOfItem($conn, $idItem);
    $cantPujas=$pujaData[0];
    $maxPuja=$pujaData[1];
    $precioActual=$precioPartida;
    if($maxPuja>$precioPartida)
        $precioActual=$maxPuja;
?>
<body>
    <?php
    $html="<h1>$nomItem</h1>";
    $html.="<h2>Número de pujas: $cantPujas - Precio actual: ".formatMoney($precioActual)." - Fecha fin para jugar: ".formatDate($fechaFin)."</h2>";

    echo $html;
    ?>
</body>
<?php
}
?>
</html>