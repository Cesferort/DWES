<?php
/**
 * Devuelve todas las categorías de item encontradas en la base de datos. 
 * @param mysqli $conn                  Conexión a la base de datos
 * @return array $result                Array de categorías de item
 */
function getCategoryById($conn, $idCat)
{
    $result=[];
    $queryCategory="SELECT * FROM categorias WHERE id=?;";
    
    $st=$conn -> prepare($queryCategory);
    $stPrepared=$st -> bind_param("i", $idCat); 

    $stExecuted = $st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult=$st -> get_result();
        if($item=$stResult -> fetch_assoc()) 
            $result=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $result;
}
?>