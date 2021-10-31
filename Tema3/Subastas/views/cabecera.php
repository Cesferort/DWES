<?php 
require_once "../lib/config.php";

session_start();

$conn=conectarBD();
function conectarBD()
{
    $conn=new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB);
    mysqli_set_charset($conn, "UTF8");
    return $conn;
}
?>
<html>
<head>
    <title><?php echo FORUM_TITLE; ?></title>
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href=<?php echo BASE_ROUTE."/styles/style.css";?> type="text/css" />
</head>
<body>
    <div id="header">
        <h1>SUBASTAS DEWS</h1>
    </div>
    <div id="menu">
        <a href="index.php">Home</a>
        <?php
        if(isset($_SESSION['nomUser']) && isset($_SESSION['idUser'])) 
        {
            echo "<a href='logout.php'>Logout </a>";
            echo "<a href='./nuevoitem.php'>Nuevo item</a>";
            if("admin" == $_SESSION["nomUser"])
            {
                echo "<a href='./vencidas.php'> Subastas vencidas</a>";
                echo "<a href='./publi.php'> Anunciantes</a>";
            }
        }
        else
            echo "<a href='login.php'>Login</a>";
        ?>
    </div>
    <div id="container">
        <div id="bar">
            <?php require("barra.php"); ?>
        </div>
        <div id="main">