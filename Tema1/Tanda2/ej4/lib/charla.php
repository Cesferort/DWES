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

?>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table>
            <tr>
                <td colspan=2>Usuario:</td>
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
    </form>
</body>
</html>