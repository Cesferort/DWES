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
        conseguirFecha();
        diasParaFinalizarAnio();
        ejercicioArray();
        $input="Me gusta intercambiar las eñes por cosas que no son eñes pero parecen eñes.";
        encoderDeEnies($input);
        echo join(', ',arrayAleatorio(20,69,420));
        echo "<p>".cifrarCadena("Hola amo.")."</p>";
        
        function conseguirFecha()
        {
            $numDia = date('d');
            $nomMes = date('F');
            $numAnio = date('Y');
            $diaSemana = date('l');

            echo "<p>Fecha: ${numDia}th $nomMes ${numAnio}, $diaSemana</p>";
        }
        
        function diasParaFinalizarAnio()
        {
            $timeEnd = strtotime("2022/1/1");
            $timeStart = time();
            
            $timeResult = $timeEnd-$timeStart;
            $timeResult_Dias = (int)($timeResult / 86400);
            
            echo "<p>Quedan ".$timeResult_Dias." para terminar el año.</p>";
        }
        
        function ejercicioArray()
        {
            $arrayPalabras = array("Pepa", "para", "Pepín", "pon", "pan");
            
            $resultado = "";
            foreach($arrayPalabras as $palabra)
                $resultado.=$palabra." ";
            
            echo "<p>$resultado</p>";
        }
        
        function encoderDeEnies($input)
        {
            $output=str_replace('ñ','gn',$input);
            echo "<p>$output</p>";
        }
        
        function arrayAleatorio($n,$limite1,$limite2)
        {
            if($limite2 < $limite1)
            {
                $swap = $limite2;
                $limite2 = $limite1;
                $limtie1 = $limite2;
            }
            
            srand(time());
            $arrayResultado = array();
            for($contRandoms=0;$contRandoms<$n;$contRandoms++)
            {
                
                $randNumber = rand($limite1,$limite2);
                $arrayResultado[$contRandoms]=$randNumber;
            }
            
            return $arrayResultado;
        }
        
        function cifrarCadena($input)
        {
            $mapAsociativo = array
            (
                "A" => "20",
                "H" => "9R",
                "M" => "abcd"
            );
            
            $cadenaResult = "";
            for($i=0;$i<strlen($input);$i++)
            {
                $letra = $input[$i];
                $letraUpper = strtoupper($letra);
                $letraEncontrada = false;
                
                if(isset($mapAsociativo[$letraUpper]))
                {
                    $valorEnMapa = $mapAsociativo[$letraUpper];
                    $cadenaResult.= $valorEnMapa;
                }
                else
                    $cadenaResult.= $letra;
            }
            return $cadenaResult;
        }
    ?>
</body>
</html>