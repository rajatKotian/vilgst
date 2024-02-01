<?php 
require_once 'conn.php';

if(isset($_POST['txtEmail'])) {	

	$txtEmail = mysqli_real_escape_string($GLOBALS['con'],stripslashes($_POST['txtEmail']));

	$sql = "SELECT username FROM userlogins WHERE email_id = '$txtEmail'";

	$result=mysqli_query($GLOBALS['con'],$sql);
	$row = mysqli_fetch_object($result);
	$count=mysqli_num_rows($result);
	//print_r($count);
	if($count==1) {
		echo 'available';
	} else {
		echo 'notAvailable';
	}
	  
} else {

	header('Location:index.php');
}
?>