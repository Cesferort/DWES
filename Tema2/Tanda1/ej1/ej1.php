<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.red
{
    color:red;
}
form
{
    background-color: lightgray;
    border: 5px solid lightblue;
    width:320px;
    padding:20px;
}
</style>
<?php
session_start();
$nomValido=true;

// Comprobar si se ha cerrado la sesión
if(isset($_GET["logout"]))
{
    session_unset();
    session_destroy();
    session_start();
}
else
{
    // Comprobar si se desea añadir un usuario
    if(isset($_POST["aniadir"]) && isset($_POST["nomUser"]))
    {
        $newName=$_POST["nomUser"];
        // Comprobar si la cadena tiene carácteres no alfabéticos
        if(nomValido($newName))
        {
            if($newName!=''&&!in_array($newName,$_SESSION['nombres']))
                $_SESSION['nombres'][]=$newName;
        }    
        else
            $nomValido=false;
    }
}
// Cantidad de usuarios introducidos
$cantUsers=0;
if(isset($_SESSION['nombres']))
    $cantUsers=count($_SESSION['nombres']);
else
    $_SESSION['nombres']=[];

function nomValido($newName)
{
    for($i=0;$i<strlen($newName);$i++)
    {
        $letra_newName=$newName[$i];
        if(!($letra_newName==' '||(ord($letra_newName)<=ord('z')&&ord($letra_newName)>=ord('a')) || (ord($letra_newName)<=ord('Z')&&ord($letra_newName)>=ord('A'))))
            return false;
    }
    return true;
}
?>
<body>
    <?php
    if($nomValido==false)
        echo "<p class='red'>No has escrito el nombre únicamente con espacios y letras.</p>";
    ?>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td><strong>Escriba algún nombre:</strong></td>
                <td colspan=3>
                    <input type="text" name="nomUser" id="nomUser">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <input type="submit" name="aniadir" value="Añadir">
                </td>
                <td>
                    <input type="submit" name="borrar" value="Borrar">
                </td>
            </tr>
        </table>
    </form>
    <?php
    if($cantUsers==0)
        echo "<p>Todavía no se han introducido nombres</p>";
    else
    {
        echo "<p>Datos introducidos</p>";

        $txt="";
        for($nUser=0;$nUser<$cantUsers;$nUser++)
            $txt.="<li>".$_SESSION['nombres'][$nUser]."</li>";
        $txt="<ul>".$txt."</ul>";

        echo $txt;
    }
    ?>
    <a href="?logout">Cerrar sesión (se perderán los datos almacenados)</a>
</body>
</html>