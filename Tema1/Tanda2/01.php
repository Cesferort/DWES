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
    $nombre="";
    $arrModulos=array();

    if(!empty($_POST['nombre']))
    {
        $nombre = $_POST['nombre'];

        echo "<p>Datos introducidos correctamente</p>";
        echo "Nombre:".$nombre."<br>";
    }
    else
    {
?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td>Texto a cifrar</td>
                <td>
                    <input type="text" name="txtACifrar"
                        value="<?php echo $txtACifrar;?>"/>
                </td>
            </tr>
            <tr>
                <td>Desplazamiento</td>
                <td>

                </td>
                <td></td>                
            </tr>
            <tr>
                <td>Fichero de clave</td>
                <td>

                </td>
                <td></td>
            </tr>
        </table>
        <input type="text" name="nombre"
            value="<?php echo $nombre;?>"/>
        <?php
            if(isset($_POST['enviar'])&&(!isset($_POST['nombre'])))
                echo "<span>Mierda</span>";
        ?>
        <input type="submit" value="Enviar" name="enviar"/>
    </form>
<?php
    }
?>
</body>
</html>