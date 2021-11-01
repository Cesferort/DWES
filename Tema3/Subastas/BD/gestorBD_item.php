<?php
/**
 * Añade un item a la base de datos. Para esto recibirá todos los datos de interés que un item
 * contiene en la base.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idCategoria       Identificador de la categoría a la que pertenece el item que se debe insertar
 * @param string $idUser            Identificador del usuario propietario al item que se debe insertar
 * @param string $nomItem           Nombre del item que se debe insertar
 * @param string $precioItem        Precio del item que se debe insertar
 * @param string $descItem          Descripción del item que se debe insertar
 * @param string $fechaFin          Fecha fin para las pujas del item que se debe insertar
 * @return boolean | integer        En caso de que la inserción se realice correctamente se devolverá
 *                                  el identificador del nuevo item creado. En caso contrario se 
 *                                  devolverá un valor lógico false
 */
function addItem($conn, $idCategory, $idUser, $nomItem, $precioItem, $descItem, $fechaFin)
{
    // Se inserta al nuevo usuario en la base de datos. Será configurado como usuario inactivo
    $queryItem="INSERT INTO item(id_cat, id_user, nombre, preciopartida, descripcion, fechafin) VALUES(?,?,?,?,?,?);";
    
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("iisdss", $idCategory, $idUser, $nomItem, $precioItem, $descItem, $fechaFin);
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return $conn -> insert_id;
    else 
        return false;
}

/**
 * Elimina un item de la base de datos y toda la información relacionada encontrable en las 
 * tablas imagen y puja. Para esto recibe el identificador del mismo.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item a eliminar de la base de datos
 * @return boolean                  Valor lógico que representa si la eliminación se ha 
 *                                  completado correctamente
 */
function deleteItem($conn, $idItem)
{
    $queryItem="DELETE FROM item WHERE id=?";
    $queryImagen="DELETE FROM imagen WHERE id_item=?";
    $queryPuja="DELETE FROM puja WHERE id_item=?";
   
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();
    // Solo en caso de que la anterior eliminación finalice correctamente se 
    // proseguirán eliminando datos
    if($stPrepared && $stExecuted)
    {
        $st=$conn -> prepare($queryImagen);
        $stPrepared=$st -> bind_param("i", $idItem);
        $stExecuted=$st -> execute();
    
        if($stPrepared && $stExecuted)
        {
            $st=$conn -> prepare($queryPuja);
            $stPrepared=$st -> bind_param("i", $idItem);
            $stExecuted=$st -> execute();

            if($stPrepared && $stExecuted)
                return true;
        }
    }
    return false;
}

/**
 * Busca en la base de datos el item asociado al identificador pasado como parámetro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idItem            Identificador del item a buscar en la base de datos
 * @return array $resultItem        Item asociado al identificador pasado como parámetro
 */
function getItemById($conn, $idItem)
{
    $resultItem="";
    $queryItem="SELECT * FROM item WHERE id=?;";

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
        $stResult=$st -> get_result();
        while($item=$stResult -> fetch_assoc()) 
            $resultItems[]=$item;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultItems;
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
    $queryItem="SELECT * FROM item WHERE TIMESTAMPDIFF(SECOND, fechafin, now()) > 1;";

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
 * Cambia el precio de un item existente en la base de datos. Para esto recibe el identificador
 * del item cuyo precio deseamos cambiar y el nuevo precio a establecer.
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $idItem           Identificador del item cuyo precio deseamos cambiar
 * @param double $nuevoPrecio       El nuevo precio a establecer
 * @return boolean                  Valor lógico que representa si la modificación se ha 
 *                                  realizado correctamente
 */
function setPriceOfItem($conn, $idItem, $nuevoPrecio)
{
    // Se activa al usuario en la base de datos
    $queryItem="UPDATE item SET preciopartida = ? WHERE id = ?;";
            
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("di", $nuevoPrecio, $idItem);
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
}

/**
 * Cambia la fecha fin de puja de un item existente en la base de datos. Para esto recibe el 
 * identificador del item cuyo precio deseamos cambiar y la nueva fecha a establecer.
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $idItem           Identificador del item cuyo precio deseamos cambiar
 * @param double $nuevaFechaFin     La nueva fecha de fin de puja a establecer
 * @return boolean                  Valor lógico que representa si la modificación se ha 
 *                                  realizado correctamente
 */
function setEndDateOfItem($conn, $idItem, $nuevaFechaFin)
{
    // Se activa al usuario en la base de datos
    $queryItem="UPDATE item SET fechafin = ? WHERE id = ?;";
                
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("si", $nuevaFechaFin, $idItem);
    $stExecuted=$st -> execute();

    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return true;
    else 
        return false;
}
?>