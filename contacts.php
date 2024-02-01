<?php
  $page = 'homePage';
$seoTitle = 'Contact Us';
$seoKeywords = 'Contact Us';
$seoDesc = 'Contact Us';
  include('header.php');
?>

<?php 

if(isset($_POST['submit'])) {
print_r($_POST);
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
		//$to = "anup.salpe@gmail.com";
		$to = "samir@vilgst.com";
		$cc = "support@vilgst.com";
		$subject = "Contact details dropped from VATinfoline";
		$txtFullName="<strong>Name : </strong>" . $_POST['txtFullName'] .   " <br>"; 
		$txtCompanyName="<strong>Company Name: </strong>" . $_POST['txtCompanyName'] .   " <br>"; 
		$txtEmailID="<strong>Email Id : </strong>" . $_POST['txtEmailID'] .   " <br>"; 
		$txtPhoneNumber="<strong>Contact Number : </strong>" . $_POST['txtPhoneNumber'] .   " <br>"; 

		$message = "<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<title>| VATinfoline |</title>
					</head>

					<body>
						 
					<table width='50%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
					  <tr>
					  	
					    <th valign='top' style=' background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF' >".$subject."</div></th>
					  </tr>
					  <tr>
					    <td style='line-height: 35px; padding: 20px;'>". $txtFullName . $txtCompanyName . $txtEmailID . $txtPhoneNumber ."
												
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
			$mailheaders .= 'From: ' . 'VATinfoline' ."\r\n"; 
			$mailheaders .= 'Cc: ' . $cc ."\r\n";

			mail($to,$subject,$message,$mailheaders);
			echo "<script>window.alert('Thank you for your interest. We shall get in touch with you shortly.');</script>";
			echo "<script>window.location.href='index';</script>";
		
			
		}
		
			
		
	}

}
 ?> 
 <script>

 function ValidateForm(){
 	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;

	if (document.contactForm.txtFullName.value == '') {
		alert("Please enter your name ")
		document.contactForm.txtFullName.focus()
		return false
	} else if (document.contactForm.txtCompanyName.value == '') {
		alert("Please enter your Company name")
		document.contactForm.txtCompanyName.focus()
		return false
	}  else if (document.contactForm.txtEmailID.value == '') {
		alert("Please enter your email id")
		document.contactForm.txtEmailID.focus()
		return false
	}  else if (!re.test($("#txtEmailID").val())) {		

		alert("Please enter valid email id")
		document.contactForm.txtEmailID.focus()
		return false
	}  else if (document.contactForm.txtPhoneNumber.value == '') {
		alert("Please enter your Contact Number")
		document.contactForm.txtPhoneNumber.focus()
		return false
	} else if (document.contactForm.securitycode.value == '')	{
		alert("Please Enter Varification Code")
		document.contactForm.securitycode.focus()
		return false
	}
	return true
 }
</script>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>Contact us
      		<ol class="breadcrumb">
		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <li class="active">Contact us</li>
	      </ol>
      </h1>
      

    <div class="col-md-6 table-container align-article">
    <form class="form">
		<h4>Reach us at:</h4>
		    <div style="font-size:15px; margin:10px; margin-bottom:50px; line-height:24px;">
		    98330 19272<br />
		    88796 02030<br />
		    
		 
	    <a href="mailto:sales@vilgst.com">sales@vilgst.com</a><br />
		    <a href="mailto:support@vilgst.com">support@vilgst.com</a><br />
	    </div>
	    
	    <h4>Our Address:</h4>
		    <div style="font-size:15px; margin:10px; line-height:24px;">
		    Unit No. 312 <br />
		    Omega Business Park<br />
		    Ambica Nagar <br />
		    Wagle Industrial Estate <br />
		    Thane [West] - 400 604 <br />
		    Mumbai, Maharashtra, India.
		    </div>
	</form>
	</div>

	<div class="col-md-9 table-container">
		<form name="contactForm" id="contactForm" class="form padding-t-20" method="post" action="" onsubmit="return ValidateForm()">
	      	<div class="alert alert-warning always-show"><h6>Leave your contact details for us to contact you:</h6></div>
			<label class="">Name</label>
			<div class="form-group">
				<input type="text" name="txtFullName" id="txtFullName" class="form-control" tabindex="1">   				
			</div> 

			<label class="">Company Name</label>
			<div class="form-group">
				<input type="text" name="txtCompanyName" id="txtCompanyName" class="form-control" tabindex="2">				
			</div> 

			<label class="">Email-id</label>
			<div class="form-group">
				<input type="text" name="txtEmailID" id="txtEmailID" class="form-control" tabindex="3">			
			</div> 

			<label class="">Phone Number</label>
			<div class="form-group">
				<input type="text" name="txtPhoneNumber" id="txtPhoneNumber" class="form-control" tabindex="4">			
			</div> 

			<label class="">Security Code</label>
			<div class="form-group">
				<img src="captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha">
				<br>
				<a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();">
				<span class="neuercode">New Code?</span></a>
			</div>  

			<label class="">Enter Code:</label>
			<div class="form-group"><?php if ($fehler["captcha"] != "") { echo $fehler["captcha"]; } ?>
				<input type="text" name="securitycode" class="form-control" tabindex="5" maxlength="150">
			</div>

			<label class=""></label>
			<div class="form-group">			
				<input type="submit" value="submit" name="submit" id="submit" class="btn btn-lg" tabindex="6">			
			</div>						
		</form>		
	</div> 	
	

    </div>

    <!-- left sec end --> 

<?php 
  include('footer.php');
?> 
