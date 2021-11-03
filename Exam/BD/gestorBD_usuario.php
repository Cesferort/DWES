<?php
/**
 * Retornamos un usuario gracias al identificador pasado como parámetro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idUser            Identificador del usuario que deseamos encontrar
 * @return array                    Colección de datos que representa al usuario en la BD
 */
function getUserFromId($conn, $idUser)
{
    $queryUser="SELECT * FROM usuarios WHERE id=?;";
    
    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("i", $idUser);
    $stExecuted = $st -> execute(); 

    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        if($usuario = $stResult -> fetch_assoc()) 
        {
            // Cerramos statement y devolvemos resultado
            $st -> close();
            return $usuario;
        }
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return null;
}

function getFakeUsers($conn)
{
    $resultUsers=[];
    // Se seledccionan los usuarios falsos de la base de datos
    $queryUser="SELECT * FROM usuarios WHERE falso = ?;";

    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("i", intval(true));
    $stExecuted=$st -> execute();
    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult=$st -> get_result();
        while($user=$stResult -> fetch_assoc()) 
            $resultUsers[]=$user;
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return $resultUsers;
}
?>