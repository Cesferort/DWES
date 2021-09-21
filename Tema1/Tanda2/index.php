<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Ejercicios Tanda 2</h1>
    </header>
    <ul>
        <?php
            $directories=scandir('./');
            foreach($directories as $dir)
            {
                if(is_dir($dir))
                {
                    $url='./'.$dir;
                    $files=scandir($url);
                    $nEjercicio=1;
                    foreach($files as $f)
                    {
                        $url.='/'.$f;
                        if(is_file($url) and $f!='index.php')
                        {
                            echo '<li><a href="'.$url.'">Ejercicio '.$nEjercicio.'</a></li>';
                            $nEjercicio++;
                        }
                    } 
                }
            }
        ?>
    </ul>
</body>
</html>