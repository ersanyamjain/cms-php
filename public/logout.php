<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php 
//Simple Method
$_SESSION["admin_id"]=null;
$_SESSION["username"]=null;
$_SESSION["message"]="Logged out successfully.";
redirect_to("login.php");
?>

<?php 
/* Destroy Session
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()]))
{
	setcookie(session_name(),' ',time()-4000,'/');
}
session_destroy();
redirect_to("login.php");

*/
?>