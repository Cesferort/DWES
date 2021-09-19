<!DOCTYPE html>
<html lang="en">
<?php
    function devolverEnlaces()
    {
        $listaURL = array();
        $contURL = 0;
        $handle = fopen("direcciones_url.txt", "r");
        while(!feof($handle)) 
        {
            $linea = fgets($handle); 
            $listaURL[$contURL] = $linea;
            $contURL++;
        }
        fclose($handle);
        return $listaURL;
    }
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
            $listaURL = devolverEnlaces();
            foreach($listaURL as $url)
            {
                $urlSeccionada = explode(" - ", $url);
                $nomURL=$urlSeccionada[0];
                $dirURL=$urlSeccionada[1];
                echo "<a href='$dirURL' target='_blank'>$nomURL</a><br>";
            }
        ?>
    </ol>
</body>
</html>