<?php
function cifrarCesar($txtACifrar,$desplazamiento)
{
    $result="";
    for($i=0;$i<strlen($txtACifrar);$i++)
    {
        $character = ord($txtACifrar[$i]);
        $esMayus=false;
        if($character >= ord('A') and $character <= ord('Z'))
            $esMayus=true;

        $newCharacter=$character+$desplazamiento;
        if($esMayus==true and $newCharacter > ord('Z'))
            $newCharacter=$newCharacter - (ord('Z')-ord('A')+1);
        else if($esMayus==false and $newCharacter > ord('z'))
            $newCharacter=$newCharacter - (ord('Z')-ord('A')+1);

        $result.=chr($newCharacter);
    }

    echo "<strong>Texto cifrado: ".$result."</strong>";
}
function cifrarSustitucion($txtACifrar,$ficheroClave)
{
    $result="";
    echo "<strong>Texto cifrado: ".$result."</strong>";
}
?>