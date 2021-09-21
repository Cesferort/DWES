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
    require_once('lib/01_cifrador.php');
    define("DIR","./files/");
    $arrDespla = array
    (
        3,
        5,
        10
    );

    $cifradoCompletado=false;
    $cifradoCompletado_Txt="";
    $txtACifrar="";
    $desplazamiento="";
    if(isset($_GET['desplazamiento']))
        $desplazamiento=$_GET['desplazamiento'];

    if(!empty($_GET['txtACifrar']) and (isset($_GET['desplazamiento']) and isset($_GET['cifradoCesar'])))
    {
        $txtACifrar=$_GET['txtACifrar'];
        $desplazamiento=$_GET['desplazamiento'];

        $cifradoCompletado_Txt=cifrarCesar($txtACifrar,$desplazamiento);
        $cifradoCompletado=true;
    }
    else if(!empty($_GET['txtACifrar']) and (isset($_GET['ficheroClave']) and isset($_GET['cifradoSusti'])))
    {
        $txtACifrar=$_GET['txtACifrar'];
        $ficheroClave=DIR.$_GET['ficheroClave'];

        $cifradoCompletado_Txt=cifrarSustitucion($txtACifrar,$ficheroClave);
        $cifradoCompletado=true;
    }
?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <table>
            <tr>
                <td>Texto a cifrar</td>
                <td>
                    <input type="text" name="txtACifrar" 
                    value="<?php 
                                echo($txtACifrar!='')? $txtACifrar : '';
                            ?>"/>
                </td>
                <?php
                    if((isset($_GET['cifradoCesar']) or isset($_GET['cifradoSusti'])) and empty($_GET['txtACifrar']))
                        echo "<td>*Debes introducir un texto</td>";
                ?>
            </tr>
            <tr>
                <td>Desplazamiento</td>
                <td>
                <?php
                    foreach($arrDespla as $radioDespla)
                    {
                        if(intval($desplazamiento)==intval($radioDespla))
                            echo "<input type = 'radio' name = 'desplazamiento' checked value = '".$radioDespla."'/>".$radioDespla;
                        else   
                            echo "<input type = 'radio' name = 'desplazamiento' value = '".$radioDespla."'/>".$radioDespla;
                        echo "<br>";    
                    }
                ?>
                </td>
                <td>
                    <input type="submit" value="CIFRADO CESAR" name="cifradoCesar"/>
                </td>   
                <?php
                    if(isset($_GET['cifradoCesar']) and !isset($_GET['desplazamiento']))
                        echo "<td>*Debes indicar un desplazamiento</td>";
                ?>     
            </tr>
            <tr>
                <td>Fichero de clave</td>
                <td>
                    <select name="ficheroClave">
                        <?php
                            if(file_exists(DIR))
                            {
                                $files=scandir(DIR);
                                foreach($files as $f)
                                {
                                    if(is_file(DIR.$f))
                                        echo "<option>$f</option>";
                                }
                            }
                            else
                                echo "*La carpeta contenedora de ficheros de clave no existe";
                        ?>
                    </select>
                </td>
                <td>
                    <input type="submit" value="CIFRADO POR SUSTITUCION" name="cifradoSusti"/>
                </td> 
                <?php
                    if(isset($_GET['cifradoSusti']) and !isset($_GET['ficheroClave']))
                        echo "<td>*No se han podido encontrar ficheros de clave</td>";
                ?>
            </tr>
        </table>
        <?php
            if($cifradoCompletado==true)
                echo "<br>".$cifradoCompletado_Txt;
        ?>
    </form>
<?php
    $cifradoCompletado=false;
    $cifradoCompletado_Txt="";
    $desplazamiento="";
?>
</body>
</html>