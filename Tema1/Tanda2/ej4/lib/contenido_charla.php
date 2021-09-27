<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJ4</title>
    <meta http-equiv="refresh" content="2">
</head>
<?php
define("CHAT_CONTENT", "../files/contenidoChat.txt");
define("PALABRAS_OFENSIVAS", "../files/palabrasOfensivas.txt");
define("LISTA_OFENSIVAS", getPalabrasOfensivas());

function getPalabrasOfensivas()
{
    $lista=[];
    if(file_exists(PALABRAS_OFENSIVAS))
    {
        $f = fopen(PALABRAS_OFENSIVAS, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lista[]=trim($linea);
        }
        fclose($f);
    }
    return $lista;
}

function esOfensivo($txt)
{
    $ignoreChars = array(",",".",";","¡","!","?","¿");
    $txt=str_replace($ignoreChars,'',$txt);
    if(in_array(trim($txt), LISTA_OFENSIVAS))
        return true;
    return false;
}

function loadChat()
{
    if(file_exists(CHAT_CONTENT))
    {
        $f = fopen(CHAT_CONTENT, "r");
        $primeraLinea=true;
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            if($primeraLinea==true)
                $primeraLinea=false;
            else
            {
                $lineaSeccionada=explode(': ', $linea);
                $nomUser=$lineaSeccionada[0];
                $txt=$lineaSeccionada[1];

                $listaPalabras=explode(' ', $txt);
                $lineaResultado="";
                for($i=0;$i<count($listaPalabras);$i++)
                {
                    $palabra=trim($listaPalabras[$i]);
                    if($palabra==':)')
                    {
                        $palabra=
                        '
                        <img src="../files/emoji_happy.png" alt="emoji" width="10" height="10">
                        ';
                    }
                    elseif($palabra==':(')
                    {
                        $palabra=
                        '
                        <img src="../files/emoji_sad.png" alt="emoji" width="10" height="10">
                        ';
                    }
                    elseif(esOfensivo($palabra))
                    {
                        $palabraNueva='';
                        $ignoreChars = array(",",".",";","¡","!","?","¿");
                        for($contTxt=0;$contTxt<strlen($palabra);$contTxt++)
                        {
                            if(in_array($palabra[$contTxt], $ignoreChars))
                                $palabraNueva.=$palabra[$contTxt];
                            else
                                $palabraNueva.='*';
                        }
                        $palabra=$palabraNueva;
                    }
                    $lineaResultado.=' '.$palabra.' ';
                }
                echo 
                "
                <p>
                    <strong>${nomUser}</strong>: $lineaResultado
                </p>
                ";
            }
        }
        fclose($f);
        return true;
    }
    return false;
}
?>
<script type="text/javascript">
window.onload = function() 
{
    window.scrollTo(0, document.body.scrollHeight);
}
</script>
<body>
<?php
loadChat();
?>
</body>
</html>