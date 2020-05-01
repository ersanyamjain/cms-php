<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>

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
<?php echo message(); ?>
<?php $errors=errors(); ?>
<?php echo "<br>".form_errors($errors); ?>
<h2>Create Subject</h2>
<form action="create-subject.php" method="post">
<p> Menu Name:
<input type="text" name="menu_name" value="" />
</p>
<p>
Position:
<select name="position">
<?php
$subject_set=find_all_subjects(false);
$subject_count=mysqli_num_rows($subject_set);
for($count=1;$count<=($subject_count+1);$count++)
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
<input type="submit" name="submit" value="Create Subject" />
</form>
<br>
<a href="manage-content.php">
Cancel</a>
</div>
</div>


<?php include("../includes/layouts/footer.php"); ?>