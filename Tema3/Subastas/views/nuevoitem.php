<?php
require_once "cabecera.php";
require_once "../BD/gestorBD_categoria.php";
require_once "../BD/gestorBD_item.php";

$_SESSION["puntoPartida"]="./nuevoitem.php";
// No se permite el uso de la página a usuarios que no hayan iniciado sesión
if(!isset($_SESSION['nomUser']) || !isset($_SESSION['idUser'])) 
    header("Location: ./login.php");

// Recuperamos todas las categorias encontradas en la base de datos
$listaCategories=getCategories($conn);

// Valores lógicos que utilizaremos para comprobar el resultado de diferentes validaciones
$nomItemValido=true;
$fechaValida=true;
$precioValido=true;
// Comprobamos si el usuario ha deseado crear un nuevo item
if(isset($_POST["enviarNuevoItem"]))
{
    $selectCategoria=$_POST["selectCategoria"];
    $categoryFound=false;
    for($i=0; $i < count($listaCategories) && $categoryFound == false; $i++)
    {
        // Recuperamos identificador y nombre de la categoría escogida
        $idCategory=$listaCategories[$i]["id"];
        $nomCategory=$listaCategories[$i]["categoria"];
        if($nomCategory == $selectCategoria)
            $categoryFound=true;
    }
    $nomItem=$_POST["nomItem"];
    $descItem=$_POST["descItem"];

    $selectDiaFin=$_POST["selectDiaFin"];
    $selectMesFin=$_POST["selectMesFin"];
    $selectAnioFin=$_POST["selectAnioFin"];
    $selectHoraFin=$_POST["selectHoraFin"];
    $selectMinFin=$_POST["selectMinFin"];
    $fechaFin="$selectAnioFin-$selectMesFin-$selectDiaFin $selectHoraFin:$selectMinFin:00";;

    $precioItem=$_POST["precioItem"];

    // Validamos que el usuario no haya metido un nombre de item vacío
    if($nomItem == "")
        $nomItemValido=false;

    $anioActual=date("Y");
    $mesActual=date("m");
    $diaActual=date("d");
    $horaActual=date("H");
    $minActual=date("i");
    
    // Validamos fecha
    if($anioActual == $selectAnioFin)
    {
        if($mesActual > $selectMesFin)
            $fechaValida=false;
        elseif($mesActual == $selectMesFin)
        {
            if($diaActual > $selectDiaFin)
                $fechaValida=false;
            elseif($diaActual == $selectDiaFin)
            {
                if($horaActual > $selectHoraFin)
                    $fechaValida=false;
                elseif($horaActual == $selectHoraFin)
                {
                    if($minActual >= $selectMinFin)
                        $fechaValida=false;
                }
            }
        }
    }

    // Validamos precio del item
    if(!is_numeric($precioItem))
        $precioValido=false;

    // En caso de que todos los datos hayan sido validados correctamente procedemos a insertar
    // el nuevo item en la base de datos y redirigimos al usuario
    if($nomItemValido == true && $fechaValida == true && $precioValido ==true)
    {
        $idItem=addItem($conn, $idCategory, $_SESSION["idUser"], $nomItem, $precioItem, $descItem, $fechaFin);
        header("Location: ./editaritem.php?idItem=$idItem");
    }
}
?>
<body>
    <h2>Añade nuevo item</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <table>
            <tr>
                <td>Categoría</td>
                <td>
                    <select name="selectCategoria" id="selectCategoria">
                        <?php
                        for($i=0; $i < count($listaCategories); $i++)
                        {
                            $idCategory=$listaCategories[$i]["id"];
                            $nomCategory=$listaCategories[$i]["categoria"];
                            echo "<option>$nomCategory</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input type="text" name="nomItem" id="nomItem">
                    <?php
                    if($nomItemValido == false)
                        echo "<p style='color:red'>Campo vacío</p>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>Descripción</td>
                <td><textarea name="descItem" id="descItem" cols="30" rows="10" maxlength="200"></textarea></td>
            </tr>
            <tr>
                <td>Fecha de fin para pujas</td>
                <td>
                    <table>
                        <tr>
                            <td>Día</td>
                            <td>Mes</td>
                            <td>Año</td>
                            <td>Hora</td>
                            <td>Minutos</td>
                        </tr>
                        <tr>
                            <td><select name="selectDiaFin" id="selectDiaFin">
                                <?php for($i=1; $i <= 31; $i++) echo "<option>$i</option>";?>
                            </select></td>
                            <td><select name="selectMesFin" id="selectMesFin">
                                <?php for($i=1; $i <= 12; $i++) echo "<option>$i</option>";?>
                            </select></td>
                            <td><select name="selectAnioFin" id="selectAnioFin">
                                <?php 
                                $anioActual=date("Y");; 
                                for($i=$anioActual; $i <= $anioActual+5; $i++) 
                                    echo "<option>$i</option>";
                                ?>
                            </select></td>
                            <td><select name="selectHoraFin" id="selectHoraFin">
                                <?php for($i=0; $i <= 23; $i++) echo "<option>$i</option>";?>
                            </select></td>
                            <td><select name="selectMinFin" id="selectMinFin">
                                <?php for($i=0; $i <= 59; $i++) echo "<option>$i</option>";?>
                            </select></td>
                        </tr>
                    </table>
                    <?php
                    if($fechaValida == false)
                        echo "<p style='color:red'>La fecha de fin no puede ser anterior o igual a la fecha actual</p>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>Precio</td>
                <td><input type="text" name="precioItem" id="precioItem"><?php echo CURRENCY;?>
                <?php
                if($precioValido == false)
                    echo "<p style='color:red'>El valor debe ser numérico</p>";
                ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input style="width:100%" type="submit" name="enviarNuevoItem" id="enviarNuevoItem" value="¡Enviar!"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<?php require_once "./footer.php" ?>