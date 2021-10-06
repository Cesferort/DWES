<?php
require_once "../gestores/libmenu.php";
session_start();

if(isset($_POST["login"]))
{
    $user=$_POST["nomUser"];
    $password=$_POST["passUser"];
    // Validar datos introducidos
    if(autentica($user,$password)==1)
    {
        $_SESSION['nomUser']=$user;
        $_SESSION['dctoUser']=dameDcto($user);
        $_SESSION['esInvitado']=false;
        header('Location: ./pedido.php');
    }
    else
        header('Location: ../entrada.php?errLogin=true');
}
else if(isset($_POST["loginGuest"]))
{
    $_SESSION['nomUser']='Invitado';
    $_SESSION['dctoUser']=0;
    $_SESSION['esInvitado']=true;
    header('Location: ./pedido.php');
}
?>