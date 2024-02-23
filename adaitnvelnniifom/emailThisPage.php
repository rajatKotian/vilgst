<?php 

require_once 'conn.php';

function decrypt_url_new($string) {
    $key = "VAT_123456789"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)-ord($keychar));
     $result.=$char;
   }
   return $result;
}

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {

$file = $path.$filename;
$content = file_get_contents( $file);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file);

// header
$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$replyto."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

// message & attachment
$nmessage = "--".$uid."\r\n";
$nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$nmessage .= $message."\r\n\r\n";
$nmessage .= "--".$uid."\r\n";
$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
$nmessage .= "Content-Transfer-Encoding: base64\r\n";
$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$nmessage .= $content."\r\n\r\n";
$nmessage .= "--".$uid."--";

    if (mail($mailto, $subject, $nmessage, $header)) {
        echo "success";
	} else {
        echo "error";
	} 

}

if(isset($_POST['emailPageYourName'])) {			


	$emailPageYourName = $_POST["emailPageYourName"];
	$emailPageCompName = $_POST["emailPageCompName"];
	$emailPageRecEmailID = $_POST["emailPageRecEmailID"];
	//$file_path = $_POST["file_path"];
	$encryptUrl = $_POST['file_path'];

	$file_path = decrypt_url_new($encryptUrl);

	$time= date("dmYhis",time());
	$file_extn = strtolower(substr($file_path,-3));	


	if($file_extn == 'pdf') { 
		
		$file_name = preg_replace("/\.[^.]+$/", "", basename($file_path))."_".$time.".pdf";
		copy("$file_path","shared/$file_name");

	} else { 
		$file_name = preg_replace("/\.[^.]+$/", "", basename($file_path))."_".$time.".html";
		copy("$file_path","shared/$file_name");
		if (function_exists('date_default_timezone_set'))
		{
		  date_default_timezone_set('Asia/Kolkata');
		}
		$timeStamp= date("d-m-Y h:i:sA",time());


		$source = "shared/$file_name";
		$destination = "shared/$file_name";
		$vatinfolineLogo = "<div style='text-align: center;'><a href='https://www.vatinfoline.com' target='_blank'><img width='250' src='https://www.vatinfoline.com/images/vatinfoline-logo.png' border='0' /></a></div>";
		$copyrightText = "<div style='font-family:verdana,serif; font-size: 12px; border: 1px solid #ddd; background-color: #f5f5f5; padding: 10px; text-align: center; margin: 20px;'>This file is downloaded from <a style='color:#004e84;' href='https://www.vatinfoline.com' target='_blank'>www.vatinfoline.com</a> on <em>$timeStamp</em></div>";

		$data = $vatinfolineLogo.$copyrightText.file_get_contents($file_path).$copyrightText;

		$handle = fopen($destination, "w");
		fwrite($handle, $data);
		fclose($handle);
	}

	$my_file = "$file_name";
	$my_path = $_SERVER['DOCUMENT_ROOT']."/shared/";


//Carbon Copy
	$toCC = "support@vatinfoline.com";
	//$toCC = "anup.salpe@gmail.com";
	$subjectCC = "Page shared to ".$emailPageRecEmailID;

	$messageCC= "<a href='https://www.vatinfoline.com/shared/".$my_file."' target='_blank'>This Page</a>  has been shared to " . $emailPageRecEmailID .   " by " . $emailPageYourName ." from ".$emailPageCompName; 

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ' . 'VATinfoline'; 
	mail($toCC,$subjectCC,$messageCC,$headers);
	
	// File to attach

	
	// Who email is FROM
	$my_name    = $emailPageYourName;
	$my_mail    = $toCC;
	$my_replyto = $toCC;
	
	// Whe email is going TO
	$to_email   = $emailPageRecEmailID; // Comes from Wufoo WebHook
	
	// Subject line of email
	$my_subject = "Page shared from VATinfoline !";
	
	// Content of email message (Text only)
	$message     = "<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>| VATinfoline |</title>
				</head>
				<body>
					<table width='80%' cellspacing='5' cellpadding='10' border='0' style='font-family: Verdana,sans-serif;font-size:13px;color:#343c3f;background-color:#fff;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<td style='padding-left: 10px'>Hi, <br><br>" . $emailPageYourName ." has shared a Page from VATinfoline for your perusal. Please find attached.<br><br>
						Thanks.<br><br>
						<div><img width='150' src='https://www.vatinfoline.com/images/vatinfoline-logo.png'></div>			
						<span style='font-size: 10px;color:#94a0a5;'>Note : This is an auto-generated mail, do not reply. 
						</td>
						</tr>
					</table>
				</body>
				</html>
				";
	
	// Call function to send email
	mail_attachment($my_file, $my_path, $to_email, $my_mail, $my_name, $my_replyto, $my_subject, $message);
}
?>

