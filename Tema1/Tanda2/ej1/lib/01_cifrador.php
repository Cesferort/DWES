<?php
function cifrarCesar($txtACifrar,$desplazamiento)
{
    $result="";
    for($i=0;$i<strlen($txtACifrar);$i++)
    {
        $character = ord($txtACifrar[$i]);

        $esMayus=null;          // Caracter especial
        if($character >= ord('A') and $character <= ord('Z'))
        {
            $esMayus=true;      // Caracter mayúscula
            $newCharacter=$character+$desplazamiento;

            if($esMayus==true and $newCharacter > ord('Z'))
                $newCharacter=$newCharacter - (ord('Z')-ord('A')+1);
        }
        elseif($character >= ord('a') and $character <= ord('z'))
        {
            $esMayus=false;     // Caracter minúscula
            $newCharacter=$character+$desplazamiento;

            if($esMayus==false and $newCharacter > ord('z'))
                $newCharacter=$newCharacter - (ord('z')-ord('a')+1);
        }
        else
            $newCharacter=$character;

        $result.=chr($newCharacter);
    }

    return "<strong>Texto cifrado: ".$result."</strong>";
}

function cifrarSustitucion($txtACifrar,$ficheroClave)
{
    $result="";

    $linea="";
    $handle = fopen($ficheroClave, "r");
    while(!feof($handle)) 
        $linea = fgets($handle); 
    fclose($handle);

    if($linea=="")
        return "<p>*El fichero de clave utilizado para cifrar no tiene contenido. Prueba con otro fichero</p>";
    else
    {
        for($i=0;$i<strlen($txtACifrar);$i++)
        {
            $character = ord($txtACifrar[$i]);

            if($character >= ord('A') and $character <= ord('Z'))
            {
                // Caracter mayúscula
                $diferencia=$character-ord('A');
                $result.=$linea[$diferencia];
            }    
            elseif($character >= ord('a') and $character <= ord('z'))
            {
                // Caracter minúscula
                $diferencia=$character-ord('a');
                $result.=$linea[$diferencia];
            } 
            else
            {
                // Caracter especial
                $result.=$character;
            }
        }

        return "<strong>Texto cifrado: ".$result."</strong>";
    }
}
?>