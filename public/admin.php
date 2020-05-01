<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="navigation"> <br>
<ul> <li> <a href="manage-content.php">Manage Website Content </a> </li> <br>
<li> <a href="manage-admins.php"> Manage Admin Users </a> </li><br>
<li> <a href="logout.php"> Logout </a> </li>
</ul>  </div>
<div id="page">
<h2> Admin Menu </h2>
<p> Welcome to the Admin Area, <b><?php echo htmlentities($_SESSION["username"]); ?></b>!</p>
<ul> <li> <a href="manage-content.php">Manage Website Content </a> </li> 
<li> <a href="manage-admins.php"> Manage Admin Users </a> </li>
<li> <a href="logout.php"> Logout </a> </li>
</ul> </div> </div>
<?php 
include("../includes/layouts/footer.php"); ?>