<?php session_start();
ob_start(); 
ini_set('display_errors',0);
$db_host = 'localhost';
include_once('mysql2i.class.php');
// include_once 'header.php';

// $db_user = 'root';
// $db_pwd = '';
// $database = 'vilgst12_vilgstprod';
 
$db_pwd = '123456';
$db_user = 'root';
$database = 'vilgstnewmay_vilgstprod';

// $db_pwd = 'Tjew7=Ag)OuO';
// $db_user = 'vilgst12_new';
// $database = 'vilgst12_vilgstprod';


$con=mysqli_connect($db_host, $db_user, $db_pwd,$database);
if (!$con) {
	die("Can't connect to database");
}   

// if (!mysqli_select_db($con,$database)) {
// 	die("Can't select database");
// }    

if(isset($_SESSION['user'])) {
	if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {  

	$_SESSION['status']='out';
	header('Location: logout.php'); //redirect to logout.php 
	} else {  
		$_SESSION['last_activity'] = time(); //this was the moment of last activity.
		$_SESSION['status']='in';
	}
}

mysqli_set_charset($con,"utf8");

	
?>
