<?php
// Limpiamos la sesión y redirigimos al index
session_start();
session_unset();
header("Location: ./index.php");
?>