<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php find_selected_page(); ?>
<?php 
if(!$current_subject)
{
redirect_to("manage-content.php");	
}
?>

<?php 
if(isset($_POST['submit']))
{
$required_fields=array("menu_name","position","visible");
validate_presences($required_fields);	
$fields_with_max_lenghths=array("menu_name"=>30);
validate_max_lengths($fields_with_max_lenghths);

	if(empty($errors))
	{
	$id=$current_subject["id"];
	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=(int)$_POST["position"];
	$visible=(int)$_POST["visible"];
	
	$query="update subjects set  ";
	$query.="menu_name='{$menu_name}',";
	$query.="position={$position},";
	$query.="visible={$visible} ";
	$query.="where id={$id} ";
	$query.="limit 1";
	$result = mysqli_query($connection,$query);

		if($result && mysqli_affected_rows($connection)>=0)
		{
			$_SESSION["message"]="Subject updated.";
			redirect_to("manage-content.php");
		}
		else
		{
			$message="Subject updation failed.";
		}
	}
	else
	{
			
	}
}
?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
<div id="navigation">
<br>
<a href="admin.php"> &laquo; Main menu </a> <br>
<?php
echo navigation($current_subject,$current_page);
?> 
<b>
<a href="new-subject.php">
+ Add a Subject </a>
</b></div>
<div id="page">
<?php 
if(!empty($message))
{
echo "<div class=\"message\">".htmlentities($message)."</div>";	
}	?>

<?php echo "<br>".form_errors($errors); ?>
<h2>Edit Subject <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
<form action="edit-subject.php?subject=<?php echo urlencode($current_subject["id"]);?>"method="post">
<p> Menu Name:
<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" />
</p>
<p>
Position:
<select name="position">
<?php
$subject_set=find_all_subjects(false);
$subject_count=mysqli_num_rows($subject_set);
for($count=1;$count<=$subject_count;$count++)
{
	
	echo "<option value=\"{$count}\"";
	if($current_subject["position"]==$count)
	{
		echo " selected";
	}
	echo ">{$count}</option>";
}
?>
</select>
</p>
<p>
Visible:
<input type="radio" name="visible" value="1" 
<?php if($current_subject["visible"]==1)
{
	echo " checked";
}	?>/> Yes 
<input type="radio" name="visible" value="0" 
<?php if($current_subject["visible"]==0)
{
	echo " checked";
}	?>/> No </p>
<input type="submit" name="submit" value="Update Subject" />
</form>
<br>
<a href="manage-content.php?subject=<?php echo $current_subject["id"]; ?>">Cancel</a>
&nbsp;
&nbsp;
<a href="delete-subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure ?');">Delete Subject</a>
</div>
</div>
<?php 
if(isset($connection))
{
	mysqli_close($connection);
}
?>
<?php include("../includes/layouts/footer.php"); ?>