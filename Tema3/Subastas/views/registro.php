<?php
require_once "cabecera.php";
require_once "../lib/gestorBD_usuarios.php";

$checkPassword=true;
$checkUserNotExists=true;
$newUserInDB=false;
if(isset($_POST["registerUser"]))
{
    $passUser=$_POST["passUser"];
    $passUserCheck=$_POST["passUserCheck"];
    if($passUser==$passUserCheck)
    {
        $nomUser=$_POST["nomUser"];
        if(!userExists($conn, $nomUser))
        {
            $fullName=$_POST["fullName"];
            $emailUser=$_POST["emailUser"];
            $newUserInDB=addUser($conn, $nomUser, $fullName, $passUser, $emailUser);
        }
        else 
            $checkUserExists=false;
    }
    else 
        $checkPassword=false;
}
?>
<body>
    <?php
    if(!isset($_POST["registerUser"]) || ($checkPassword==false || $checkUserNotExists==false))
    { 
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <h2>REGISTRO</h2>
        <p>Para registrarte en SUBASTAS DEWS , rellenar el siguiente formulario</p>
        <?php
        if($checkPassword==false)
            echo "<p style='color:red'>Las contraseñas introducidas no coinciden</p>";
        if($checkUserNotExists==false)
            echo "<p style='color:red'>El usuario ".$nomUser." ya existe</p>";
        ?>
        <table>
            <tr>
                <td><label for="nomUser">Usuario</label></td>
                <td><input type="text" name="nomUser" id="nomUser"></td>
            </tr>
            <tr>
                <td><label for="fullName">Nombre completo</label></td>
                <td><input type="text" name="fullName" id="fullName"></td>
            </tr>
            <tr>
                <td><label for="passUser">Password</label></td>
                <td><input type="password" name="passUser" id="passUser"></td>
            </tr>
            <tr>
                <td><label for="passUserCheck">Password (de nuevo)</label></td>
                <td><input type="password" name="passUserCheck" id="passUserCheck"></td>
            </tr>
            <tr>
                <td><label for="emailUser">Email</label></td>
                <td><input type="text" name="emailUser" id="emailUser"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="registerUser" value="Regístrate"></td>
            </tr>
        </table>
    </form>
    <?php
    }
    else if($newUserInDB==true)
        echo "<p>Registro completado. Comprueba tu correo para activar la cuenta.</p>";
    else 
        echo "<p style='color:red'>No se ha podido completar el registro satisfactoriamente.</p>";
    ?>
</body>
</html>