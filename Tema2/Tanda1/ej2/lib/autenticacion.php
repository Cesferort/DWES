<?php
require_once "../gestores/libmenu.php";
session_start();

// Se ha intentado iniciar sesión como USUARIO
if(isset($_POST["login"]))
{
    $user=$_POST["nomUser"];
    $password=$_POST["passUser"];
    // Validar datos introducidos
    if(autentica($user,$password)==1)
    {
        session_unset();
        // Asignamos nombre, descuento y tipo de usuario al Session
        $_SESSION['nomUser']=$user;
        $_SESSION['dctoUser']=dameDcto($user);
        $_SESSION['esInvitado']=false;
        // Guardamos útimo usuario en cookie
        setcookie('ultimoUsuario',$user);
        header('Location: ./pedido.php');
    }
    else
        // Redirigimos a la página de inicio para volver a introducir datos
        header('Location: ../entrada.php?errLogin=true');
}
// Se ha intentado iniciar sesión como INVITADO
else if(isset($_POST["loginGuest"]))
{
    session_unset();
    // Asignamos nombre, descuento y tipo de usuario al Session
    $_SESSION['nomUser']='Invitado';
    $_SESSION['dctoUser']=0;
    $_SESSION['esInvitado']=true;
    header('Location: ./pedido.php');
}
?>