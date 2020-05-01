<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(true); ?>

<div id="main">
<div id="navigation"><br>
<?php echo public_navigation($current_subject,$current_page); ?> 
</div>
<div id="page">
<?php if($current_page)
{
	?>
	<h2><?php echo htmlentities($current_page["menu_name"]); ?> </h2>
<?php echo nl2br(htmlentities($current_page["content"])); ?>
</div>
<?php }
else
{
	?>
<h2> Welcome !</h2>
	<?php 
}
?>
</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>