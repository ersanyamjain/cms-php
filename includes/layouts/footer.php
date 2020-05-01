<div id="footer"> Copyright <?php echo date("Y"); ?>. Primia Technologies </div>
</body>
</html>
<?php
if(isset($connection))
{
mysqli_close($connection);
}
?>