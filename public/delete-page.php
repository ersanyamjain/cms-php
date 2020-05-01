<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php
$current_page=find_page_by_id($_GET["page"],false);
if(!$current_page)
{
	redirect_to("manage-content.php");
}


$id=$current_page["id"];
$query="Delete from pages where id={$id} limit 1";
$result=mysqli_query($connection,$query);
if($result && mysqli_affected_rows($connection)==1)
{
		$_SESSION["message"]="Page deleted.";
			redirect_to("manage-content.php");
}
else
{
		$_SESSION["message"]="Page deletion failed.";
		redirect_to("manage-content.php?page={$id}");
}
?>
