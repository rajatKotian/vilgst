<?php
  $page = 'submitArticle';
$seoTitle = 'Submit Article';
$seoKeywords = 'Submit Article';
$seoDesc = 'Submit Article';
include('header.php');
?>

<?php 

if(isset($_POST['submit'])) {

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
		if(($_POST["securitycode"]=='') || ($_POST["securitycode"] ==NULL)) {
	   		 header('Location: index.php');
			  //change yoursite.com to the name of you site!!
		} else {
		//$to = "anup.salpe@gmail.com";
		$to = "samir@vatinfoline.com";
		$cc = "support@vatinfoline.com";
		if(isset($_SESSION['user'])) {
 			$subjectUser = ' | ' .$_SESSION['user'];
		} else {
			$subjectUser = ' | Guest User';
 		}
		$subject = "Article uploaded by Author ".$subjectUser;
		$todayDate = date("dmYhis");

		$txtUploadArticleExtn = explode(".", $_FILES["txtUploadArticle"]["name"]);
		$txtProfileExtn = explode(".", $_FILES["txtProfile"]["name"]);

 
	  	$txtUploadArticle = $_SESSION['id'] .'_'.$todayDate. '_article.' . end($txtUploadArticleExtn);
		$txtProfile = $_SESSION['id'] .'_'.$todayDate. '_profile_pic.' . end($txtProfileExtn);
		
		if(move_uploaded_file($_FILES['txtUploadArticle']['tmp_name'], "uploads/" . $txtUploadArticle ))  {
			if($_FILES["txtProfile"]['name'] != '') {
				move_uploaded_file($_FILES['txtProfile']['tmp_name'], "uploads/" . $txtProfile);
			}
			
			$txtProfileLink = '';

			$txtName="Article Uploaded by " . $_POST['txtAuthorName']; 
			$txtArticleTitle="<strong>Article Title : </strong> " . $_POST['txtArticleTitle'];
			if($_FILES["txtProfile"]['name'] != '') {
				$txtProfileLink="<strong>Profile Picture: </strong><a target='_blank' href='".$getBaseUrl."uploads/".$txtProfile."'>Profile Photo Link</a><br> ";   
			}
			$txtUploadArticle= " <strong>Article uploaded at : </strong><a target='_blank' href='".$getBaseUrl."uploads/".$txtUploadArticle."'>Article Link</a>";   
		
			$message = "<html>
						<head>
							<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
							<title>| VATinfoline |</title>
						</head>
						<body>
							<table width='50%' cellspacing='0' cellpadding='5' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#94a0a5;background-color:#fbf9f0;border-collapse:collapse;border:2px solid #ff7808'>
								<tr>
								<th valign='top' style=' background:#ff7808; border-bottom:#ff7808 1px solid; text-align:center; vertical-align:middle; padding-right:20px;'><div style='font-size:20px; font-weight:bold; color:#FFF' >".$txtName."</div></th>
								</tr>						<tr>
								<td style='line-height: 35px; padding: 20px;'>". $txtArticleTitle ." <br>". $txtProfileLink."  ". $txtUploadArticle."
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
			$mailheaders .= 'From: ' . 'VATinfoline.com' ."\r\n"; 
			$mailheaders .= 'Cc: ' . $cc ."\r\n";

			mail($to,$subject,$message,$mailheaders);
			echo "<script>window.alert('Thank You for your upload. We shall get back to you shortly.');</script>";
			echo "<script>window.location.href='index';</script>";
		}			
		}	
	}
}
?> 
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
	   <!-- left sec start -->
    <div class="col-md-16 col-sm-16">
		<h1>Submit your Article
			<ol class="breadcrumb">
				<li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
				<li class="active">Submit Article</li>
			</ol>
		</h1>
	</div>

	<div class="col-md-16 col-sm-16"><p class="alert alert-warning">We would like to invite you to partner with VATinfoline Multimedia and get your article published on our website. You can upload your article here and we will publish the same with giving you the due credit. Additionally, get discount on our subscription fee by committing to write certain pre-agreed number of Articles on weekly/monthly basis. For details kindly contact us at support@vilgst.com</p></div>

	<div class="col-md-7 table-container align-article">
		<form name="agreeForm" class="form">
	      	<h3>Terms and Conditions</h3>
	      	<ul class="list-unstyled submit-article-list">
				<li>The Article must be in MS Word format.</li> 
				<li>Please provide your name and email-id, contact number along with color passport size photograph (optional).</li>
				<li>Please ensure that that the Article is original and does not infringe copyright of any individual, firm, company etc. In case of any such infringement, the author of article shall be personally liable for any consequent damages.</li> 
				<li>The article must not have been published earlier and/or sent for publication elsewhere.</li> 
				<li>VATinfoline Multimedia has the sole discretion to accept or reject the article for publication on its website or to publish it with modification and editing, as it considers appropriate.</li>
				<li>Article shall be uploaded on the website and/or shall be circulated to our subscribing members.</li>
			</ul>
 			<div class="col-md-8" style="float:right;">			
				<input type="button" value="I / We Agree" id="agreeButton" class="btn" tabindex="8" style="float : right;">	
			</div>	
		</form>		
	</div>

	<div class="col-md-8 table-container">
		<form name="articleSubmit"  id="articleSubmit" method="post" class="form" action=""  enctype="multipart/form-data" onsubmit="return ValidateForm()">

			<label class="">Name</label>
			<div class="form-group">
				<input type="text" name="txtAuthorName" id="txtAuthorName" class="form-control" tabindex="1">   				
			</div>

			<label class="">Article Title</label>
			<div class="form-group">
				<input type="text" name="txtArticleTitle" id="txtArticleTitle" class="form-control" tabindex="2">   				
			</div>  

			<label class="">Profile Photo</label>
			<div class="form-group">
				<input type="file" name="txtProfile" id="txtProfile" class="form-control" tabindex="3"  accept="image/jpeg,image/png" />	
				<span>(upload .jpg or .png)</span>			
			</div> 

			<label class="">Upload Article</label>
			<div class="form-group">
				<input type="file" name="txtUploadArticle" id="txtUploadArticle" class="form-control" tabindex="4"   accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  />			
				<span>(upload .doc/docx)</span>

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
				<input type="submit" value="submit" id="submit" name="submit"  class="btn btn-lg" tabindex="6">			
			</div>						
		</form>		
	</div> 	
	
 	
    <!-- left sec end --> 
