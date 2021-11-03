<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";
require_once "../BD/gestorBD_puja.php";
require_once "../BD/gestorBD_usuario.php";
require_once "../lib/formato.php";

if(!isset($_SESSION["pujasFicticias"]))
    $_SESSION["pujasFicticias"]=[];

$notExpiredItems=getNotExpiredItems($conn);

for($i=0; $i < count($notExpiredItems); $i++)
{
    $notExpiredItem=$notExpiredItems[$i];
    $idItem=$notExpiredItem["id"];
    $enviarPujaFict="enviarPujaFict_$i";
    if(isset($_POST[$enviarPujaFict]))
    {
        $pujaFict="pujaFict_$i";
        $pujaFict=$_POST[$pujaFict];
        
        $pujaNumerica=true;
        $pujaValida=true;
        if(!is_numeric($pujaFict))
            $pujaNumerica=false;
        else 
        {
            $maxPuja="maxPujat_$i";
            $maxPuja=$_POST[$maxPuja];
            if(doubleval($maxPuja) >= doubleval($pujaFict))
                $pujaValida=false;
            else if(isset($_SESSION["pujasFicticias"][$idItem]))
            {
                $precioComparar=$_SESSION["pujasFicticias"][$idItem];
                if(doubleval($precioComparar) >= doubleval($pujaFict))
                    $pujaValida=false;
                else
                    $_SESSION["pujasFicticias"][$idItem]=$pujaFict;
            }
            else
                $_SESSION["pujasFicticias"][$idItem]=$pujaFict;
        }
    }
}

$checkInsert=true;
if(isset($_POST["grabarPujas"]))
{
    if(isset($_POST["pujasMarcadas"]))
    {
        $pujasMarcadas=$_POST["pujasMarcadas"];
        $insercionCompletada=true;
        for($i=0; $i < count($pujasMarcadas) && $checkInsert; $i++)
        {
            $idItem=intval($pujasMarcadas[$i]);
            $usersFalsos=getFakeUsers($conn);
            $idUser=$usersFalsos[array_rand($usersFalsos)]["id"];
            $cantidad=doubleval($_SESSION["pujasFicticias"][$idItem]);
            $fecha="03/11/2021"; 

            $checkInsert=addPuja($conn, $idItem, $idUser, $cantidad, $fecha);
        }
        session_unset();
    }
}
?>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <h2>SUBASTAS VIGENTES</h2>
        <table>
            <tr>
                <th>ITEM</th>
                <th>ULTIMA PUJA</th>
                <th>QUEDAN</th>
                <th>PUJA FICTICIA</th>
            </tr>
            <?php
            for($i=0; $i < count($notExpiredItems); $i++)
            {
                $notExpiredItem=$notExpiredItems[$i];
                $idItem=$notExpiredItem["id"];
                $nomItem=$notExpiredItem["nombre"];
                $preciopartida=$notExpiredItem["preciopartida"];
                $pujaData=getPujaDataOfItem($conn, $idItem);
                $maxPuja=$pujaData[1];
                if($maxPuja < $preciopartida)   // Un item podría no tener pujas asociadas
                {
                    $maxPuja=$preciopartida;
                    // En caso de que no se hayan hecho pujas tampoco habrá ganador
                    $ganador=false; 
                }
                else 
                    $ganador=true;
            
                $fechaActual=new DateTime(); 
                $fechaFin=new DateTime(formatDate_vigentes($notExpiredItem["fechafin"])); 
                
                $diff=$fechaActual -> diff($fechaFin); 
                $diffMeses=$diff -> m;
                $diffDias=$diff -> d;

                $html="<tr>";
                $html.="<td>$nomItem</td>";
                if($ganador == false)
                    $html.="<td>Sin pujas</td>";
                else 
                    $html.="<td>$maxPuja".CURRENCY."</td>";
                if($diffMeses == 0)
                    $html.="<td>$diffDias dias</td>";
                else if($diffMeses == 1)
                    $html.="<td>$diffMeses mes $diffDias dias</td>";
                else
                    $html.="<td>$diffMeses meses $diffDias dias</td>";

                if($ganador == true)
                {
                    $html.="<td>";
                    $cantidad="";
                    if(isset($_SESSION["pujasFicticias"][$idItem]))
                        $cantidad=$_SESSION["pujasFicticias"][$idItem];
                    $html.="<input type='text' value='$cantidad' name='pujaFict_$i'>";
                    $html.="<input type='submit' name='enviarPujaFict_$i' value='Nueva puja ficticia'>";
                    
                    if(isset($_POST["enviarPujaFict_$i"]))
                    {
                        if($pujaNumerica == false)
                            $html.="<p style='color:red'>La cantidad debe ser numérica</p>";
                        else if($pujaValida == false)
                            $html.="<p style='color:red'>La cantidad debe ser superior</p>";
                    }
                    $html.="<input type='hidden' name='maxPujat_$i' value='$maxPuja'>";
                    $html.="</td>";
                }
                else
                    $html.="<td></td>";
                $html.="</tr>";

                echo $html;
            }
            ?>
        </table>
    </form>
    <?php
    if(isset($_SESSION["pujasFicticias"]) && count($_SESSION["pujasFicticias"]) > 0)
    {
        $html="<form action='".$_SERVER['PHP_SELF']."' method='post'>";
        $html.="<h2>POSIBLES PUJAS FICTICIAS</h2>";
        $html.="<ul>";
        foreach($_SESSION["pujasFicticias"] as $idItem => $precio)
        {
            $item=getItemById($conn, $idItem);
            $html.="<li>".$item["nombre"].", ".$precio.CURRENCY."</li>";
            $html.="<input type='checkbox' value='$idItem' name='pujasMarcadas[]'>";
        }
        $html.="</ul>";
        $html.="<input type='submit' name='grabarPujas' value='GRABAR PUJAS MARCADAS'>";
        $html.="</form>";
        echo $html;
    }

    if($checkInsert)
        $html="<h3>Se ha realizado la inserción de nuevas pujas ficticias con éxito.</h3>";
    else
        $html="<h3 style='color:red'>No se ha podido realizar la inserción de nuevas pujas ficticias con éxito.</h3>";
    echo $html;
    ?>
</body>
</html>
<?php require_once "./footer.php" ?>