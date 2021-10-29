<?php
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