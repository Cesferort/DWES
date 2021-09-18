<!DOCTYPE html>
<html lang="en">
<?php 
    $listaCiudades = array
    (
        "Ciudad1",
        "Ciudad2",
        "Ciudad3",
        "Ciudad2",
        "Ciudad5",
        "Ciudad3",
        "Ciudad7"
    );
    
    $listaCiudades = array_unique($listaCiudades);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ol>
        <?php 
            foreach($listaCiudades as $ciudad)
                echo "<li>$ciudad</li>";            
        ?>
    </ol>
</body>
</html>