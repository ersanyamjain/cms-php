<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context="admin"; ?>
<?php
$current_admin=find_admin_by_id($_GET["admin"]);
if(!$current_admin)
{
	redirect_to("manage-admins.php");
}

$id=$current_admin["id"];
$query="Delete from admins where id={$id} limit 1";
$result=mysqli_query($connection,$query);
if($result && mysqli_affected_rows($connection)==1)
{
		$_SESSION["message"]="Admin deleted.";
			redirect_to("manage-admins.php");
}
else
{
		$_SESSION["message"]="Admin deletion failed.";
		redirect_to("manage-admins.php");
}
?>
