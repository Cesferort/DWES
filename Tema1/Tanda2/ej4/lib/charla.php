<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>EJ4</title>
</head>
<body>
<?php
define("CHAT_CONTENT", "../files/contenidoChat.txt");
if(isset($_GET['nomUser']))
    $nomUser=$_GET['nomUser'];
else if(isset($_POST['nomUser']))
    $nomUser=$_POST['nomUser'];

if(isset($_POST['sendMsg']))
{
    $txtMsg=$_POST['txtMsg'];
    if(isset($_POST['txtMsg']) && $txtMsg!='')
    {
        sendMsg($nomUser,$txtMsg);
    }
}

function sendMsg($nomUser,$txtMsg)
{
    if(file_exists(CHAT_CONTENT))
    {
        $f = fopen(CHAT_CONTENT, "a");

        $linea="\n".$nomUser.": ".$txtMsg;
        fwrite($f, $linea); 

        fclose($f);
        return true;
    }
    return false;
}
?>
    <iframe src="./contenido_charla.php"></iframe>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td colspan=2>Usuario: <strong><?php echo $nomUser;?></strong></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="txtMsg">
                </td>
                <td>
                    <input type="submit" value="Enviar" name="sendMsg">
                </td>
            </tr>
        </table>
        <input type="hidden" name="nomUser" value="<?php echo $nomUser;?>">
    </form>
</body>
</html>