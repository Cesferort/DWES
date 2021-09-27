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
if(isset($_GET['err']))
    echo '<p>CONTRASEÑA ERRÓNEA PARA: <strong>'.$_GET['err'].'</strong></p>';
?>
    <form enctype="multipart/form-data" action="./lib/validacion.php" method="post">
        <table>
            <tr>
                <td>Nombre de usuario:</td>
                <td>
                    <input type="text" name="nomUser">
                </td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td>
                    <input type="password" name="passUser">
                </td>
                <td>
                    <input type="submit" value="ENTRAR" name="login">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>