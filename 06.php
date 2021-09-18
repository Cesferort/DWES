<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
<?php
    $diasSemana = array
    (
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
        "Domingo"
    );        
    
    function ej6($diasSemana,$horaInicio,$horaFin,$intervalo)
    {
        echo "<tr><th></th>";
        foreach($diasSemana as $dia)
            echo "<th>$dia</th>";
        echo "</tr><tr>";
        
        for($h=$horaInicio,$min=0;$h!=$horaFin&&$h<24;$min+=$intervalo)
        {
            echo"<tr>";
            
            while($min>=60)
            {
                $min-=60;
                $h++;
            }
            if($min < 10)
                echo "<td>${h}:0${min}</td>";
            else
                echo "<td>${h}:${min}</td>";
                
            for($i=0;$i<count($diasSemana);$i++)
                echo "<td></td>";
            echo "</tr>";
        }
    }
?>
</head>
<style>
    table, th, td
    {
        border: 1px solid black;
    }
    tr:nth-child(2n+2)>td
    {
        background-color: lightgray;
    }
</style>
<body>
    <table>
        <?php    
            ej6($diasSemana,9,18,15);
        ?>
    </table>
</body>
</html>