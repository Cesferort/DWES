<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_item.php";

// Recuperamos subastas casi vencidas
$subastasCasiVencidas=getAlmostExpiredItems($conn);

// Comprobamos si el usuario ha deseado añadir publicidad a alguna de las subastas
for($i=0; $i < count($subastasCasiVencidas); $i++)
{
    $butAniadir="aniadir_$i";
    if(isset($_POST[$butAniadir]))
    {
        if(!isset($_SESSION["listaPublicidad"]))
            $_SESSION["listaPublicidad"]=[];

        $anunciante=$_POST["anunciante_$i"];
        $tipo=$_POST["tipo_$i"];
        $idItem=$_POST["idItem_$i"];
        $descItem=$_POST["descItem_$i"];
        $enlace=BASE_ROUTE."views/itemdetalles.php?idItem=$idItem";
        $_SESSION["listaPublicidad"][]=[$anunciante, $tipo, $enlace, $descItem];
    }
}

// Comprobamos si el usuario desea realizar todos los anuncios añadidos a la colección
if(isset($_POST["enviarAnuncios"]))
{
    $listaPublicidad=$_SESSION["listaPublicidad"];
    for($i=0; $i < count($listaPublicidad); $i++)
    {
        $publicidad=$listaPublicidad[$i];
        $anunciante=$publicidad[0];
        $tipo=$publicidad[1];
        $enlace=$publicidad[2];
        $descItem=$publicidad[3];

        if($tipo == 0)          // Email
        {
            $msg=<<<MAIL
                        Hola, haznos publicidad de esta mierda:
                        $enlace
                        Gracias
                    MAIL;
        
            $subject  = "Publicidad de ".FORUM_TITLE;
            $headers  = 'From: phpalas4am@gmail.com' . "\r\n" .
                        'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=utf-8';
            mail($anunciante, $subject, $msg, $headers);
        }
        else                    // Web
        {
            $linea="\nWeb: $anunciante Descripción del item: $descItem";
            $f = fopen("../lib/anunciantes.txt", "a");
            fwrite($f, $linea);

            fclose($f);
        }
    }
    $_SESSION["listaPublicidad"]=[];
}
?>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <h2>Subastas a punto de vencer</h2>
        <table>
            <tr>
                <td>ITEM</td>
                <td>VENCE EN</td>
                <td>ANUNCIANTE</td>
                <td colspan="2">TIPO</td>
            </tr>
            <?php
            for($i=0; $i < count($subastasCasiVencidas); $i++)
            {
                $item=$subastasCasiVencidas[$i];
                $idItem=$item["id"];
                $descItem=$item["descripcion"];
                $nomItem=$item["nombre"];
                $fechaFin=$item["fechafin"];

                $dateObject=new DateTime(); 
                $otherDateObject=new DateTime($fechaFin);
                $diffObject=$dateObject -> diff($otherDateObject); 
                
                $diferenciaDias=$diffObject -> days;
                $diferenciaHoras=$diffObject -> h;
                $tiempoRestante=$diferenciaDias*24 + $diferenciaHoras;

                $html="<tr>";
                $html.="<td>$nomItem<input type='hidden' value='$idItem' name='idItem_$i'><input type='hidden' value='$descItem' name='descItem_$i'></td>";
                $html.="<td>$tiempoRestante horas</td>";
                $html.="<td><input type='text' name='anunciante_$i'></td>";
                $html.="<td>";
                $html.="<input type='radio' value='0' name='tipo_$i' checked>Email";
                $html.="<input type='radio' value='1' name='tipo_$i'>Web";
                $html.="</td>";
                $html.="<td><input type='submit' name='aniadir_$i' value='Añadir'></td>";
                $html.="</tr>";
                echo $html;
            }  
            if(isset($_SESSION["listaPublicidad"]))
                echo "<tr><td colspan='5'><input style='width:100%' type='submit' name='enviarAnuncios' value='ENVIAR ANUNCIOS'></td></tr>"; 
            ?>
        </table>
        <?php
        ?>
    </form>
</body>
</html>
<?php require_once "./footer.php" ?>