<!DOCTYPE html>
<html lang="en">
<?php 
    $listaRutasImg = array
    (
        "imagenes/img_01.jpeg",
        "imagenes/img_02.jpeg",
        "imagenes/img_03.jpeg",
        "imagenes/img_04.jpeg",
        "imagenes/img_05.jpeg",
        "imagenes/img_06.jpeg",
        "imagenes/img_07.jpeg",
        "imagenes/img_08.jpeg",
        "imagenes/img_09.jpeg"
    );
    
    function dibujarTablaImg($input)
    {
        $aux = [];
        $contImg = 0;
        echo "<tr>";
        $rowRecienCerrada = true;
        foreach($input as $img)
        {
            $md5 = md5_file($img, true);
            if(!in_array($md5, $aux))
            {
                $aux[$img] = $md5;
                echo '<td><a target="_blank" href="'.$img.'">'
                . '<img src="'.$img.'" style="object-fit:cover" width="100" height="100"></img>'
                . '</a></td>';
                if(++$contImg%3==0)
                {
                    echo "</tr>";
                    $rowRecienCerrada = true;
                }
                else
                    $rowRecienCerrada = false;
            }
        }
        if($rowRecienCerrada == false)
            echo "</tr>";
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <?php 
            dibujarTablaImg($listaRutasImg);
        ?>
    </table>
</body>
</html>