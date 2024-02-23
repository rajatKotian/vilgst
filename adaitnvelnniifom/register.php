<?php 
require_once 'conn.php';

if(isset($_POST['txtEmail'])) {	

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

	function random_gen($length) {
	  $random= "";
	  srand((double)microtime()*1000000);
	  $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $char_list .= "abcdefghijklmnopqrstuvwxyz";
	  $char_list .= "1234567890";

	  for($i = 0; $i < $length; $i++) {    
	     $random .= substr($char_list,(rand()%(strlen($char_list))), 1);  
	  }  
	  return $random;
	} 

	if (!isset($fehler) || count($fehler) == 0) {

		$random_string = random_gen(5);
		$txtEmail= $_POST['txtEmail']; 

		$sql = "SELECT username FROM userlogins WHERE email_id = '$txtEmail'";
		$result=mysqli_query($GLOBALS['con'],$sql);
		$row = mysqli_fetch_object($result);
		$count=mysqli_num_rows($result);
		if($count==1) {
			echo "alreadyexist";
		} else  {
			if(($_POST["securitycode"]=='') || ($_POST["securitycode"] ==NULL)) {
		   		 header('Location: index.php');
			} else {
				$txtPwd = trim($_POST['txtFName'])."_".$_POST["securitycode"];	
				$result = mysqli_query($GLOBALS['con'],"INSERT INTO userlogins
						(
							username,
							pwd,
							firstname,
							lastname,
							gender,
							occ,
							comapany_name,
							comapany_desg,
							email_id,
							address,
							landno,
							directno,
							mobileno,
							from_date,
							to_date,
							user_type,
							active_flag, 
							created_by, 
							created_dt, 
							updated_by,  
							updated_dt,
							hitcount,
							vatAccess,
							STAccess,
							CEAccess
						)
						VALUES
						(
							'".$_POST['txtEmail']."', 
							'$txtPwd',
							'".$_POST['txtFName']."',
							'".$_POST['txtLName']."', 
							'".$_POST['txtGender']."', 
							'".$_POST['txtOcc']."', 
							'".$_POST['txtComapny']."', 
							'".$_POST['txtDesignation']."', 
							'".$_POST['txtEmail']."', 
							'".$_POST['txtAdd']."', 
							'".$_POST['txtLandline']."', 
							'".$_POST['txtDirect']."', 
							'".$_POST['txtMobile']."', 
							NOW(), 
							(NOW()+INTERVAL 7 DAY),  
							'T', 
							'Y', 
							'auto',
							NOW(), 
							'auto',
							NOW(),
							10,
							'N',
							'N',
							'N'
						)");
			
				$to = "vatupdates@gmail.com";
				//$to = "anup.salpe@gmail.com";
				$subject = "New Registration Request from VATinfoline";

				$name="<strong>First Name: </strong>" . $_POST['txtFName'] .   "<br> "; 
				$lname="<strong>Last Name: </strong>" . $_POST['txtLName'] .   "<br> "; 
				$occ="<strong>Occupation: </strong>" . $_POST['txtOcc'] .   "<br> "; 
				$com="<strong>Company: </strong>" . $_POST['txtComapny'] .   "<br> "; 
				$designation="<strong>Designation: </strong>" . $_POST['txtDesignation'] .   "<br> "; 
				$add="<strong>Address: </strong>" . $_POST['txtAdd'] .   "<br> "; 
				$landline="<strong>Landline: </strong>" . $_POST['txtLandline'] .   "<br> "; 
				$direct="<strong>Direct No.: </strong>" . $_POST['txtDirect'] .   "<br> "; 
				$mobile="<strong>Mobile: </strong>" . $_POST['txtMobile'] .   "<br> "; 
				$txtEmailUsername="<strong>Emailid/Usernmae: </strong>" . $txtEmail .   "  "; 
				
				$message = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>| VATinfoline |</title>
					</head>

					<body>
						 
					<table width='70%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
					  <tr>
					  	
					    <th valign='top' style='  background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF'  >".$subject."</div></th>
					  </tr>
					  <tr>
					    <td style='line-height: 35px; padding: 20px;'>". $name . $lname . $occ . $com . $designation . $add . $landline . $direct . $mobile .$txtEmailUsername."
												
						</td>
					  </tr>
					  </table>
					</body>
					</html>
					";

				$mailheaders  = 'MIME-Version: 1.0' . "\r\n";
				$mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// Additional headers
				$mailheaders .= 'To: ' . $to ."\r\n";
				$mailheaders .= 'From: ' . $txtEmail ."\r\n";


				mail($to,$subject,$message,$mailheaders);

				$salutation = "Dear Sir/Madam, " . "<br> " . "<br> "; 
				$mailbody = "Thank you for registering with us. Your login detail is below :"  .  "<br> " . "<br> ";  
			 	$loginid = "<strong>User ID: </strong>" . $txtEmail . "<br> ";
				$password = "<strong>Password: </strong>". $txtPwd . "<br> " . "<br> ";
				$subscribe = "Please note this userid/password is valid only 10 accesses or 7 days, whichever is earlier. Please subscribe to our paid services to get uninterrupted access with email updates." . "<br> " . "<br> ";
				$regards = "Regards, " . "<br> " . "<br> ";
				$contact =  "Vatinfoline Multimedia" . "<br> " . "+91 9833019272" . "<br> " . "sales@vatinfoline.com";
				
				$messageto = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>| VATinfoline |</title>
					</head>

					<body>
						 
					<table width='80%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
					  <tr>
					  	
					    <th valign='top' style='  background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF'  >VATinfoline Login Details</div></th>
					  </tr>
					  <tr>
					    <td style='line-height: 18px; padding: 20px;'>". $salutation . $mailbody . $loginid . $password . $subscribe . $regards . $contact."
							<div><img src='https://www.vatinfoline.com/images/vatinfoline-logo-new.png'></div>			
								Note : This is an auto-generated mail against your password request, do not reply. 

						</td>
					  </tr>
					  </table>
					</body>
					</html>
					";

				$headersto  = 'MIME-Version: 1.0' . "\r\n";
				$headersto .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headersto .= 'To: ' . $txtEmail ."\r\n";
				$headersto .= 'From: ' . "vatinfoline"; 

				mail($txtEmail,"Welcome to VATinfoline | Login Details",$messageto,$headersto);		
				echo "success";
	
			}

		}
	}

} else {

	header('Location:index.php');
}
?>
