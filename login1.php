<?php 
require_once 'conn.php';

if(isset($_POST['name'])) {	

$myusername = mysqli_real_escape_string($con,stripslashes($_POST['name']));
$mypassword = mysqli_real_escape_string($con,stripslashes($_POST['pwd']));

//$sql="SELECT user_id,totalhitcount,user_type,vatAccess,STAccess,CEAccess  FROM userlogins WHERE username='$myusername' and pwd='$mypassword' and user_type in('S','A','T') and active_flag = 'Y' and from_date <= curdate() and to_date >= curdate()";
$sql="SELECT user_id,totalhitcount,user_type,vatAccess,STAccess,CEAccess,customsAccess,gstAccess  FROM userlogins WHERE username='$myusername' AND pwd='$mypassword' AND user_type in('S','A','T') AND active_flag = 'Y'";
$resultStatus = '';
$res = mysqli_query($GLOBALS['con'],$sql);
$num_row = mysqli_num_rows($res);
$row=mysqli_fetch_assoc($res);

if( $num_row == 1 ) {		

	$totalhitcount = $row['totalhitcount']+1;
	$id = $row['user_id'];
	$curDate = date("Y/m/d H:i:s");

	$strQuery = "INSERT INTO login_history (user_id,login_dt,active_flag,created_by,created_dt) VALUES ($id,'$curDate','Y','$myusername','$curDate')";
	mysqli_query($GLOBALS['con'],$strQuery);

	$updateQuery = "UPDATE userlogins SET totalhitcount = '$totalhitcount' WHERE user_id =$id";
	mysqli_query($GLOBALS['con'],$updateQuery);

	$_SESSION["user"] = $myusername;
	$_SESSION["login"] = 'qwert';
	$_SESSION['logged_in'] = true; 
	$_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
	$_SESSION['expire_time'] = 60*60*10; 
	$_SESSION["id"] = $row['user_id'];
	$_SESSION["type"] = $row['user_type']; 
	$_SESSION["vatAccess"] =  $row['vatAccess']; 
	$_SESSION["STAccess"] =  $row['STAccess']; 
	$_SESSION["CEAccess"] =  $row['CEAccess']; 
	$_SESSION["customsAccess"] =  $row['customsAccess']; 
	$_SESSION["gstAccess"] =  $row['gstAccess']; 

	$sqlExpiry="SELECT * FROM userlogins WHERE user_id='".$row['user_id']."' and to_date >= now()";
	$resExpiry = mysqli_query($GLOBALS['con'],$sqlExpiry);
	$num_rowExpiry = mysqli_num_rows($resExpiry);

	if($num_rowExpiry == 1)	{

		$sqlExpiry1="SELECT * FROM userlogins WHERE user_id='".$row['user_id']."' and totalhitcount <= hitcount";
		$resExpiry1 = mysqli_query($GLOBALS['con'],$sqlExpiry1);

		$num_rowExpiry1 = mysqli_num_rows($resExpiry1);
		if($num_rowExpiry1 == 1) {
			$resultStatus = 'active';
			$_SESSION["userStatus"]= 'active';
		} else {
			$resultStatus = 'expired';
			$_SESSION["userStatus"]= 'expired';
		}
	} else {
		$resultStatus = 'expired';
		$_SESSION["userStatus"]= 'expired';
	}

} else {
	$resultStatus = 'fail';
}

echo $resultStatus;
} else {

	header('Location:index.php');
}
?>
