<?php
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
?>