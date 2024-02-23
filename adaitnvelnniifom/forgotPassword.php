<?php 

require_once 'conn.php';

if(isset($_POST['userName'])) {	
 
function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
   $char = substr($string, $i, 1);
   $keychar = substr($key, ($i % strlen($key))-1, 1);
   $char = chr(ord($char)+ord($keychar));
   $result.=$char;
}
return base64_encode($result);
}
$sicherheits_eingabe = encrypt($_POST["securitycode"], "8h384ls94");
$sicherheits_eingabe = str_replace("=", "", $sicherheits_eingabe);


if($sicherheits_eingabe != $_SESSION['captcha_spam']){
unset($_SESSION['captcha_spam']);
   $fehler['captcha'] = "<font color=#cc3333>You entered a wrong <strong>code</strong>.<br /></font>";
	echo "wrongcode";
   
   }
//print_r($fehler);


function random_gen($length)
{
  $random= "";
  srand((double)microtime()*1000000);
  $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $char_list .= "abcdefghijklmnopqrstuvwxyz";
  $char_list .= "1234567890";
  // Add the special characters to $char_list if needed

  for($i = 0; $i < $length; $i++)  
  {    
     $random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
  }  
  return $random;
} 

if (!isset($fehler) || count($fehler) == 0)
{

$random_string = random_gen(5);


$sql="SELECT email_id,pwd, username from userlogins  where email_id = '".$_POST['userName']."'";
$result = mysqli_query($GLOBALS['con'],$sql);
	
if (!$result) 
	{    
		die("Query to show fields from table failed");
	}		

	$fields_num = mysqli_num_fields($result);

		//print_r(mysqli_num_rows($result));	
	
	if(mysqli_num_rows($result) == 0)
	{
		echo 'notfound';
	}
	else if(mysqli_num_rows($result) == 1)
	{
		
 	
	$row = mysqli_fetch_array($result);
		//print_r($row);	
			$emailID =  $row['email_id'];
			$usernameTxt =  $row['username'];
			$pwd =  $row['pwd'];
//print_r($result);
	
	$to = "support@vatinfoline.com";
	//$to = "info@webrhythms.com";
	$subject = "Forgot Password Request";

	$message="Request a Password for user " . $emailID .   " . Password as been sent to his registered email ID."; 
	

	//$from = "vatupdates@gmail.com";
	//$from = $emailID;
	$headers = 'From: ' . $emailID; 
	//$headersto = 'From: '. $emailID; 
	mail($to,$subject,$message,$headers);
	
	$message1 = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>| VATinfoline |</title>
					</head>
					<body>
						<table width='50%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<th valign='top' style='  background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF'  >Forgot Password Request</div></th>
						</tr>
						<tr>
						<td>Dear User,
						Your user-id and password for accessing www.vatinfoline.com is as below:
						<br><br> <strong>User-id : </strong>". $usernameTxt ." <br><br> <strong>Password :</strong> ". $pwd." 
						<br><br> For any further assistance kindly contact us as support@vatinfoline.com
						<br><br>THIS IS AN AUTO GENERATED EMAIL, PLEASE DON’T REPLY TO IT.
						<br><br>Regards
						<br><br>VATinfoline Multimedia
						<br><br>www.vatinfoline.com
						<br><br>Phone: 022 – 65006700
						<br><br>
						<div><img src='https://www.vatinfoline.com/images/vatinfoline-logo-new.png'></div>			
						Note : This is an auto-generated mail against your password request, do not reply. 
						</td>
						</tr>
						</table>
					</body>
				</html>
				";
$mailheaders  = 'MIME-Version: 1.0' . "\r\n";
$mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$from = "VATinfoline";
// Additional headers
$mailheaders .= 'To: ' . $emailID ."\r\n";
$mailheaders .= 'From: ' . $from ."\r\n";


mail ($emailID,'Forgot Password Request',$message1,$mailheaders);
echo "success";
	
	}

}

}
 ?>