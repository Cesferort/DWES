<?php
/**
 * Se añade una nueva puja a la base de datos. Para ello recibe como parámetros todos los
 * datos de interés que una puja contiene en la base.
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $idItem           Identificador del item asociado a la puja
 * @param integer $idUser           Identificador del usuario asociado a la puja
 * @param integer $double           Cantidad ofrecida por el usuario
 * @param string $date              Fecha en la que se ha realizado la nueva puja
 * @return boolean                  Valor lógico que representa si la inserción se ha
 *                                  realizado correctamente
 */
function addPuja($conn, $idItem, $idUser, $cantidad, $date)
{
    // Se inserta la nueva puja en la base de datos.
    $queryPuja="INSERT INTO puja(id_item, id_user, cantidad, fecha) VALUES(?,?,?,?);";

    $st=$conn -> prepare($queryPuja);
    $stPrepared=$st -> bind_param("iids", $idItem, $idUser, $cantidad, $date);
    $stExecuted=$st -> execute();

    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
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
    $pujas=getPujasOfItem($conn, $idItem);
    
    // Calculamos el precio de la puja más alta
    $maxPuja=-1;
    $idGanador=false;
    for($i=0;$i<count($pujas);$i++)
    {
        $cantidad=$pujas[$i]["cantidad"];
        if($cantidad>$maxPuja)
        {
            $maxPuja=$cantidad;
            $idGanador=$pujas[$i]["id_user"];
        }
    }

    // Formateamos correctamente y devolvemos resultado
    $result=[];
    $result[]=count($pujas);
    $result[]=$maxPuja;
    $result[]=$idGanador;
    return $result;
}

/**
 * Retorna todas las pujas relacionadas a un item en específico. Para esto recibe el
 * identificador del item cuyas pujas se desea recuperar.
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $idItem           Identificador del item asociado a las pujas
 * @return array $pujas             Lista de pujas relacionadas al item deseado
 */
function getPujasOfItem($conn, $idItem)
{
    $pujas=[];
    $queryPujas="SELECT * FROM puja WHERE id_item=? ORDER BY cantidad DESC;";
    $st=$conn -> prepare($queryPujas);
    $stPrepared=$st -> bind_param("i", $idItem);

    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($item = $stResult -> fetch_assoc()) 
            $pujas[]=$item;
    }

    // Cerramos statement
    $st -> close();
    return $pujas;
}

/**
 * Retorna todas las pujas relacionadas a un usuario en específico realizadas en cierta
 * fecha. Para esto recibe el identificador del usuario cuyas pujas se desea recuperar
 * y una fecha.
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $idUser           Identificador del usuario asociado a las pujas
 * @param string $date              Fecha en la que se desea realizar la búsqueda
 * @return array $pujas             Lista de pujas relacionadas al usuario y fecha deseados
 */
function getPujasOfUserFromToday($conn, $idUser, $date)
{
    $pujas=[];
    $queryPujas="SELECT * FROM puja WHERE id_user=? AND fecha=?;";
    $st=$conn -> prepare($queryPujas);
    $stPrepared=$st -> bind_param("is", $idUser, $date);

    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($item = $stResult -> fetch_assoc()) 
            $pujas[]=$item;
    }

    // Cerramos statement
    $st -> close();
    return $pujas;
}
?>