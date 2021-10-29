<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_imagen.php";
require_once "../BD/gestorBD_puja.php";
require_once "../lib/formato.php";

$_SESSION["puntoPartida"]="./index.php";
// Recuperamos categoria especificada por el usuari 
$idCategoria="";
if(isset($_GET["id"]))
    $idCategoria=$_GET["id"];

// Recuperamos todos los items de la BBDD que pertenezcan a la categoria especificada
$items=getItemsOfCategory($conn, $idCategoria);
?>
<body>
    <table>
        <tr>
            <th>IMAGEN</th>
            <th>ITEM</th>
            <th>PUJAS</th>
            <th>PRECIO</th>
            <th>PUJAS HASTA</th>
        </tr>
        <?php
        // Mostrar información de productos
        $txt="";
        for($i=0;$i<count($items);$i++)
        {
            $idItem=$items[$i]["id"];
            $src=getImageOfItem($conn, $idItem);
            $pujaData=getPujaDataOfItem($conn, $idItem);
            $cantPujas=$pujaData[0];
            $precioActual=$pujaData[1];
            if($precioActual==-1)
            {
                $precioPartida=$items[$i]["preciopartida"];
                $precioActual=$precioPartida;
            }
            // $items[$i]["id_user"];
            // $items[$i]["descripcion"];
            $nomItem=$items[$i]["nombre"];
            $fechaFin=$items[$i]["fechafin"];

            $txt.="<tr>";
            if($src!="NA")
                $txt.="<td><img src='".$src."' alt='".$nomItem."' width='100' height='100'></td>";
            else 
                $txt.="<td>NO IMAGEN</td>";

            $txt.="<td><a href='itemdetalles.php?idItem=".$idItem."'>$nomItem</a></td>";
            $txt.="<td>".$cantPujas."</td>";    
            $txt.="<td>".formatMoney($precioActual)."</td>"; 
            $txt.="<td>".formatDate($fechaFin)."</td>";
            $txt.="</tr>";
        }
        echo $txt;
        ?>
    </table>
</body>
</html>