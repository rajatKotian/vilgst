<?php 

require_once 'conn.php';

if(isset($_POST['emailPageYourName'])) {
    
    $emailPageKeyword = $_POST["emailPageKeyword"];
    $emailPageCitation = $_POST["emailPageCitation"];
    $emailPageFeedback = $_POST["emailPageFeedback"];
	$emailPageYourName = $_POST["emailPageYourName"];
	$emailPageCompName = $_POST["emailPageCompName"];
	$emailPageRecEmailID = $_POST["emailPageRecEmailID"];
	$emailPageContactNo = $_POST["emailPageContactNo"];
	
    //Carbon Copy
	$to = "samir@vilgst.com";
	//$toCC = "anup.salpe@gmail.com";
	$subject = "Case Law Request From: ".$emailPageRecEmailID;
	
	$message     = "<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>| VILGST CRF |</title>
				</head>
				<body>
					<table width='80%' cellspacing='5' cellpadding='10' border='0' style='font-family: Verdana,sans-serif;font-size:13px;color:#343c3f;background-color:#fff;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<td style='padding-left: 10px'>Hi, <br><br>" . $emailPageYourName ." has requested for a Case Law with following details: <br><br>
						</b>Keyword/Party Name:</b> $emailPageKeyword <br>
						</b>Citation/Case No.:</b> $emailPageCitation <br>
						</b>Remarks:</b> $emailPageFeedback <br><br><br>
						
						Requester Details:
						</b>Company Name:</b> $emailPageCompName <br>
						</b>Email ID:</b> $emailPageRecEmailID <br>
						</b>Mobile Number:</b> $emailPageContactNo <br>
						
						<br><br>
						Thanks.<br><br>
						<div><img width='150' src='http://vilgst.local/images/vatinfoline-logo.png'></div>			
						<span style='font-size: 10px;color:#94a0a5;'>Note : This is an auto-generated mail, do not reply. 
						</td>
						</tr>
					</table>
				</body>
				</html>
				";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ' . 'VILGST'; 
	$response = mail($to, $subject, $message, $headers);
	
	/** CC to Requester **/
	$to_email   = $emailPageRecEmailID;
	
	// Subject line of email
	$my_subject = "Case Law Request";
	
	$my_message     = "<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>| VILGST CRF |</title>
				</head>
				<body>
					<table width='80%' cellspacing='5' cellpadding='10' border='0' style='font-family: Verdana,sans-serif;font-size:13px;color:#343c3f;background-color:#fff;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<td style='padding-left: 10px'>Hi $emailPageYourName, <br><br> You have requested for a Case Law with following details: <br><br>
						</b>Keyword/Party Name:</b> $emailPageKeyword <br>
						</b>Citation/Case No.:</b> $emailPageCitation <br>
						</b>Remarks:</b> $emailPageFeedback <br><br><br>
						
						Requester Details:
						</b>Company Name:</b> $emailPageCompName <br>
						</b>Email ID:</b> $emailPageRecEmailID <br>
						</b>Mobile Number:</b> $emailPageContactNo <br>
						
						<br><br>
						Thanks.<br><br>
						<div><img width='150' src='http://vilgst.local/images/vatinfoline-logo.png'></div>			
						<span style='font-size: 10px;color:#94a0a5;'>Note : This is an auto-generated mail, do not reply. 
						</td>
						</tr>
					</table>
				</body>
				</html>
				";
				
	$my_headers  = 'MIME-Version: 1.0' . "\r\n";
	$my_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$my_headers .= 'From: ' . 'VILGST'; 
	
	// Call function to send email
	mail($to_email, $my_subject, $my_message, $my_headers);
	
	if ($response) {
        echo "success";
	} else {
        echo "error";
	}
}
?>

