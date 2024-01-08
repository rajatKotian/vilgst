<?php
session_start();
ob_start(); //started buffering
?><?php
//print_r($_POST);
//exit();
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
	echo "<script>window.alert('You entered a wrong Code');</script>";
   		 header('Location: feedback.php');
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
//print_r($_POST);
//exit();
	if(($_POST["securitycode"]=='') || ($_POST["securitycode"] ==NULL))
	{
   		 header('Location: index.php');
		  //change yoursite.com to the name of you site!!
	}
	else
	{
	$to = "samir@vilgst.com";
	$cc = "support@vilgst.com";
	// $to = "anup.salpe@gmail.com";
	// $cc = "info@webrhythms.com";
	$subject = "Feedback Received from VATinfoline.com";
	$name="<strong>Feedback given by: </strong>" . $_POST['txtName'] .   " <br>"; 
	$co="<strong>Company name: </strong>" . $_POST['txtComp'] .   " <br>";
	$designation="<strong>Designation:</strong> " . $_POST['txtDesig'].   " <br>";   
	$email= "<strong>Email Id: </strong>" . $_POST['txtemail'] .   " <br>";  
	$contact="<strong>Contact No.:</strong> " . $_POST['txtContact'].  " <br>"; 
	$feed="<p  style='line-height: 18px;'><strong>Comment: </strong> <span>" . $_POST['txtfeed'].   "</span></p>"; 
	
	$message = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>| VATinfoline |</title>
					</head>

					<body>
						 
					<table width='80%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
					  <tr>
					  	
					    <th valign='top' style=' background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF' >Feedback from VATinfoline</div></th>
					  </tr>
					  <tr>
					    <td style='line-height: 35px; padding: 20px;'>". $name . $co . $designation . $email . $contact . $feed ."
												
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
	$mailheaders .= 'From: ' . $_POST['txtemail'] ."\r\n"; 
	$mailheaders .= 'Cc: ' . $cc ."\r\n";

  	mail($to,$subject,$message,$mailheaders);
	echo "<script>window.alert('Thank you for your feedback');</script>";
	echo "<script>window.location.href='index';</script>";

		
	}
	
		
	
}





?>