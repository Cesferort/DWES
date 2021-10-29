<?php
require_once "cabecera.php";
require_once "../lib/gestorBD_usuarios.php";

$datosValidos=1;
if(isset($_POST["login"]))
{
    $nomUser=$_POST["nomUser"];
    $passUser=$_POST["passUser"];
    
    $datosLogin=login($conn, $nomUser, $passUser);
    $datosValidos=$datosLogin[0];
    if($datosValidos==1)
    {
        $_SESSION["nomUser"]=$nomUser;
        $_SESSION["idUser"]=$datosLogin[1];

        if(!isset($_SESSION["puntoPartida"]))
            $_SESSION["puntoPartida"]="./index.php";
        header("Location: ".$_SESSION["puntoPartida"]);
    }
}
?>
<body>
    <?php
    if(!isset($_POST["login"]) || $datosValidos != 1)
    {
        if($datosValidos==-1)
            echo "<p style='color:red'>Login incorrecto. Inténtalo de nuevo!</p>";
        else if($datosValidos==0)
            echo "<p style='color:red'>Esta cuenta no está verificada. Te hemos enviado un email para activarla.</p>";
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td>Usuario</td>
                <td><input type="text" name="nomUser" id="nomUser"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="passUser" id="passUser"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="login" value="Login!"></td>
            </tr>
        </table>
        <p>No tienes una cuenta? <strong><a href="./registro.php">Regístrate</a></strong></p>
    </form>
    <?php
    }
    ?>
</body>
</html>