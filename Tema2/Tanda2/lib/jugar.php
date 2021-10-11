<?php
session_start();
if(!isset($_SESSION["tipoCantidad"]) || !isset($_SESSION["tipoGrabar"]))
{
    header('Location: ../elegir.php?errChooseType=true');
    die();
}

define("DIR", "../files/fallos_grabados.txt");
$juegoTerminado=true;
$_SESSION["preguntas"]=
[
    'GEOGRAFIA' => 
    [
        [
            '¿Pregunta1?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta2?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta3?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ]
    ],
    'CINE' => 
    [
        [
            '¿Pregunta1?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta2?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta3?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta4?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ]
    ],
    'CIENCIAS' => 
    [
        [
            '¿Pregunta1?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta2?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta3?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta4?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta5?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ]
    ],
    'OTRAS' => 
    [
        [
            '¿Pregunta1?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta2?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta3?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta4?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta5?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ],
        [
            '¿Pregunta6?',
            'Respuesta Correcta',
            'Respuesta Erronea1',
            'Respuesta Erronea2'
        ]
    ]
];

if(isset($_GET["primeraCarga"]))
{
    if(file_exists(DIR))
        unlink(DIR);
    $_SESSION["cuestionario"]=
    [
        'GEOGRAFIA' => [],
        'CINE' => [],
        'CIENCIAS' => [],
        'OTRAS' => []
    ];

    $tipoCantidad=$_SESSION["tipoCantidad"];

    $tipoCantidad_Limpio=
    [
        "GEOGRAFIA" => 0,
        "CINE" => 0,
        "CIENCIAS" => 0,
        "OTRAS" => 0
    ];
    foreach($tipoCantidad as $tipo => $cantidad)
    {
        if(!array_key_exists($tipo, $tipoCantidad_Limpio))
            $tipo="OTRAS";
        $tipoCantidad_Limpio[$tipo] += intval($cantidad);
    }
    
    $preguntas=$_SESSION["preguntas"];

    $cantidadGeografia=$tipoCantidad_Limpio["GEOGRAFIA"];
    if($cantidadGeografia>0)
    {   
        shuffle($preguntas['GEOGRAFIA']);
        $shuffleGeografia=$preguntas['GEOGRAFIA'];
        for($i=0;$i<count($shuffleGeografia) && $i<$cantidadGeografia;$i++)
        {
            $preguntasFinales=$_SESSION["cuestionario"]['GEOGRAFIA'];
            $preguntasFinales[]=$shuffleGeografia[$i];
            $_SESSION["cuestionario"]['GEOGRAFIA']=$preguntasFinales;
        }  
    }

    $cantidadCine=$tipoCantidad_Limpio["CINE"];
    if($cantidadCine>0)
    {   
        shuffle($preguntas['CINE']);
        $shuffleCine=$preguntas['CINE'];
        for($i=0;$i<count($shuffleCine) && $i<$cantidadCine;$i++)
        {
            $preguntasFinales=$_SESSION["cuestionario"]['CINE'];
            $preguntasFinales[]=$shuffleCine[$i];
            $_SESSION["cuestionario"]['CINE']=$preguntasFinales;
        }  
    }

    $cantidadCiencias=$tipoCantidad_Limpio["CIENCIAS"];
    if($cantidadCiencias>0)
    {   
        shuffle($preguntas['CIENCIAS']);
        
        $shuffleCiencias=$preguntas['CIENCIAS'];
        for($i=0;$i<count($shuffleCiencias) && $i<$cantidadCiencias;$i++)
        {
            $preguntasFinales=$_SESSION["cuestionario"]['CIENCIAS'];
            $preguntasFinales[]=$shuffleCiencias[$i];
            $_SESSION["cuestionario"]['CIENCIAS']=$preguntasFinales;
        }  
    }

    $cantidadOtras=$tipoCantidad_Limpio["OTRAS"];
    if($cantidadOtras>0)
    {   
        shuffle($preguntas['OTRAS']);
        $shuffleOtras=$preguntas['OTRAS'];
        for($i=0;$i<count($shuffleOtras) && $i<$cantidadOtras;$i++)
        {
            $preguntasFinales=$_SESSION["cuestionario"]['OTRAS'];
            $preguntasFinales[]=$shuffleOtras[$i];
            $_SESSION["cuestionario"]['OTRAS']=$preguntasFinales;
        }  
    }
}

function comprobarRespuesta($tipo)
{
    if(!isset($_POST["enviarRespuesta_".$tipo]))
        return false;

    $pregunta=$_POST["pregunta_".$tipo];
    if(!isset($_POST["respuesta_".$tipo]))
        $respuesta="NINGUNA";
    else
        $respuesta=$_POST["respuesta_".$tipo];

    $listaPreguntas=$_SESSION["preguntas"][$tipo];
    for($i=0;$i<count($listaPreguntas);$i++)
    {
        $preguntaRespuestas=$listaPreguntas[$i];
        if($preguntaRespuestas[0]==$pregunta)
        {
            $respuestaValida=$preguntaRespuestas[1];
            if($respuestaValida==$respuesta)
                return true;
            else
            {
                if($_SESSION["tipoGrabar"][$tipo]==true)
                {
                    $f = fopen(DIR, 'a');
                    fwrite($f, "\nTipo: ".$tipo);
                    fwrite($f, "\nPregunta: ".$pregunta);
                    fwrite($f, "\nRespuesta Correcta: ".$respuestaValida);
                    fwrite($f, "\nRespuesta Ofrecida: ".$respuesta."\n");
                    fclose($f);
                }
                return false;
            }
        }
    }  
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugar</title>
</head>
<style>
td, th
{
    border:2px black solid;
}
input[type="submit"]
{
    background-color: blue;
    color:white;
    padding:2px;
}
</style>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <?php
            $txt="<tr>";
            $txt.="<th>TIPO</th>";
            $txt.="<th>Nº PREGUNTA</th>";
            $txt.="<th>PREGUNTA</th>";
            $txt.="<th>RESPUESTAS</th>";
            $txt.="<th></th>";
            $txt.="<th></th>";
            $txt.="</tr>";
            foreach($_SESSION["cuestionario"] as $tipo => $preguntasFinales)
            {
                if(count($preguntasFinales)>0)
                {
                    $txt.="<tr>";
                    $txt.="<td>$tipo</td>";
                    $nPregunta=1;
                    if(isset($_POST["nPregunta_".$tipo]))
                        $nPregunta=intval($_POST["nPregunta_".$tipo]);
                    
                    if(isset($_POST["enviarRespuesta_".$tipo]))
                        $nPregunta++;
                    
                    if($nPregunta > count($preguntasFinales))
                        $txt.="<td></td><td></td><td></td><td></td>";   
                    else
                    {
                        $txt.="<td>$nPregunta</td>";
                        $preguntaFinal=$preguntasFinales[$nPregunta-1];
                        $pregunta=$preguntaFinal[0];
                        $txt.="<td>$pregunta";
                        $txt.="<input type='hidden' name='pregunta_".$tipo."' value='$pregunta'>";
                        $txt.="</td>";

                        $respuestas=[];
                        $respuestas[]=$preguntaFinal[1];
                        $respuestas[]=$preguntaFinal[2];
                        $respuestas[]=$preguntaFinal[3];
                        shuffle($respuestas);
                        $txt.="<td>";
                        foreach($respuestas as $respuesta)
                            $txt.="<input type='radio' name='respuesta_".$tipo."' value='$respuesta'>$respuesta";
                        $txt.="</td>";
                        $txt.="<td><input type='submit' name='enviarRespuesta_".$tipo."' value='ENVIAR RESPUESTA'></td>";
                        
                        $juegoTerminado=false;
                    }

                    $txt.="<input type='hidden' name='nPregunta_".$tipo."' value='$nPregunta'>";

                    $aciertos=0;
                    if(isset($_POST["aciertos_".$tipo]))
                        $aciertos=$_POST["aciertos_".$tipo];

                    if(comprobarRespuesta($tipo))
                        $aciertos++;

                    $txt.="<td>$aciertos aciertos";
                    $txt.="<input type='hidden' name='aciertos_".$tipo."' value='$aciertos'>";
                    $txt.="</td>";
                }
                $txt.="</tr>";
            }
            echo $txt;
            ?>
        </table>
    </form>
    <?php
    if($juegoTerminado==true && file_exists(DIR))
        echo "<a target='_blank' href='".DIR."'>Visualiza archivo de fallos grabados</a>";
    ?>
</body>
</html>