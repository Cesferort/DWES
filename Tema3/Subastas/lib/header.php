<html><head><title><?php echo $config_forumsname; ?></title>
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
</head>
<body>
    <div id="header">
        <h1>SUBASTAS CIUDAD JARDIN</h1>
    </div>
    <div id="menu">
        <a href="index.php">Home</a>
        <?php
            if(isset($_SESSION['USERNAME']) == TRUE) {
                echo "<a href='logout.php'>Logout</a>";
            }
            else {
                echo "<a href='login.php'>Login</a>";
            }
        ?>
        <a href="newitem.php">New Item</a>
    </div>
    <div id="container">
        <div id="bar">
               <?php require("bar.php"); ?>
        </div>
        <div id="main">