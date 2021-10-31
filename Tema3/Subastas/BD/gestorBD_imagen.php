<?php
function addImagen($conn, $idItem, $imagen)
{
    $queryImagen="INSERT INTO imagen(id_item, imagen) VALUES(?,?);";
    
    $st=$conn -> prepare($queryImagen);
    $stPrepared=$st -> bind_param("is", $idItem, $imagen);
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
}
function deleteImagen($conn, $idItem, $deletePathImg)
{
    $f="../images/".$deletePathImg;
    unlink($f);

    $queryImagen="DELETE FROM imagen WHERE id_item=? AND imagen=?;";
    
    $st=$conn -> prepare($queryImagen);
    $stPrepared=$st -> bind_param("is", $idItem, $deletePathImg);
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
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
 * Busca en la base de datos las imágenes asociadas al item deseado y devuelve su dirección.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item cuya imagen debemos buscar
 * @return array $listaImgItem     Dirección de la imagen encontrada. "NA" en caso de no encontrar ninguna
 */
function getImagesOfItem($conn, $idItem)
{
    $listaImgItem=[];

    $queryItem="SELECT * FROM imagen WHERE id_item=?;";
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();

    // Comprobamos si se preparó y ejecutó correctamente
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($item = $stResult -> fetch_assoc()) 
            $listaImgItem[] = $item["imagen"];
    }

    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $listaImgItem;
}
?>