<?php session_start();
ob_start(); 

$db_host = 'localhost';

// $db_user = 'root';
// $db_pwd = '';
// $database = 'vilgstinvoice';

$db_pwd = '6Pr@VvQzctSS';
$db_user = 'vilgst12_invoice';
$database = 'vilgst12_invoices';



if (!mysql_connect($db_host, $db_user, $db_pwd)) {
	die("Can't connect to database");
}   

if (!mysql_select_db($database)) {
	die("Can't select database");
}    

if(isset($_SESSION['user'])) {
	if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {  

	$_SESSION['status']='out';
	header('Location: logout.php'); //redirect to logout.php 
	} else {  
		$_SESSION['last_activity'] = time(); //this was the moment of last activity.
		$_SESSION['status']='in';
	}
}

mysql_set_charset("utf8");

	
?>
