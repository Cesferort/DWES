<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_puja.php";
require_once "../BD/gestorBD_usuario.php";
require_once "../lib/formato.php";

// Comprobar si el usuario ha deseado eliminar items
if(isset($_POST["borrar"]))
{
    // Comprobar si se han seleccionado items a eliminar
    if(isset($_POST["checkSubastas"]))
    {
        // Recuperar identificadores de los items a eliminar y proceder a su eliminación 1 a 1
        $checkSubastas=$_POST["checkSubastas"];
        for($i=0; $i < count($checkSubastas); $i++)
            deleteItem($conn, $checkSubastas[$i]);   
    }
}

// Recuperamos todos los items cuya fecha de puja haya expirado
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
                // Comprobar si el usuario ha hecho click sobre el nombre del item actual. 
                // Mostraremos la descripción del item en caso de ser así
                if(isset($_GET["clickIdItem"]) && $_GET["clickIdItem"] == $idItem)
                {
                    $decItem=$item["descripcion"];
                    $html.="<br>".$decItem;
                }
                $html.="</td>";
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