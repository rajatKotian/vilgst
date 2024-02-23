<?php

  $page = 'feedback';
$seoTitle = 'Feedback';
$seoKeywords = 'Feedback';
$seoDesc = 'Feedback';
  include('header.php');

  ?>



<script language = "Javascript">

	function echeck(str) {



		var at="@"

		var dot="."

		var lat=str.indexOf(at)

		var lstr=str.length

		var ldot=str.indexOf(dot)

		if (str.indexOf(at)==-1){

		   alert("Invalid E-mail ID")

		   return false

		}



		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){

		   alert("Invalid E-mail ID")

		   return false

		}



		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){

		    alert("Invalid E-mail ID")

		    return false

		}



		 if (str.indexOf(at,(lat+1))!=-1){

		    alert("Invalid E-mail ID")

		    return false

		 }



		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){

		    alert("Invalid E-mail ID")

		    return false

		 }



		 if (str.indexOf(dot,(lat+2))==-1){

		    alert("Invalid E-mail ID")

		    return false

		 }

		

		 if (str.indexOf(" ")!=-1){

		    alert("Invalid E-mail ID")

		    return false

		 }



 		 return true					

	}



function ValidateForm(){

	var emailID=document.form1.txtemail

	

	if ((emailID.value==null)||(emailID.value=="")){

		alert("Please Enter your Email ID")

		emailID.focus()

		return false

	}

	if (echeck(emailID.value)==false){

		emailID.value=""

		emailID.focus()

		return false

	}

	if (document.form1.txtName.value == '')

	{

		alert("Please Enter your Name")

		document.form1.txtName.focus()

		return false

	}

	if (document.form1.txtComp.value == '')

	{

		alert("Please Enter your Company Name")

		document.form1.txtComp.focus()

		return false

	}

	if (document.form1.txtContact.value == '')

	{

		alert("Please Enter your Contact No")

		document.form1.txtContact.focus()

		return false

	}

	if (document.form1.txtfeed.value == '')

	{

		alert("Please Enter your Comments")

		document.form1.txtfeed.focus()

		return false

	}

	if (document.form1.securitycode.value == '')

	{

	alert("Please Enter Varification Code")

	document.form1.securitycode.focus()

	return false

	}



	return true

 }

</script>



    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">

		<h1>Feedback

			<ol class="breadcrumb">

				<li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

				<li class="active">Feedback</li>

			</ol>

		</h1>

	 

		<div class="alert alert-warning"><h6>Your feedback is precious for us. Kindly spend few minutes to share your opinion.</h6></div>

		

		<div class="col-md-8 table-container" >

			<form name="form1" method="post" class="form" action="sendfeed.php" onsubmit="return ValidateForm()">

		      	

				<label>Name</label>

				<div class="form-group">

					<input type="text" name="txtName" id="txtName" class="form-control" tabindex="1"> 				

				</div> 



				<label>Company</label>

				<div class="form-group">

					<input type="text" name="txtComp" id="txtComp" class="form-control" tabindex="2">				

				</div> 



				<label>Designation</label>

				<div class="form-group">

					<input type="text" name="txtDesig" id="txtDesig" class="form-control" tabindex="3">

				</div> 



				<label>Email ID</label>

				<div class="form-group">

					<input type="text" name="txtemail" id="txtemail" class="form-control" tabindex="4">				

				</div>  



				<label>Contact No</label>

				<div class="form-group">

					<input type="text" name="txtContact" id="txtContact" class="form-control" tabindex="5">				

				</div>   



				<label>Feedback</label>

				<div class="form-group">

					<textarea name="txtfeed" id="txtfeed" class="form-control" rows="2" tabindex="6"></textarea>

					

				</div>  



				<label>Security Code</label>

				<div class="form-group">

					<img src="captcha/captcha.php" alt="Security-Code" title="michatronic-sicherheitscode" id="captcha">

					<br>

					<a href="javascript:void(0);" onclick="javascript:document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();">

					<span class="neuercode">New Code?</span></a>

				</div>  



				<label>Enter Code</label>

				<div class="form-group"><?php if ($fehler["captcha"] != "") { echo $fehler["captcha"]; } ?>

					<input type="text" name="securitycode" class="form-control" tabindex="7" maxlength="150">

				</div>



				<label></label>

				<div>

					<input type="submit" value="submit" id="submit" class="btn btn-lg" tabindex="8">			

				</div>									

			</form>

		</div> 	

	

	</div>

 	

    <!-- left sec end --> 



<?php 

  include('footer.php');

?>
