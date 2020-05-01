<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php
$current_subject=find_subject_by_id($_GET["subject"],false);
if(!$current_subject)
{
	redirect_to("manage-content.php");
}
$pages_set=find_all_pages($current_subject["id"],false);
if(mysqli_num_rows($pages_set)>0)
{
	$_SESSION["message"]="Can't delete a subject with pages";
	redirect_to("manage-content.php?subject={$current_subject["id"]}");
}

$id=$current_subject["id"];
$query="Delete from subjects where id={$id} limit 1";
$result=mysqli_query($connection,$query);
if($result && mysqli_affected_rows($connection)==1)
{
		$_SESSION["message"]="Subject deleted.";
			redirect_to("manage-content.php");
}
else
{
		$_SESSION["message"]="Subject deletion failed.";
		redirect_to("manage-content.php?subject={$id}");
}
?>
