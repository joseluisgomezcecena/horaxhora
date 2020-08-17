<<<<<<< HEAD
<?php

define("DB_HOST", "localhost");
define("DB_NAME", "hourxhour");
define("DB_USER", "root");
=======
<<<<<<< HEAD
<?php

define("DB_HOST", "192.168.7.133");
define("DB_NAME", "hourxhour");
define("DB_USER", "jgomez");
>>>>>>> 8dbb99249631c430cf73c435d9d5ae55a302889a
define("DB_PASS", "");

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_errno) 
{
    echo "Error al conectar a Base de datos";
}

<<<<<<< HEAD
?>
=======
>>>>>>> 8dbb99249631c430cf73c435d9d5ae55a302889a
