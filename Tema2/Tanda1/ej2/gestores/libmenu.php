<?php
define('F_PLATOS','../files/platos.txt');
define('F_SOCIOS','../files/socios.txt');

/**
 * Este método comprueba si un usuario y contraseña recibidas como parámetro
 * son correctas.
 * @param string $user nombre del usuario a autenticar
 * @param string $password contraseña del usuario a autenticar
 * @return int devuelve un valor numérico que representa si los datos son válidos (1) o no (0)
 */
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

/**
 * Este método devuelve el descuento asociado al usuario cuyo nombre recibe
 * como parámetro.
 * @param string $user nombre del usuario
 * @return int devuelve el descuento del usuario recibido como parámetro
 */
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
        return 0;
    }
}

/**
 * Este método devuelve un array de platos cuyo tipo es igual al recibido
 * como parámetro.
 * @param string $tipo tipo de plato a buscar
 * @return string[] colección de platos del tipo pasado como parámetro
 */
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

/**
 * Este método devuelve el precio del plato pasado como parámetro.
 * @param string $plato nombre del plato a buscar
 * @return int precio del plato pasado como parámetro
 */
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
    return 0;
}
?>