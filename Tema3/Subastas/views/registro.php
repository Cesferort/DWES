<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_usuario.php";

// Valores lógicos que nos ayudarán a conocer el resultado de diferentes validaciones
$checkPassword=true;
$checkUserNotExists=true;
$newUserInDB=false;
// Comprobamos si el usuario ha deseado registrar una nueva cuenta
if(isset($_POST["registerUser"]))
{
    // Validamos contraseña
    $passUser=$_POST["passUser"];
    $passUserCheck=$_POST["passUserCheck"];
    if($passUser==$passUserCheck)
    {
        $nomUser=$_POST["nomUser"];
        // Comprobamos si existe otro usuario que haya eligo el mismo nombre de usuario
        if(!userExists($conn, $nomUser))
        {
            $fullName=$_POST["fullName"];
            $emailUser=$_POST["emailUser"];
            // Añadimos el nuevo usuario a al base de dato
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
    // Comprobamos si el registro del nuevo usuario se completo correctamente y lo mostramos
    else if($newUserInDB==true)
        echo "<p>Registro completado. Comprueba tu correo para activar la cuenta.</p>";
    else 
        echo "<p style='color:red'>No se ha podido completar el registro satisfactoriamente.</p>";
    ?>
</body>
</html>
<?php require_once "./footer.php" ?>