<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db-connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="navigation"> 
<br><a href="admin.php"> &laquo; Main menu </a> <br>

 </div>
<div id="page">
<?php echo message(); ?>
<h2> Manage Admins </h2>
<table>
<tr>
<th style="text-align:left;width:200px;"> Username  </th>
<th colspan="2" style="text-align:left;">Actions</th>
</tr>
<?php 
$admin_set=find_all_admins();
while($admin=mysqli_fetch_assoc($admin_set))
{
	echo "<tr><td>";
	echo $admin["username"];
	echo "</td><td><a href=\"edit-admin.php?admin=";
	echo urlencode($admin["id"]); 
	echo "\">";
	echo "Edit";
	echo "</a></td><td>";
	echo "<a href=\"delete-admin.php?admin=";
	echo urlencode($admin["id"]); 
	echo "\" onclick=\"return confirm('Are you sure ?');\">";
	echo "Delete";
	echo "</a>";
	echo "</td></tr>";

}
?>
</table>
<br><br>
	<a href="new-admin.php">
	Add new Admin
	</a>
	</div> </div>
<?php 
include("../includes/layouts/footer.php"); ?>