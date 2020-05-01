<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context="admin"; ?>
<?php 

$current_admin=find_admin_by_id($_GET["admin"]);
if(!$current_admin)
{
	redirect_to("manage-admins.php");
}
?>
<?php $check= htmlentities($current_admin["username"]);  ?>
<?php 
if(isset($_POST['submit']))
{
$required_fields=array("username","password");
validate_presences($required_fields);	
$fields_with_max_lenghths=array("username"=>20,"password"=>20);
validate_max_lengths($fields_with_max_lenghths);
if($_POST["username"]!=$check )
{
verify_new_admin($_POST["username"]);
}
	if(empty($errors))
	{
	
	$username=mysql_prep($_POST["username"]);
	$password=password_encrypt($_POST["password"]);
	$id=(int)$_GET["admin"];
$query="update admins set ";
$query.="username='{$username}',";
$query.="hashed_password='{$password}' ";
$query.="where id={$id} ";
$result = mysqli_query($connection,$query);
		if($result)
		{
			$_SESSION["message"]="Admin updated.";
			redirect_to("manage-admins.php");
		}
		else
		{
			$message="Admin updation failed.";
		}

	}
}

?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
<div id="navigation"> &nbsp; </div>
<div id="page">
<?php 
if(!empty($message))
{
echo "<div class=\"message\">".htmlentities($message)."</div>";	
}	?>

<?php echo "<br>".form_errors($errors); ?>

<h2> Edit Admin <?php echo htmlentities($current_admin["username"]); ?></h2>
<br>
<form action="edit-admin.php?admin=<?php echo urlencode($current_admin["id"]); ?>" method=post>
Username:<input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]);  ?>">
<br><br>
Password:<input type="password" name="password"> 
<br><br>
<input type="submit" name="submit" value="Update Admin">
</form>
<br>
<a href="manage-admins.php">Cancel</a>
 </div> </div>
<?php 
if(isset($connection))
{
	mysqli_close($connection);
}
?>
<?php include("../includes/layouts/footer.php"); ?>