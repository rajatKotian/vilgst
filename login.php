<?php 
require_once 'conn.php';

if(isset($_POST['name'])) {	

$myusername = mysqli_real_escape_string($GLOBALS['con'],stripslashes($_POST['name']));
$mypassword = mysqli_real_escape_string($GLOBALS['con'],stripslashes($_POST['pwd']));

//$sql="SELECT user_id,totalhitcount,user_type,vatAccess,STAccess,CEAccess  FROM userlogins WHERE username='$myusername' and pwd='$mypassword' and user_type in('S','A','T') and active_flag = 'Y' and from_date <= curdate() and to_date >= curdate()";

$sql="SELECT user_id,totalhitcount,user_type,vatAccess,STAccess,CEAccess,customsAccess,gstAccess, ipenabled, ipenabled, ipallowed  FROM userlogins WHERE username='$myusername' AND pwd='$mypassword' AND user_type in('S','A','T') AND active_flag = 'Y'";

$resultStatus = '';
$res = mysqli_query($GLOBALS['con'],$sql);
$num_row = mysqli_num_rows($res);
$row=mysqli_fetch_assoc($res);

if( $num_row == 1 ) {	

/*	if($row['ipenabled'] == 'Y') {
		$visitor = $_SERVER['REMOTE_ADDR'];
		$ipallowed = "'".$row['ipallowed']."'";
		if (!preg_match("/".$visitor."/",$ipallowed)) {
			echo 'invalidip';
			return true;
		}; 
	}
	*/
	
		if($row['ipenabled'] == 'Y') {
		    include 'iprange.php';
    		$visitor = $_SERVER['REMOTE_ADDR'];
    		$allowedIps = explode(",",$row['ipallowed']);
    		$validIP = false;
    		foreach($allowedIps as $allowedIp){
    		    	//checking if ip is provided in CIDR format
        		if(isset($allowedIp) && $allowedIp!='' && strpos($allowedIp,'/')>0){
                    
                    
                
                    
                    $range = $allowedIp;
                    if(ip_in_range($visitor, $range)){
                       $validIP = true;
                       break;
                    }
    
    
        		}else{
        		    $ipallowed = "'".$allowedIp."'";
            		if (preg_match("/".$visitor."/",$ipallowed)) {
            		    $validIP = true;
            		    break;
            		};     
        		}
    		}
    		
    	    if(!$validIP){
    	        echo 'invalidip';
			    return true;
    	    }
    	}

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
	if($row['user_type'] == 'A') {
		$_SESSION['expire_time'] =  40 * 60;
// 		$_SESSION['expire_time'] = 9999 * 24 * 60 * 60;
	} else {
		$_SESSION['expire_time'] =  40 * 60;
// 		$_SESSION['expire_time'] = 2 * 30 * 60;
	}

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
