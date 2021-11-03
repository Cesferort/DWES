<!-- Archivo ofrecido por el profesor. Posteriormente modificado para añadir funcionalidad -->
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
        <h1>SUBASTAS CIUDAD JARDIN</h1>
    </div>
    <div id="menu">
        <a href="index.php">Home</a>
    </div>
    <div id="container">
        <div id="bar">
            <?php require("barra.php"); ?>
        </div>
        <div id="main">