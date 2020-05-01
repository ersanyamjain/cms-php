<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php $layout_context="admin"; ?>

<?php 
$username="";

if(isset($_POST['submit']))
{
$required_fields=array("username","password");
validate_presences($required_fields);	

	if(empty($errors))
	{
	//attempt login
	$username=$_POST["username"];
	$password=$_POST["password"];
$found_admin=attempt_login($username,$password);
		if($found_admin)
		{
			$_SESSION["admin_id"]=$found_admin["id"];
			$_SESSION["username"]=$found_admin["username"];
			redirect_to("admin.php");
		}
		else
		{
			$_SESSION["message"]="Username/Password not found.";
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
<?php echo message(); ?>
<?php echo form_errors($errors); ?>
<h2> Please Login </h2>
<br>
<form action="login.php" method=post>
Username:<input type="text" name="username" value="<?php echo htmlentities($username); ?>">
<br><br>
Password:<input type="password" name="password"> 
<br><br>
<input type="submit" name="submit" value="Sign in">
</form>
 </div> </div>
<?php 
include("../includes/layouts/footer.php"); ?>