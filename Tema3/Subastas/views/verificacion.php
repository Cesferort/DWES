<?php 
require_once "cabecera.php";
require_once "../BD/gestorBD_usuario.php";

$userVerified=false;
if(isset($_GET["emailUser"]) && isset($_GET["codVerificacion"]))
{
    $codVerificacion=urldecode($_GET["codVerificacion"]);
    $emailUser=urldecode($_GET["emailUser"]);

    $userVerified=verifyUser($conn, $codVerificacion, $emailUser);
}
?>
<body>
    <?php
    if($userVerified)
        echo "<p>Se ha verificado tu cuenta. Puedes entrar pinchando <a href='login.php'>log in</a></p>";
    else
        echo "<p>No se puede verificar dicha cuenta.</p>";
    ?>
</body>
</html>