<?php
session_start();

if(isset($_POST["enviarTipos"]))
{
    $contTipos=0;
    $hayRepetidos=false;
    $tipoCantidad=[];
    $tipoGrabar=[];
    $tipoGrabar['OTRAS']=false;
    $listaDatosRepoblar=[];
    $listaDatosRepoblar[]=[];
    for($iPregunta=1;$iPregunta<=8;$iPregunta++)
    {
        $inputTipo="inputTipo_".$iPregunta;
        $selectCantidad="selectCantidad_".$iPregunta;        
        $checkGrabar="checkGrabar_".$iPregunta;
        $tipo=strtoupper($_POST[$inputTipo]);
        if($tipo != '')
        {
            if($tipo=="OTRAS" || !array_key_exists($tipo, $tipoGrabar))
            {
                $cantidad=intval($_POST[$selectCantidad]);
                $tipoCantidad[$tipo]=$cantidad;
    
                if(isset($_POST[$checkGrabar]))
                    $tipoGrabar[$tipo]=true;
                else
                    $tipoGrabar[$tipo]=false;
    
                $contTipos++;
            }
            else
                $hayRepetidos=true;
        }
        $datos=[];
        $datos[]=$_POST[$inputTipo];
        $datos[]=$_POST[$selectCantidad];
        if(isset($_POST[$checkGrabar]))
            $datos[]=true;
        else
            $datos[]=false;
        $listaDatosRepoblar[]=$datos;
    }
    $_SESSION["listaDatosRepoblar"]=$listaDatosRepoblar;
    if($contTipos>=3 && $hayRepetidos==false)
    {
        $_SESSION["tipoCantidad"]=$tipoCantidad;
        $_SESSION["tipoGrabar"]=$tipoGrabar;
        header('Location: ./lib/jugar?primeraCarga=true.php');
        die();
    }
}
else
{
    $_SESSION["listaDatosRepoblar"]=
    [
        [],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false],
        ['', 1, false]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegir Tipos</title>
</head>
<style>
td
{
    padding:0px 60px;
}
input[type="submit"]
{
    background-color: blue;
    color:white;
    width:100%;
    padding:2px;
}
</style>
<body>
    <?php
    if(isset($_POST["enviarTipos"]))
    {
        if($hayRepetidos==true)
            echo "<h2>No se puede repetir el mismo tipo de pregunta en casillas diferentes</h2>";
        else if($contTipos<3)
            echo "<h2>Debe haber al menos 3 tipos distintos</h2>";
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <h2>Configura un mínimo de 3 tipos de preguntas</h2>
        <table>
            <tr>
                <th></th>
                <th><h2>TIPO DE PREGUNTA</h2></th>
                <th><h2>CANTIDAD</h2></th>
                <th><h2>GRABAR FALLOS</h2></th>
            </tr>
            <?php
            $listaDatosRepoblar=$_SESSION["listaDatosRepoblar"];
            for($iPregunta=1;$iPregunta<=8;$iPregunta++)
            {
                $datos=$listaDatosRepoblar[$iPregunta];
                $tipo=$datos[0];
                $cantidad=$datos[1];
                $grabar=$datos[2];
                
                $txt="<tr>";
                $txt.="<td>$iPregunta</td>";
                $txt.="<td><input type='text' value='$tipo' name='inputTipo_".$iPregunta."'></td>";
                $txt.="<td><select name='selectCantidad_".$iPregunta."'>";
                for($nOption=1;$nOption<=10;$nOption++)
                {
                    if($nOption==$cantidad)
                        $txt.="<option selected>$nOption</option>";
                    else
                        $txt.="<option>$nOption</option>";
                }
                $txt.="</select></td>";
                if($grabar==true)
                    $txt.="<td><input checked type='checkbox' name='checkGrabar_".$iPregunta."'>Grabar fallos</td>";
                else
                    $txt.="<td><input type='checkbox' name='checkGrabar_".$iPregunta."'>Grabar fallos</td>";
                $txt.="</tr>";
                echo $txt;
            }
            ?>
            <tr>
                <td colspan=4>
                    <input type="submit" name="enviarTipos" value="ENVIAR TIPOS">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>