<?php 
define("DB_SERVER","localhost");
define("DB_USER","primia_cms");
define("DB_PASS","secret");
define("DB_NAME","primia_tech");

$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(mysqli_connect_errno())
{
	die("Database Connection Failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}

?>