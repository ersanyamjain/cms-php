<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php find_selected_page(); ?>
<?php 
if( !$current_page)
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
	$sub_id=(int)$current_page["subject_id"];
	$id=(int)$current_page["id"];
	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=(int)$_POST["position"];
	$visible=(int)$_POST["visible"];
	$content=mysql_prep($_POST["content"]);
	
	$query="update pages set ";
	$query.="menu_name='{$menu_name}',";
	$query.="position={$position},";
	$query.="visible={$visible},";
	$query.="content='{$content}' ";
	$query.="where id={$id} ";
	$query.="limit 1";
	$result = mysqli_query($connection,$query);

		if($result && mysqli_affected_rows($connection)>=0)
		{
			$_SESSION["message"]="Page updated.";
			redirect_to("manage-content.php");
		}
		else
		{
			$message="Page updation failed.";
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
<h2>Edit Page <?php echo htmlentities($current_page["menu_name"]); ?></h2>
<form action="edit-page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
<p> Menu Name:
<input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
</p>
<p>
Position:
<select name="position">
<?php
$page_set=find_all_pages($current_page["subject_id"],false);
$page_count=mysqli_num_rows($page_set);
for($count=1;$count<=$page_count;$count++)
{
	
	echo "<option value=\"{$count}\"";
	if($current_page["position"]==$count)
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
<?php if($current_page["visible"]==1)
{
	echo " checked";
}	?>/> Yes 
<input type="radio" name="visible" value="0" 
<?php if($current_page["visible"]==0)
{
	echo " checked";
}	?>/> No </p>
Content:
<br><br>
<textarea rows="8" cols="100" name="content"><?php echo htmlentities($current_page["content"]); ?></textarea>
<br><br>
<input type="submit" name="submit" value="Update Page" />
</form>
<br>
<a href="manage-content.php?page=<?php echo $current_page["id"]; ?>">Cancel</a>
&nbsp;
&nbsp;
<a href="delete-page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure ?');">Delete Page</a>
</div>
</div>
<?php 
if(isset($connection))
{
	mysqli_close($connection);
}
?>
<?php include("../includes/layouts/footer.php"); ?>