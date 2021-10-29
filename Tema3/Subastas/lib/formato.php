<?php
/**
 * Aplica el formato correcto al dinero recibido como parámetro. Se busca mostrar siempre los
 * valores decimales a pesar de ser igual a 0. Además, se concatenará la moneda que se esté 
 * utilizando.
 * @param double $money             Valor numérico que representa una cantidad de dinero
 * @return string                   Dinero con el formato correcto aplicado
 */
function formatMoney($money)
{
    // Convertirmos el valor recibido a texto y lo seccionamos para trabajar con sus partes
    $moneySeccionado=explode('.', "".$money);
    $parteEntera=$moneySeccionado[0];

    // El número podría no tener parte decimal. Comprobamos si ese es el caso
    if(count($moneySeccionado) <= 1)
        $parteDecimal="00";
    else
    {
        $parteDecimal=$moneySeccionado[1];
        if(strlen($parteDecimal) < 2)
            $parteDecimal.="0";
    }  
    return $parteEntera.".".$parteDecimal.CURRENCY;
}

/**
 * Aplica el formato correcto a la fecha recibida como parámetro. 
 * @param string $date              Valor textual que representa una fecha
 * @return string                   Fecha con el formato correcto aplicado
 */
function formatDate($date)
{
    // Convertimos el valor textual recibido en una fecha y aplicamos el formato correcto
    $date = new DateTime($date); 
    return $date -> format('d/M/Y h:iA');
}
?>