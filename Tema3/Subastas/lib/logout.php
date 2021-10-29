<?php
session_unset();
header("Location: ".$_SESSION["./index.php"]);
?>