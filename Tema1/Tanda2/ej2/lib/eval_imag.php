<!DOCTYPE html>
<html lang="en">
<?php
    
    function conseguirImgsRand()
    {
        if(isset($_GET['nImagenes']))
        {
            $txtACifrar=$_GET['txtACifrar'];
            $desplazamiento=$_GET['desplazamiento'];

            $cifradoCompletado_Txt=cifrarCesar($txtACifrar,$desplazamiento);
            $cifradoCompletado=true;
        }
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
    <table>
        <?php
            conseguirImgsRand();
        ?>
    </table>
    <input type="hidden" name="Error" value="">
    </form>
</body>
</html>