<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>EJ4</title>
</head>
<body>
<?php
$GLOBALS['DIR']='../files/usuarios.txt';
$uniqueUser=true;
$registroCompletado=false;
$nomUser='Unknown';
if(isset($_POST['register']))
{
    $nomUser=$_POST['nomUser'];
    $passUser=$_POST['passUser'];
    
    $uniqueUser=isUnique($nomUser);
    if($uniqueUser==true)
        $registroCompletado=register($nomUser,$passUser);
}

function isUnique($nomUser_Check)
{
    if(file_exists($GLOBALS['DIR']))
    {
        $f = fopen($GLOBALS['DIR'], "r");
        $userFound=false;
        while(!feof($f) && $userFound==false) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(';', $linea);
            if(count($lineaSeccionada)==2)
            {
                $nomUser=$lineaSeccionada[0];
                if(trim($nomUser_Check)==trim($nomUser))
                    $userFound=true;
            }
        }
        fclose($f);

        // 1 - Usuario encontrado
        if($userFound==true)
            return false;
        // 2 - Usuario no encontrado
        else
            return true;
    }
    else
        echo "(*)Ha ocurrido un error accediendo al archivo contenedor de información sobre usuarios";
}

function register($nomUser,$passUser)
{
    if(file_exists($GLOBALS['DIR']))
    {
        $f = fopen($GLOBALS['DIR'], "a");
        $linea="\n".$nomUser.";".$passUser;
        fwrite($f, $linea); 
        fclose($f);

        return true;
    }
    return false;
}
?>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <h3>REGÍSTRATE</h3>
            <?php
            if($uniqueUser==false)
            {
                $nomUser=$_POST['nomUser'];
                $txt=
                "
                <p style='color:red;'>
                    Lo sentimos, ya existe un usuario
                    <strong>${nomUser}</strong>
                </p>
                ";  
                $uniqueUser=true;
                echo $txt;
            }
            ?>
            <tr>
                <td>Nombre de usuario:</td>
                <td>
                    <input type="text" name="nomUser" value='<?php echo (isset($_GET['nomUser'])) ?  $_GET['nomUser'] : ""; ?>'>
                </td>
                <td rowspan=2>
                    <img src="../files/register.png" width="50" height="50">
                </td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td>
                    <input type="password" name="passUser">
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <input type="submit" value="REGISTRAR" name="register">
                </td>
            </tr>
        </table>
    </form>
    <?php
    if($registroCompletado==true)
    {
        $txt=
        "
        <p>
            <strong>${nomUser}</strong>: Has sido dado de alta
        </p>
        <a href='../login.php' style='font-size:20px;'>ENTRAR AL CHAT</a>
        ";
        echo $txt;
    }
    ?>
</body>
</html>