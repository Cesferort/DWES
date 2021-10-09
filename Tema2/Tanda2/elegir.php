<?php
if(isset($_POST["enviarTipos"]))
{
    $contTipos=0;
    $hayRepetidos=false;
    $tipoCantidad=[];
    for($iPregunta=1;$iPregunta<=8&&$hayRepetidos==false;$iPregunta++)
    {
        $tiposElegidos=[];
        $checkGrabar="checkGrabar_".$iPregunta;
        if(isset($_POST[$checkGrabar]))
        {
            $inputTipo="inputTipo_".$iPregunta;
            $tipo=$_POST[$inputTipo];
            if(strtoupper($tipo)=="OTRAS" || !in_array($tipo, $tiposElegidos))
            {
                $selectCantidad="selectCantidad_".$iPregunta;
                $cantidad=intval($_POST[$selectCantidad]);

                $tiposElegidos[]=$tipo;
                $tipoCantidad[$tipo]=$cantidad;
                $contTipos++;
            }
            else
                $hayRepetidos=true;
        }
    }
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
            for($iPregunta=1;$iPregunta<=8;$iPregunta++)
            {
                $txt="<tr>";
                $txt.="<td>$iPregunta</td>";
                $txt.="<td><input type='text' name='inputTipo_".$iPregunta."'></td>";
                $txt.="<td><select name='selectCantidad_".$iPregunta."'>";
                for($nOption=1;$nOption<=10;$nOption++)
                    $txt.="<option>$nOption</option>";
                $txt.="</select></td>";
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