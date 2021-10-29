<?php
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
?>