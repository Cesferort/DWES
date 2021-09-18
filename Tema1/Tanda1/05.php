<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
<?php 
    function ejercicio5($nomPeli)
    {
        $alumnoPelis = array
        (
            "Pepa"      => array("Hot Shots", "Kung Fury", "Terminator"), 
            "Pepin"     => array("Rambo", "Jungla de Cristal", "Terminator"),
            "Pepe"      => array("Alien El Octavo Pasajero", "Rambo", "Blood Machines")
        );  

        $contPeli = 0;
        foreach($alumnoPelis as $listaPelis)
        {
            foreach($listaPelis as $peli)
            {
                if($peli == $nomPeli)
                    $contPeli++;
            }
        }
        echo "<p>$contPeli personas tienen la película $nomPeli entre sus favoritas.</p>";
        
        $str = "";
        foreach($alumnoPelis as $alumno => $listaPelis)
            $str .= $alumno."<br>".pelisRandom($listaPelis)."<br>";
        echo "<p>Dos pelis favoritas aleatorias de cada persona:<br>$str</p>";
    }
    
    function pelisRandom($listaPelis)
    {
        $listaPelisRandom = array();
        for($numPeli=0;$numPeli<2;)
        {
            $numPeliRandom = rand(0,count($listaPelis)-1);
            if(!isset($listaPelisRandom[$numPeliRandom]))
            {
                $listaPelisRandom[$numPeli] = $numPeliRandom;
                $numPeli++;
            }
        }
        
        $str = "";
        $i = 0;
        foreach($listaPelisRandom as $peli)
        {
            $i++;
            $str.=$i.".- ".$listaPelis[$peli]."<br>";
        }
        return $str;
    }
?>
</head>
<body>
    <?php 
        ejercicio5("Rambo");
    ?>
</body>
</html>