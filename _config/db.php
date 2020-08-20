
<?php

define("DB_HOST", "localhost");
define("DB_NAME", "hourxhour");
define("DB_USER", "root");
define("DB_PASS", "");

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_errno) 
{
    echo "Error al conectar a Base de datos";
}

