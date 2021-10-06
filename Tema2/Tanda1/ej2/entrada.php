<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Entrada</title>
</head>
<?php
// Comprobamos si la página tiene un error adjunto que representa un fallo de inicio de sesión.
// Este fallo podría ocurrir alguna de las siguientes razones: 
// 1) Datos de inicio de sesión incorrectos 
// 2) Se ha intentado acceder a una página de usuario sin haber iniciado sesión anteriormente
$loginValido=true;
if(isset($_GET["errLogin"]))
    $loginValido=false;

// Buscamos si existe un último usuario guardado en la cookie
$ultimoUsuario="";
if(isset($_COOKIE["ultimoUsuario"]))
    $ultimoUsuario=$_COOKIE["ultimoUsuario"];
?>
<style>.rojo{color:red;}</style>
<body>
    <?php
    // Mostramos en pantalla un error en caso de que el inicio de sesión haya sido incorrecto
    if($loginValido==false)
        echo"<p class='rojo'>Combinación errónea de usuario-password</p>";
    ?>
    <p>Si eres SOCIO, introduce tu usuario y password</p>
    <form action="./lib/autenticacion.php" method="post">
        <table>
            <tr>
                <td>USUARIO:</td>
                <td>
                    <input type="text" name="nomUser" id="nomUser" value="<?php echo $ultimoUsuario;?>">
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