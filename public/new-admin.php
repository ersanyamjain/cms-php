<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context="admin"; ?>

<?php 

if(isset($_POST['submit']))
{
$required_fields=array("username","password");
validate_presences($required_fields);	
$fields_with_max_lenghths=array("username"=>20,"password"=>20);
validate_max_lengths($fields_with_max_lenghths);
verify_new_admin($_POST["username"]);
	if(empty($errors))
	{
	
	$username=mysql_prep($_POST["username"]);
	$hashed_password=password_encrypt($_POST["password"]);
	
$query="insert into admins(";
$query.="username,hashed_password";
$query.=") values('{$username}','{$hashed_password}')";
$result = mysqli_query($connection,$query);
		if($result)
		{
			$_SESSION["message"]="Admin created.";
			redirect_to("manage-admins.php");
		}
		else
		{
			$message="Admin creation failed.";
		}

	}
}

?>


<?php include("../includes/layouts/header.php"); ?>

<div id="navigation"> &nbsp; </div>
<div id="page">
<?php 
if(!empty($message))
{
echo "<div class=\"message\">".htmlentities($message)."</div>";	
}	?>

<?php echo "<br>".form_errors($errors); ?>
<h2> Create Admin </h2>
<br>
<form action="new-admin.php" method=post>
Username:<input type="text" name="username" value="">
<br><br>
Password:<input type="password" name="password"> 
<br><br>
<input type="submit" name="submit" value="Create Admin">
</form>
<br>
<a href="manage-admins.php">Cancel</a>
 </div> </div>
<?php 
include("../includes/layouts/footer.php"); ?>