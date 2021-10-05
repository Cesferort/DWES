<?php
require_once "../gestores/libmenu.php";

if(isset($_POST["login"]))
{
    $user=$_POST["nomUser"];
    $password=$_POST["passUser"];
    // Validar datos introducidos
    if(autentica($user,$password)==1)
        header('Location: ./pedido.php');
    else
        header('Location: ../entrada.php?errLogin=true');
}
else if(isset($_POST["loginGuest"]))
    header('Location: ./pedido.php');
?>