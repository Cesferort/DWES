<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
$loginValido=true;
if(isset($_GET["errLogin"]))
    $loginValido=false;
?>
<style>.rojo{color:red;}</style>
<body>
    <?php
    if($loginValido==false)
        echo"<p class='rojo'>Combinación errónea de usuario-password</p>";
    ?>
    <p>Si eres SOCIO, introduce tu usuario y password</p>
    <form action="./lib/autenticacion.php" method="post">
        <table>
            <tr>
                <td>USUARIO:</td>
                <td>
                    <input type="text" name="nomUser" id="nomUser">
                </td>
            </tr>
            <tr>
                <td>PASSWORD:</td>
                <td>
                    <input type="password" name="passUser" id="passUser">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="login" value="Acceso Socio">
                </td>
            </tr>
        </table>
        <hr>
        <p>Si no dispones de usuario, entra como invitado</p>
        <input type="submit" name="loginGuest" value="Acceso Invitado">
    </form>
</body>
</html>