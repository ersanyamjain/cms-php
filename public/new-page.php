<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation-functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php find_selected_page(); ?>

<?php 

if(isset($_POST['submit']))
{
$required_fields=array("menu_name","position","visible","content");
validate_presences($required_fields);	
$fields_with_max_lenghths=array("menu_name"=>30);
validate_max_lengths($fields_with_max_lenghths);

	if(empty($errors))
	{
	$subject_id=(int)$current_subject["id"];
	$menu_name=mysql_prep($_POST["menu_name"]);
	$position=(int)$_POST["position"];
	$visible=(int)$_POST["visible"];
	$content=mysql_prep($_POST["content"]);
	
$query="insert into pages(";
$query.="menu_name,position,visible,content,subject_id";
$query.=") values('{$menu_name}',{$position},{$visible},'{$content}',{$subject_id})";
$result = mysqli_query($connection,$query);
		if($result)
		{
			$_SESSION["message"]="Page created.";
			redirect_to("manage-content.php?subject={$current_subject["id"]}");
		}
		else
		{
			$message="Page creation failed.";
			$subject_id=$current_subject["id"];
		}

	}
	else
	{
	$subject_id=$current_subject["id"];
	}
}
 else
 {
$subject_id=$_GET['subject'];		 
 }
?>
<?php $layout_context="admin"; ?>

<?php include("../includes/layouts/header.php"); ?>
<div id="main">
<div id="navigation"><br>
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
<h2>Create Page</h2>
<form action="new-page.php?subject=<?php echo $current_subject["id"]; ?>" method="post">
<p> Menu Name:
<input type="text" name="menu_name" value="" />
</p>
<p>
Position:
<select name="position">
<?php
$page_set=find_all_pages($subject_id,false); 
$page_count=mysqli_num_rows($page_set);
for($count=1;$count<=($page_count+1);$count++)
{
echo "<option value=\"{$count}\">{$count}</option>";
}
?>
</select>
</p>
<p>
Visible:
<input type="radio" name="visible" value="1" /> Yes 
<input type="radio" name="visible" value="0" /> No </p>
Content:
<br><br>
<textarea rows="8" cols="100" name="content"></textarea> 
<br><br>
<input type="submit" name="submit" value="Create Page" />
</form>

<a href="manage-content.php?subject=<?php echo $current_subject["id"]; ?>">
Cancel</a>
</div>
</div>


<?php include("../includes/layouts/footer.php"); ?>