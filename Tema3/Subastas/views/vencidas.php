<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_puja.php";
require_once "../BD/gestorBD_usuario.php";
require_once "../lib/formato.php";

if(isset($_POST["borrar"]))
{
    if(isset($_POST["checkSubastas"]))
    {
        $checkSubastas=$_POST["checkSubastas"];
        for($i=0; $i < count($checkSubastas); $i++)
            deleteItem($conn, $checkSubastas[$i]);   
    }
}

$listaExpiredItems=getExpiredItems($conn);
?>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <h2>Subastas vencidas</h2>
        <table>
            <tr>
                <th colspan="2">ITEM</th>
                <th>PRECIO FINAL</th>
                <th>GANADOR</th>
            </tr>
            <?php
            for($i=0; $i < count($listaExpiredItems); $i++)
            {
                $item=$listaExpiredItems[$i];                
                $idItem=$item["id"];
                $nomItem=$item["nombre"];
                $preciopartida=$item["preciopartida"];
                $html="<tr>";
                $html.="<td><input type='checkbox' name='checkSubastas[]' value='$idItem'</td>";
                $html.="<td><a href='./vencidas.php?clickIdItem=$idItem'>$nomItem</a>";
                if(isset($_GET["clickIdItem"]) && $_GET["clickIdItem"] == $idItem)
                {
                    $decItem=$item["descripcion"];
                    $html.="<br>".$decItem;
                }
                $html.="</td>";
                $pujaData=getPujaDataOfItem($conn, $idItem);
                $maxPuja=$pujaData[1];
                if($maxPuja < $preciopartida)
                {
                    $maxPuja=$preciopartida;
                    $ganador=false;
                }
                else 
                {
                    $idGanador=$pujaData[2];
                    $ganador=getUserFromId($conn, $idGanador)["nombre"];
                }
                $html.="<td>PRECIO FINAL: ".formatMoney($maxPuja)."</td>";
                if($ganador == false)
                    $html.="<td></td>";
                else 
                    $html.="<td>Ganador: $ganador</td>";
                $html.="</tr>";
                echo $html;
            }
            ?>
            <tr><td colspan="4"><input style="width:100%" type="submit" name="borrar" value="BORRAR"></td></tr>
        </table>
    </form>
</body>
</html>
<?php require_once "./footer.php" ?>