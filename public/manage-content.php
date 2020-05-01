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


<?php echo navigation($current_subject,$current_page); ?> 

<a href="new-subject.php">
+ Add a Subject </a>
</div>
<div id="page">
<?php echo message(); ?>
<?php if($current_subject)
{
?>
<h2> Manage Subject </h2>	
Menu name: <?php echo htmlentities($current_subject["menu_name"]); ?>
<br>
Position: <?php echo $current_subject["position"]; ?>
<br>
Visible: <?php echo $current_subject["visible"]==1?'Yes':'No'; ?>
<br>
<a href="edit-subject.php?subject=<?php echo $current_subject["id"];?>"> Edit Subject </a>
<br><br>

<?php echo page_list_by_subject($current_subject); ?>
+ <a href="new-page.php?subject=<?php echo $current_subject["id"]; ?>">Create a new page</a>
<?php 
}
elseif($current_page)
{
	?>
<h2> Manage Page </h2>
Menu name: <?php echo htmlentities($current_page["menu_name"]); ?>
<br>
Position: <?php echo $current_page["position"]; ?>
<br>
Visible: <?php echo $current_page["visible"]==1?'Yes':'No'; ?>
<br>
Content: <br>
<div class="view-content">
<?php echo htmlentities($current_page["content"]); ?>
</div>
<a href="edit-page.php?page=<?php echo $current_page["id"];
?>"> Edit Page </a>
<br><br>
<?php }
else
{
	?>
	<h2> Manage Content </h2>
	Please select a subject or page
	<?php 
}
?>
</div>
</div>


<?php include("../includes/layouts/footer.php"); ?>