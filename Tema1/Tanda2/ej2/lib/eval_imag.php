<!DOCTYPE html>
<html lang="en">
<?php
    define("DIRIMG","../imagenes/");

    function rutas_imag()
    {
        $aux=[];
        $arrext=array("jpg","png","tiff","jpeg");
        if(isset($_GET['nImagenes']))
        {
            if(file_exists(DIRIMG))
            {
                $files=scandir(DIRIMG);
                foreach($files as $f)
                {
                    if(is_file(DIRIMG.$f))
                    {
                        $fSeccionado = explode('.', $f);
                        $ext=$fSeccionado[1];
                        $md5 = md5_file(DIRIMG.$f, true);
                        if(in_array($ext, $arrext) && !in_array($md5, $aux))
                            $aux[DIRIMG.$f] = $md5;
                    }
                }
            }
            else
                echo "*La carpeta contenedora de ficheros de clave no existe";
        }

        return array_keys($aux);
    }

    function conseguirImgsRand()
    {
        $nImagenes=$_GET['nImagenes'];
        $listaImag=rutas_imag();
        
        shuffle($listaImag);
        for($i=0;$i<$nImagenes;$i++)
        {
            $fileName=substr($listaImag[$i], strrpos($listaImag[$i], '/')+1);
            echo'<tr>
                    <td>
                        <img src="'.$listaImag[$i].'" width="300" height="300">
                        <input type="checkbox" name="imagenes[]" value="'.$fileName.'">Me gusta
                    </td>
                </tr>';
        }
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
if(isset($_GET['verImagenes']))
{
?>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <?php
            echo '<table>';
            conseguirImgsRand();
            echo '</table>';
        ?>
        <input type="submit" value="ENVIAR VALORACIONES" name="enviarValoraciones"/>
    </form>
<?php
}
else
{
    if(isset($_GET['imagenes']))
    {
        echo '<p>Gracias por tu envío</p>';

        $f = fopen("../files/resultados.txt", "a");
        
        $client_ip = $_SERVER['REMOTE_ADDR'];
        $linea = "\n".$client_ip.":\t";

        $listaImagLike=$_GET['imagenes'];
        for($i=0;$i<count($listaImagLike);$i++)
            $linea.=$listaImagLike[$i].' ';
        fwrite($f,$linea); 

        fclose($f);
    }
    else
        echo '<p>Sentimos que no le haya gustado ninguna</p>';

    echo '<a href="../selec_cantidad.php">Vuelve a la página principal</a>';
}
?>
</body>
</html>