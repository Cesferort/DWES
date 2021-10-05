<?php
define('F_PLATOS','../files/platos.txt');
define('F_SOCIOS','../files/socios.txt');

function autentica($user,$password)
{
    if(file_exists(F_SOCIOS))
    {
        $f = fopen(F_SOCIOS, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(' ',$linea);
            $nomUser=$lineaSeccionada[0];
            // Comprobamos si se ha encontrado al usuario
            if($nomUser==$user)
            {
                $passUser=$lineaSeccionada[1];
                // Comprobamos si la contraseña es correcta
                if($passUser==$password)
                {
                    fclose($f);
                    return 1;
                }
            }
        }
        fclose($f);
        return 0;
    }
}

function dameDcto($user)
{
    if(file_exists(F_SOCIOS))
    {
        $f = fopen(F_SOCIOS, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(' ',$linea);
            $nomUser=$lineaSeccionada[0];
            // Comprobamos si se ha encontrado al usuario
            if($nomUser==$user)
            {
                $dctoUser=$lineaSeccionada[2];
                fclose($f);
                return $dctoUser;
            }
        }
        fclose($f);
        return -1;
    }
}

function damePlatos($tipo)
{
    $platoPrecio=[];

    if(file_exists(F_PLATOS))
    {
        $f = fopen(F_PLATOS, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(' ',$linea);
            $tipoPlato=$lineaSeccionada[1];
            // Comprobamos si el tipo de plato es igual al deseado
            if($tipoPlato==$tipo)
            {
                $nomPlato=$lineaSeccionada[0];
                $precioPlato=$lineaSeccionada[2];
                $platoPrecio[$nomPlato]=$precioPlato;
            }
        }
        fclose($f);
    }
    return $platoPrecio;
}

function damePrecio($plato)
{
    if(file_exists(F_PLATOS))
    {
        $f = fopen(F_PLATOS, "r");
        while(!feof($f)) 
        {
            $linea = fgets($f); 
            $lineaSeccionada=explode(' ',$linea);
            $nomPlato=$lineaSeccionada[0];
            // Comprobamos si el nombre del plato es igual al deseado
            if($nomPlato==$plato)
            {
                $precioPlato=$lineaSeccionada[2];
                fclose($f);
                return $precioPlato;
            }
        }
        fclose($f);
    }
    return -1;
}
?>