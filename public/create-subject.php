<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>

<?php
if(isset($_POST['submit']))
{
	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=(int)$_POST["position"];
	$visible=(int)$_POST["visible"];
	
$required_fields=array("menu_name","position","visible");
validate_presences($required_fields);	
$fields_with_max_lenghths=array("menu_name"=>30);
validate_max_lengths($fields_with_max_lenghths);

if(!empty($errors))
{
	$_SESSION["errors"]=$errors;
	redirect_to("new-subject.php");
}

$query="insert into subjects(";
$query.="menu_name,position,visible";
$query.=") values('{$menu_name}',{$position},{$visible})";
$result = mysqli_query($connection,$query);

if($result)
{
	$_SESSION["message"]="Subject created.";
	redirect_to("manage-content.php");
}
else
{
	$_SESSION["message"]="Subject creation failed.";
	redirect_to("new-subject.php");
}

}
else
{
redirect_to("new-subject.php");
}

?>
<?php 
if(isset($connection))
{
	mysqli_close($connection);
}
?>