<?php
require_once "../gestores/libmenu.php";

if(isset($_POST["login"]))
{
    $user=$_POST["passUser"];
    $password=$_POST["passUser"];
    autentica($user,$password);
}
else if(isset($_POST["loginGuest"]))
{
    
}
?>