<!DOCTYPE html>
<html lang="en">
<?php 
    //array_sum, count, sort, rsort,
    $listaTemperaturas = array
    (
        32.5,15,6,10,37,12.3
    );

    $media = array_sum($listaTemperaturas)/count($listaTemperaturas);
    $mediaTruncada = bcdiv($media, 1);
    $mediaRedondeada = round($media);
    
    rsort($listaTemperaturas);
    $maxTemperaturas = array_slice($listaTemperaturas, 0, 5);
    sort($listaTemperaturas);
    $minTemperaturas = array_slice($listaTemperaturas, 0, 5);
?>  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>  
    <p>
       <?php  
            echo "Media Truncada: ".$mediaTruncada."<br>";
            echo "Media Redondeada: ".$mediaRedondeada."<br>";
            
            echo "Temperaturas Mínimas: ".join(", ", $minTemperaturas)."<br>";
            echo "Temperaturas Máximas: ".join(", ", $maxTemperaturas);
       ?> 
    </p>
    
</body>
</html>