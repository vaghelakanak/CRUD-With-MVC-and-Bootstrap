<?php 
require "class.php";

$newClass = new db_class();
$resultData = $newClass->deleteUser($_REQUEST['id']);
if($resultData == 1)
{
	echo '<script>window.location= "listing.php?success=1"</script>';
}
else
{
	echo '<script>window.location= "listing.php?success=0"</script>';
}
?>