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
    define("DIRIMG","./imagenes/");

    function cuantasImag()
    {
        $arrext=array("jpg","png","tiff","jpeg");
        $contImag=0;

        if(file_exists(DIRIMG))
        {
            $files=scandir(DIRIMG);
            foreach($files as $f)
            {
                if(is_file(DIRIMG.$f))
                {
                    $fSeccionado = explode('.', $f);
                    $ext=$fSeccionado[1];
                    if(in_array($ext, $arrext))
                        $contImag++;
                }
            }
        }
        else
            echo "*La carpeta contenedora de imágenes no existe";
        return $contImag;
    }
?>
    <form action="./lib/eval_imag.php" method="get">
        <label for="nImagenes">¿Cuántas imágenes quieres ver?</label>    
        <select name="nImagenes" id="nImagenes">
            <?php
                $contImag=cuantasImag();
                for($nImag=2;$nImag<=$contImag;$nImag++)
                    echo "<option>$nImag</option>";
            ?>
        </select>
        <br>
        <input type="submit" value="VER IMÁGENES" name="verImagenes"/>
    </form>
</body>
</html>