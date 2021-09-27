<?php
$GLOBALS['DIR']='../files/usuarios.txt';

if(isset($_POST['login']))
{
    $nomUser=$_POST['nomUser'];
    $passUser=$_POST['passUser'];
    login($nomUser,$passUser);
}

function login($nomUser_Check,$passUser_Check)
{
    if(file_exists($GLOBALS['DIR']))
    {
        $f = fopen($GLOBALS['DIR'], "r");
        $userFound=false;
        $correctPassword=false;
        while(!feof($f) && $userFound==false) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(';', $linea);
            if(count($lineaSeccionada)==2)
            {
                $nomUser=$lineaSeccionada[0];
                if($nomUser_Check==$nomUser)
                {
                    // Comprobando validez de la contraseña
                    $passUser=$lineaSeccionada[1];
                    if(trim($passUser_Check)==trim($passUser))
                        $correctPassword=true;

                    $userFound=true;
                }
            }
        }
        fclose($f);

        // 1 - Login Correcto
        if($userFound==true && $correctPassword==true)
        {
            
        }

        // 2 - Usuario encontrado, Contraseña Incorrecta
        else if($userFound==true && $correctPassword==false)
            header('Location: ../login.php?err='.$nomUser_Check);

        // 3 - Usuario no encontrado
        else if($userFound==false);

    }
    else
        echo "(*)Ha ocurrido un error accediendo al archivo contenedor de información sobre usuarios";

}
?>