</div>
<?php 
  include('footer.php');
?>
<script language = "Javascript">

$(document).ready(function() {
	localStorage.removeItem("ArticleTermsSubmit");

	$('#agreeButton').click(function() {
		$(this).removeClass('btn-error').addClass('btn-success').val('Terms & conditions agreed ').closest('.table-container').removeClass('error').addClass('success');
		localStorage.setItem("ArticleTermsSubmit", "Yes");
		
	});

});
	

function ValidateForm(){
	if (localStorage.getItem("ArticleTermsSubmit") != 'Yes') {
		$('#agreeButton').addClass('btn-error').closest('.table-container').addClass('error');
		alert("Please read terms and conditions and do agree")
		return false
	} else if (document.articleSubmit.txtAuthorName.value == '') {
		alert("Please enter your name");
		document.articleSubmit.txtAuthorName.focus();
		return false
	}  else if (document.articleSubmit.txtArticleTitle.value == '') {
		alert("Please Enter Article Title ");
		document.articleSubmit.txtArticleTitle.focus();
		return false
	} else if (document.articleSubmit.txtUploadArticle.value == '') {
		alert("Please Upload your Article");
		document.articleSubmit.txtUploadArticle.focus();
		return false
	} else if (document.articleSubmit.securitycode.value == '')	{
		alert("Please Enter Varification Code");
		document.articleSubmit.securitycode.focus();
		return false
	}
	localStorage.removeItem("ArticleTermsSubmit");
	return true
 }
</script>
