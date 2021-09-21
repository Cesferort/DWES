<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    define("DIR","./imagenes/");
?>
    <form action="./lib/eval_imag.php" method="get">
        <label for="nImagenes">¿Cuántas imágenes quieres ver?</label>    
        <select name="nImagenes" id="nImagenes">
            <?php
                if(file_exists(DIR))
                {
                    $files=scandir(DIR);
                    $contImg=1;
                    echo "<option>2</option>";
                    foreach($files as $f)
                    {
                        if(is_file(DIR.$f))
                        {
                            if($contImg>2)
                                echo "<option>$contImg</option>";
                            $contImg++;
                        }
                    }
                }
                else
                    echo "*La carpeta contenedora de imágenes no existe";
            ?>
        </select>
        <br>
        <input type="submit" value="VER IMÁGENES" name="verImagenes"/>
    </form>
</body>
</html>