<!-- Archivo ofrecido por el profesor -->
<?php
$catsql = "SELECT * FROM categoria ORDER BY categoria ASC;";
$catresult = mysqli_query($conn,$catsql);

echo "<a href='./subastas_vencidas.php'>SUBASTAS VENCIDAS</a><br>";
echo "<a href='./subastas_vigentes.php'>SUBASTAS EN CURSO</a>";
?>