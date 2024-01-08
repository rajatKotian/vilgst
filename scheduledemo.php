<?php

require_once 'conn.php';

function decrypt_url_new($string) {
    $key = "VAT_123456789"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {

    $file = $path . $filename;
    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);

// header
    $header = "From: " . $from_name . " <" . $from_mail . ">\r\n";
    $header .= "Reply-To: " . $replyto . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";

// message & attachment
    $nmessage = "--" . $uid . "\r\n";
    $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
    $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $nmessage .= $message . "\r\n\r\n";
    $nmessage .= "--" . $uid . "\r\n";
    $nmessage .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n";
    $nmessage .= "Content-Transfer-Encoding: base64\r\n";
    $nmessage .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
    $nmessage .= $content . "\r\n\r\n";
    $nmessage .= "--" . $uid . "--";

    if (mail($mailto, $subject, $nmessage, $header)) {
        echo "success";
    } else {
        echo "error";
    }
}

if (isset($_POST['emailPageYourName'])) {


    $emailPageYourName = $_POST["emailPageYourName"];
    $emailPageCompName = $_POST["emailPageCompName"];
    $emailPageRecEmailID = $_POST["emailPageRecEmailID"];
    $emailPageFeedback = $_POST["emailPageFeedback"];
    $emailPageContactNo = $_POST["emailPageContactNo"];
    //$file_path = $_POST["file_path"];

    $time = date("dmYhis", time());



//Carbon Copy
//	$toCC = "taxvista@vilgst.com";
    $toCC = "samir@vilgst.com";

    // Subject line of email
    $my_subject = "Request for schedule a demo by - $emailPageYourName";

    // Content of email message (Text only)
    $message = "<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>| VATinfoline |</title>
				</head>
				<body>
					<table width='80%' cellspacing='5' cellpadding='10' border='0' style='font-family: Verdana,sans-serif;font-size:13px;color:#343c3f;background-color:#fff;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<td style='padding-left: 10px'>Hi, <br><br>" . $emailPageYourName . " has requested for demo details are below.<br><br>
						<br><br>
                                                <b>Contact Name: </b> " . $emailPageYourName . " <br>
                                                <b>Company Name: </b> " . $emailPageCompName . " <br>
                                                <b>Email: </b> " . $emailPageRecEmailID . " <br>
                                                <b>Comments: </b> " . $emailPageFeedback . " <br>
                                                <b>Contact No: </b> " . $emailPageContactNo . " <br>
						<div><img width='150' src='https://www.vatinfoline.com/images/vatinfoline-logo.png'></div>			
						<span style='font-size: 10px;color:#94a0a5;'>Note : This is an auto-generated mail, do not reply. 
						</td>
						</tr>
					</table>
				</body>
				</html>
				";

    // Call function to send email
    //mail_attachment($my_file, $my_path, $to_email, $my_mail, $my_name, $my_replyto, $my_subject, $message);
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . 'VATinfoline';
    mail($toCC, $my_subject, $message, $headers);


    $toCC = $emailPageRecEmailID;

    // Subject line of email
    $my_subject = "Request received for schedule a demo on vilgst.com";

    // Content of email message (Text only)
    $message = "<html>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>| VATinfoline |</title>
				</head>
				<body>
					<table width='80%' cellspacing='5' cellpadding='10' border='0' style='font-family: Verdana,sans-serif;font-size:13px;color:#343c3f;background-color:#fff;border-collapse:collapse;border:2px solid #ff7808'>
						<tr>
						<td style='padding-left: 10px'>Hello,<br><br>

We have received your request for demo. We will get back to you shortly. <br><br>We thank you for your interest.<br><br>
						<br>
						<div><img width='150' src='https://www.vatinfoline.com/images/vatinfoline-logo.png'></div>			
						<span style='font-size: 10px;color:#94a0a5;'>Note : This is an auto-generated mail, do not reply. 
						</td>
						</tr>
					</table>
				</body>
				</html>
				";

    // Call function to send email
    //mail_attachment($my_file, $my_path, $to_email, $my_mail, $my_name, $my_replyto, $my_subject, $message);
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . 'VATinfoline';
    mail($toCC, $my_subject, $message, $headers);

    echo 'success';
}
?>