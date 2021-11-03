<?php
/**
 * Busca en la base de datos el item asociado al identificador pasado como parámetro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item a buscar en la base de datos
 * @return array $resultItem        Item asociado al identificador pasado como parámetro
 */
function getItemById($conn, $idItem)
{
    $resultItem="";
    $queryItem="SELECT * FROM items WHERE id=?;";

    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);

    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult=$st -> get_result();
        if($item=$stResult -> fetch_assoc()) 
            $resultItem = $item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItem;
}
/**
 * Busca en la base de datos todos los item cuya fecha fin para pujas no ha expirado.
 * @param mysqli $conn              Conexión a la base de datos
 * @return array $resultItems       Array de items expirados
 */
function getNotExpiredItems($conn)
{
    $resultItem=[];
    // Se seledccionan los items cuya fecha fin de las pujas sea 1 segundo superior o más
    // a la fecha actual
    $queryItem="SELECT * FROM items WHERE TIMESTAMPDIFF(SECOND, fechafin, now()) < 0;";

    $st=$conn -> prepare($queryItem);
    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stExecuted) 
    {
        $stResult=$st -> get_result();
        while($item=$stResult -> fetch_assoc()) 
            $resultItem[]=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItem;
}
/**
 * Busca en la base de datos todos los item cuya fecha fin para pujas ha expirado.
 * @param mysqli $conn              Conexión a la base de datos
 * @return array $resultItems       Array de items expirados
 */
function getExpiredItems($conn)
{
    $resultItem=[];
    // Se seledccionan los items cuya fecha fin de las pujas sea 1 segundo superior o más
    // a la fecha actual
    $queryItem="SELECT * FROM items WHERE TIMESTAMPDIFF(SECOND, fechafin, now()) > 1;";

    $st=$conn -> prepare($queryItem);
    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stExecuted) 
    {
        $stResult=$st -> get_result();
        while($item=$stResult -> fetch_assoc()) 
            $resultItem[]=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItem;
}
?>