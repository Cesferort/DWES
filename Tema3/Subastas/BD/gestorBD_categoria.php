<?php
/**
 * Devuelve todas las categorías de item encontradas en la base de datos.
 * @param mysqli $conn                  Conexión a la base de datos
 * @return array $resultCategories      Array de categorías de item
 */
function getCategories($conn)
{
    $resultCategories=[];
    $queryCategory="SELECT * FROM categoria ORDER BY categoria ASC;";
    
    $st=$conn -> prepare($queryCategory);
    $stPrepared=true;

    $stExecuted = $st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult=$st -> get_result();
        while($item=$stResult -> fetch_assoc()) 
            $resultCategories[]=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultCategories;
}
?>