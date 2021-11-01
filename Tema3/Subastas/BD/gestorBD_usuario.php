<?php
/**
 * Se realiza un intento de inicio de sesión con los valores recibidos como parámetros.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $nomUser           Nombre del usuario cuya sesión queremos iniciar
 * @param string $passUser          Contraseña introducida por el usuario que debemos validar
 * @return array $datosResult       Colección de datos que muestra el resultado del intento de
 *                                  inició de sesión, sus posibles errores y el identificador
 *                                  del usuario
 */
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
        if($usuario = $stResult -> fetch_assoc())       // Comprobamos si existe un usuario con el nombre y contraseñas introducidas
        {
            if($usuario["activo"]==intval(true))        // Inicio de sesión correcto en una cuenta activada
                $datosResult[]=1;                   
            else if($usuario["activo"]==intval(false))  // Inicio de sesión correcto en una cuenta no activada
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

/**
 * Se comprueba si existe en la base de datos un usuario registrado con el nombre pasado
 * como parámetro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $nomUser           Nombre del usuario que deseamos buscar en la BD
 * @return boolean                  Valor lógico que representa si el usuario existe o no en la BD
 */
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

/**
 * Se añade un nuevo usuario a la base de datos. Para esto recibiremos todos los datos de 
 * interés como parámetros. Para esto haremos uso de las funciones generateVerificationCode,
 * que nos creará un código de verificación para el nuevo usuario, y sendVerificationCode,
 * que se encargará de enviar el código de verificación por correo al usuario.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $nomUser           Nombre del usuario que deseamos insertar en la BD
 * @param string $fullName          Nombre completo del usuario que deseamos buscar en la BD
 * @param string $passUser          Contraseña del usuario que deseamos buscar en la BD
 * @param string $emailUser         Email del usuario que deseamos buscar en la BD
 * @return boolean                  Valor lógico que representa si la inserción del nuevo
 *                                  usuario se ha realizado correctamente
 */
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

/**
 * Generamos un código de verificación aleatorio que posteriormente será enviado al correo de 
 * un usuario que haya sido recientemente registrado. Gracias a este código podrá verificar
 * su identidad y activar la cuenta. 
 * @param mysqli $conn              Conexión a la base de datos
 * @param integer $size             Longitud del código de verificación
 * @return string $result           Valor textual que representa el código generado
 */
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

/**
 * Enviamos un código de verificación creado en la función generateVerificationCode por correo
 * a un usuario. Gracias a este correo, el usuario activará su cuenta.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $nomUser           Nombre del usuario con el que debemos contactar
 * @param string $codVerificacion   Código de verificación que debemos mandarle
 * @param string $emailUser         Correo del usuario que debemos utilizar
 * @return boolean                  Valor lógico que representa si el envío del código de 
 *                                  verificación se ha enviado correctamente al destinatario
 */
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

/**
 * Verificamos identidad de un nuevo usuario en la base de datos y activamos su cuenta en caso
 * de que la verificación sea correcta.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $codVerificacion   Código de verificación que debemos comprobar
 * @param string $emailUser         Email del usuario que deseamos validar
 * @return boolean                  Valor lógico que representa si la verificación del usuario
 *                                  se ha realizado correctamente
 */
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

/**
 * Retornamos un usuario gracias al identificador pasado como parámetro.
 * @param mysqli $conn              Conexión a la base de datos
 * @param string $idUser            Identificador del usuario que deseamos encontrar
 * @return array                    Colección de datos que representa al usuario en la BD
 */
function getUserFromId($conn, $idUser)
{
    $queryUser="SELECT * FROM usuario WHERE id=?;";
    
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
?>