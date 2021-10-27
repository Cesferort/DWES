<?php
function userExists($conn, $nomUser)
{
    $queryUser="SELECT * FROM usuario WHERE username=?;";
    
    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("i", $nomUser);
    $stExecuted = $st -> execute();

    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        while($usuario = $stResult -> fetch_assoc()) 
        {
            // Buscamos si existe un usuario registrado con mismo nombre de usuario
            if($usuario["username"] == $nomUser)
            {
                // Cerramos statement y devolvemos resultado
                $st -> close();
                return true;
            }
        }
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return false;
}

function addUser($conn, $nomUser, $fullName, $passUser, $emailUser)
{

}
?>