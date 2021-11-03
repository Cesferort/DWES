<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_categoria.php";
require_once "../BD/gestorBD_puja.php";
require_once "../BD/gestorBD_usuario.php";
require_once "../lib/formato.php";

if(isset($_GET["idItemSeleccionado"]))
    $idItemSeleccionado=$_GET["idItemSeleccionado"];

$expiredItems=getExpiredItems($conn);
?>
<style>.item_seleccionado {background-color: lightgrey;}</style>
<body>
    <h2>Últimas subastas vencidas</h2>
    <table>
        <tr>
            <th>FINALIZÓ EL</th>
            <th>CATEGORIA</th>
            <th>ITEM</th>
            <th>GANADOR</th>
        </tr>
        <?php
        for($i=0; $i < count($expiredItems); $i++)
        {
            $expiredItem=$expiredItems[$i];
            $idItem=$expiredItem["id"];
            $fechaFin=$expiredItem["fechafin"];
            $idCat=$expiredItem["id_cat"];
            $nomCat=getCategoryById($conn, $idCat)["categoria"];
            $nomItem=$expiredItem["nombre"];
            $preciopartida=$expiredItem["preciopartida"];
            $pujaData=getPujaDataOfItem($conn, $idItem);
            $maxPuja=$pujaData[1];
            if($maxPuja < $preciopartida)   // Un item podría no tener pujas asociadas
            {
                $maxPuja=$preciopartida;
                // En caso de que no se hayan hecho pujas tampoco habrá ganador
                $ganador=false; 
            }
            else 
            {
                $idGanador=$pujaData[2];
                $ganador=getUserFromId($conn, $idGanador)["nombre"];
            }
            
            if(isset($_GET["idItemSeleccionado"]) && $idItemSeleccionado == $idItem)
                $html="<tr class='item_seleccionado'>";
            else 
                $html="<tr>";
            $html.="<td>".formatDate_vencidas($fechaFin)."</td>";
            $html.="<td>$nomCat</td>";
            $html.="<td>$nomItem</td>";
            if($ganador == false)
                $html.="<td>SIN PUJAS</td>";
            else 
            {
                $html.="<td>";
                $html.="<a href='./subastas_vencidas.php?idItemSeleccionado=$idItem'>$ganador</a>";
                if(isset($_GET["idItemSeleccionado"]) && $idItemSeleccionado == $idItem)
                {
                    $html.="<p>Ganado por $maxPuja ".CURRENCY."</p>";
                    $porcentajePuja=round(($maxPuja*100) / $preciopartida, 2);
                    $html.="<p>$porcentajePuja % superior al precio de partida ($preciopartida".CURRENCY.")</p>";
                }
                $html.="</td>";
            }
            $html.="</tr>";
            echo $html;
        }
        ?>
    </table>
</body>
</html>
<?php require_once "./footer.php" ?>