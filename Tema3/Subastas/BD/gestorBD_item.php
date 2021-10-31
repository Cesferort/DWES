<?php
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
function deleteItem($conn, $idItem)
{
    $queryItem="DELETE FROM item WHERE id=?";
    $queryImagen="DELETE FROM imagen WHERE id_item=?";
    $queryPuja="DELETE FROM puja WHERE id_item=?";
   
    $st=$conn -> prepare($queryItem);
    $stPrepared=$st -> bind_param("i", $idItem);
    $stExecuted=$st -> execute();

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

function getExpiredItems($conn)
{
    $resultItem=[];
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