<?php 
	// Host, usuario y contraseña para acceso al servidor MySQL
    define("DB_HOST" , "localhost");
    define("DB_USER" , "root");
    define("DB_PASSWORD" , "");
	
	// Nombre de la base de datos en MySQL
    define("DB" , "subastas");
	
	// Nombre del foro de subastas
	define("FORUM_TITLE","Subastas.com");
	
	// Ruta base de la aplicación
    define("BASE_ROUTE", "http://" . $_SERVER['SERVER_NAME']."/DWES_II/php/UD5/");
	
	// Moneda local
    define("CURRENCY","€");

	// Ruta de carpeta de imágenes
    define("DIR_IMAGES",BASE_ROUTE."images/");