<?php
require_once "cabecera.php";

// Recuperamos categoria especificada por el usuari 
$idCategoria="";
if(isset($_GET["id"]))
    $idCategoria=$_GET["id"];
// Recuperamos todos los items de la BBDD que pertenezcan a la categoria especificada
$items=getItemsOfCategory($conn, $idCategoria);

/**
 * Busca en la base de datos todos los item de la categoria especificada. Para esto 
 * recibe el identificador de la categoría a buscar.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idCategoria       Identificador de la categoría a la que pertenecen los item que debemos buscar
 * @return array $resultItems       Array de items pertenecientes a la categoria especificada
 */
function getItemsOfCategory($conn, $idCategoria)
{
    $resultItems=[];
    $queryItem="SELECT * FROM item ORDER BY nombre ASC;";
   
    // Comprobamos si el usuario ha especificado una categoría
    if($idCategoria != "") 
    {
        $queryItem="SELECT * FROM item WHERE id_cat=? ORDER BY nombre ASC;";
        $st=$conn -> prepare($queryItem);
        $stPrepared=$st -> bind_param("i", $idCategoria);
    } 
    else                    
    {
        $st=$conn -> prepare($queryItem);
        $stPrepared=true;
    }

    $stExecuted = $st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($item = $stResult -> fetch_assoc()) 
            $resultItems[] = $item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItems;
}

/**
 * Busca en la base de datos la imagen asociada al item deseado y devuelve su dirección. La base puede 
 * guardar múltiples imágenes asociadas al un item, en caso de ser así se devolvera el primer encuentro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item cuya imagen debemos buscar
 * @return string $resultImg        Dirección de la imagen encontrada. "NA" en caso de no encontrar ninguna
 */
function getImageOfItem($conn, $idItem)
{
    $resultImg="NA";

    $queryItem="SELECT * FROM imagen WHERE id_item=?;";
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();

    // Comprobamos si se preparó y ejecutó correctamente
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        if($item = $stResult -> fetch_assoc()) 
            $resultImg = DIR_IMAGES.$item["imagen"];
    }

    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultImg;
}

/**
 * Conseguir datos varios relacionados a las pujas sobre el item especificado. Para 
 * esto el identificador del item a buscar. 
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item cuyas pujas nos interesanos buscar
 * @return string $result           Array que devuelve dos valores: 
 *                                  1) Cantidad de pujas
 *                                  2) Puja más alta. Su valor será -1 en caso de no encontrar pujas
 */
function getPujaDataOfItem($conn, $idItem)
{
    $pujas=[];
    $queryPujas="SELECT * FROM puja WHERE id_item=?;";
    $st=$conn -> prepare($queryPujas);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($item = $stResult -> fetch_assoc()) 
            $pujas[]=$item;
    }
    // Cerramos statement
    $st -> close();
    
    // Calculamos el precio de la puja más alta
    $maxPuja=-1;
    for($i=0;$i<count($pujas);$i++)
    {
        $cantidad=$pujas[$i]["cantidad"];
        if($cantidad>$maxPuja)
            $maxPuja=$cantidad;
    }

    // Formateamos correctamente y devolvemos resultado
    $result=[];
    $result[]=count($pujas);
    $result[]=$maxPuja;
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
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
            $fechaLimite=$items[$i]["fechafin"];

            $txt.="<tr>";
            if($src!="NA")
                $txt.="<td><img src='".$src."' alt='".$nomItem."' width='100' height='100'></td>";
            else 
                $txt.="<td>NO IMAGEN</td>";

            $txt.="<td><a href='itemdetalles.php?idItem=".$idItem."'>$nomItem</a></td>";
            $txt.="<td>".$cantPujas."</td>";    
            // TODO Formatear correctamente el precio. Mirar ejemplo ofrecido
            $txt.="<td>".$precioActual."</td>"; 
            // TODO Formatear correctamente la fecha. Mirar ejemplo ofrecido
            $txt.="<td>".$fechaLimite."</td>";
            $txt.="</tr>";
        }
        echo $txt;
        ?>
    </table>
</body>
</html>