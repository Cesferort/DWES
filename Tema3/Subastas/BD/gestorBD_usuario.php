<?php
function login($conn, $nomUser, $passUser)
{
    $datosResult=[];
    $queryUser="SELECT * FROM usuario WHERE username = ? AND password = ?;";
    
    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("ss", $nomUser, $passUser);
    $stExecuted = $st -> execute(); 

    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        if($usuario = $stResult -> fetch_assoc()) 
        {
            if($usuario["activo"]==intval(true))
                $datosResult[]=1;
            else if($usuario["activo"]==intval(false))
                $datosResult[]=0;
        }
        else 
            $datosResult[]=-1;
    }

    // Cerramos statement y devolvemos resultado
    $st -> close();
    $datosResult[]=$usuario["id"];
    return $datosResult;
}

function userExists($conn, $nomUser)
{
    $queryUser="SELECT * FROM usuario WHERE username=?;";
    
    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("s", $nomUser);
    $stExecuted = $st -> execute(); 

    // En caso de que la query se haya realizado correctamente recuperamos los resultados
    if($stPrepared && $stExecuted) 
    {
        $stResult = $st -> get_result();
        if($usuario = $stResult -> fetch_assoc()) 
        {
            // Cerramos statement y devolvemos resultado
            $st -> close();
            return true;
        }
    }
    // Cerramos statement y devolvemos resultado
    $st -> close();
    return false;
}

function addUser($conn, $nomUser, $fullName, $passUser, $emailUser)
{
    // Generar código de verificación
    $codVerificacion=generateVerificationCode(16);
    // Se inserta al nuevo usuario en la base de datos. Será configurado como usuario inactivo
    $queryUser="INSERT INTO usuario(username, nombre, password, email, cadenaverificacion, activo, falso) VALUES(?,?,?,?,?,?,?);";
    
    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("sssssii", $nomUser, $fullName, $passUser, $emailUser, $codVerificacion, intval(false), intval(false));
    $stExecuted=$st -> execute();
    
    // Cerramos statement y devolvemos resultado
    $st -> close();
    if($stPrepared && $stExecuted)
        return sendVerificationCode($nomUser, $codVerificacion, $emailUser);
    else 
        return false;
}

function generateVerificationCode($size) 
{
    $result='';
    $permittedChars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length=strlen($permittedChars);
    for($i=0; $i<$size; $i++) 
    {
        $random_character=$permittedChars[mt_rand(0, $length-1)];
        $result.=$random_character;
    }
    return $result;
}

function sendVerificationCode($nomUser, $codVerificacion, $emailUser)
{
    $urlCadRandom=urlencode($codVerificacion);
    $urlEmail=urlencode($emailUser);            
    $enlace="http://127.0.0.1/DWES/Tema3/Subastas/views/verificacion.php?emailUser=$urlEmail&codVerificacion=$urlCadRandom";            

    $msg=<<<MAIL
                Hola $nomUser. Haz clic en el siguiente enlace para registrarte:
                $enlace
                Gracias
            MAIL;

    $subject  = "Registro en ".FORUM_TITLE;
    $headers  = 'From: phpalas4am@gmail.com' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';
    return mail($emailUser, $subject, $msg, $headers);
}

function verifyUser($conn, $codVerificacion, $emailUser)
{
    $queryUser="SELECT * FROM usuario WHERE email=? AND cadenaverificacion=?;";

    $st=$conn -> prepare($queryUser);
    $stPrepared=$st -> bind_param("ss", $emailUser, $codVerificacion);
    $stExecuted=$st -> execute();
    
    if($stPrepared && $stExecuted)
    {
        $stResult = $st -> get_result();
        if($usuario = $stResult -> fetch_assoc()) 
        {
            $idUser=$usuario["id"];
            // Cerramos statement
            $st -> close();

            // Se activa al usuario en la base de datos
            $queryUserUpdate="UPDATE usuario SET activo = ? WHERE id = ?;";
            
            $st=$conn -> prepare($queryUserUpdate);
            $stPrepared=$st -> bind_param("ii", intval(true), intval($idUser));
            $stExecuted=$st -> execute();
            
            // Cerramos statement y devolvemos resultado
            $st -> close();
            if($stPrepared && $stExecuted)
                return true;
            else 
                return false;
        }
    }
    return false;
}
?>