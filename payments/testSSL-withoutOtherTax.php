<?php 
$page = 'paidService';
include('../header.php') ?> 

<div class="col-md-16 col-sm-16">
    <h1>Make Payment
  		<ol class="breadcrumb">
	        <li><a href="/index.php">Home</a></li>
	        <li><a href="javascript:void(0)" onclick="javascript:history.go(-1);return false;">Online Subscription</a></li>
	        <li>Make Payment</li>
        </ol>
    </h1>


<?php 

if(isLogeedIn()) { 
 
	set_include_path('../lib'.PATH_SEPARATOR.get_include_path());
	require_once('../lib/CitrusPay.php');
	require_once 'Zend/Crypt/Hmac.php';

	function generateHmacKey($data, $apiKey=null){
		$hmackey = Zend_Crypt_Hmac::compute($apiKey, "sha1", $data);
		return $hmackey;
}

$action = "testSSL.php";
$flag = "";

CitrusPay::setApiKey("94913099f8929255cf6991421d4a4b6e7cca90ac",'production');

if(isset($_POST['submit']))
{
	$vanityUrl = "vatinfo5928";
	$currency = "INR";
	$merchantTxnId = $_POST['merchantTxnId'];
	$addressState = $_POST['addressState'];
	$addressCity = $_POST['addressCity'];
	$addressStreet1 = $_POST['addressStreet1'];
	$addressCountry = $_POST['addressCountry'];
	$addressZip = $_POST['addressZip'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$phoneNumber = $_POST['phoneNumber'];
	$email = $_POST['email'];
	$paymentMode = $_POST['paymentMode'];
	$issuerCode = $_POST['issuerCode'];
	$cardHolderName = $_POST['cardHolderName'];
	$cardNumber = $_POST['cardNumber'];
	$expiryMonth = $_POST['expiryMonth'];
	$cardType = $_POST['cardType'];
	$cvvNumber = $_POST['cvvNumber'];
	$expiryYear = $_POST['expiryYear'];
	$returnUrl = $_POST['returnUrl'];
	$notifyUrl = $_POST['notifyUrl'];
	$orderAmount = $_POST['orderAmount'];

	$txtgender = $_POST['txtgender'];
	$txtocc = $_POST['txtocc'];
	$txtconame = $_POST['txtconame'];
	$txtcodesg = $_POST['txtcodesg'];
	$txtlandno = $_POST['txtlandno'];
	$txtdirectno = $_POST['txtdirectno'];
	$txtmobileno = $_POST['txtmobileno'];

	$sql = "UPDATE `userlogins` SET `firstname` = '$firstName',`lastname` = '$lastName', `gender` = '$txtgender', `occ` = '$txtocc', `comapany_name` ='$txtconame', `comapany_desg` = '$txtcodesg', `email_id` = '$email', `landno` = '$txtlandno', `directno` = '$txtdirectno', `mobileno` = '$phoneNumber', `address` = '$addressStreet1',    `updated_by` = 'online', `updated_dt` = NOW() WHERE `userlogins`.`user_id` = ".$_SESSION['id'];
	$result = mysqli_query($GLOBALS['con'],$sql);
		
	$flag = "post";
	$data = "$vanityUrl$orderAmount$merchantTxnId$currency";
	$secSignature = generateHmacKey($data,CitrusPay::getApiKey());
	$action = CitrusPay::getCPBase()."$vanityUrl";  
	$time = time()*1000;
	$time = number_format($time,0,'.','');
	$templateCode = "MTT001";
	$dpFlag = $_POST['dpFlag']; 
	/* $iscod = $_POST['COD']; */
	
	/*$customParamsName = $_POST['customParamsName'];*/
	/*$customParamsValue = $_POST['customParamsValue'];*/
}
?>

<script>
/*
function selectPaymentMode(val)
{
	if(val == "NET_BANKING")
	{
		document.getElementById('nonNB').style.display='none';
	}
	else if((val == "CREDIT_CARD" ) || (val == "DEBIT_CARD"))
	{
		document.getElementById('nonNB').style.display='';
		
	}
}
*/

function ValidateForm()
{	
	if (document.TransactionForm.firstName.value == '')
	{
		alert("Please enter your first name")
		document.TransactionForm.firstName.focus()
		return false
	}
	if (document.TransactionForm.lastName.value == '')
	{
		alert("Please enter your last name")
		document.TransactionForm.lastName.focus()
		return false
	}
	if (document.TransactionForm.email.value == '')
	{
		alert("Please enter your registered e-mail address")
		document.TransactionForm.email.focus()
		return false
	}
	if (document.TransactionForm.txtlandno.value == '')
	{
		alert("Please enter your Landline Number")
		document.TransactionForm.txtlandno.focus()
		return false
	}
	if (document.TransactionForm.phoneNumber.value == '')
	{
		alert("Please enter your Phone Number")
		document.TransactionForm.phoneNumber.focus()
		return false
	}
	    
	if (document.TransactionForm.addressState.value == '')
	{
		alert("Please enter state")
		document.TransactionForm.addressState.focus()
		return false
	}

	if (document.TransactionForm.addressCity.value == '')
	{
		alert("Please enter city")
		document.TransactionForm.addressCity.focus()
		return false
	}

	if (document.TransactionForm.addressZip.value == '')
	{
		alert("Please enter pin code")
		document.TransactionForm.addressZip.focus()
		return false
	}


	if (document.TransactionForm.orderAmount.value == '')
	{
		alert("Please enter order amount")
		document.TransactionForm.orderAmount.focus()
		return false
	}
	if (document.TransactionForm.paymentMode.value == '')
	{
		alert("Please select payment mode")
		document.TransactionForm.paymentMode.focus()
		return false
	}
	return true
}
</script>

 	<form action="<?php echo $action;?>" method="POST"  name="TransactionForm" id="transactionForm"  onSubmit="return ValidateForm()">

		<?php 
		if($flag == "post") {
		?>
		<input name="merchantTxnId" type="hidden" value="<?php echo $merchantTxnId;?>" />
		<input name="addressState" type="hidden"  value="<?php echo $addressState;?>" />
		<input name="addressCity" type="hidden" value="<?php echo $addressCity;?>" />
		<input name="addressStreet1"  type="hidden" value="<?php echo $addressStreet1;?>" />
		<input name="addressCountry" type="hidden" value="<?php echo $addressCountry;?>" />
		<input name="addressZip" type="hidden"  value="<?php echo $addressZip;?>" />
		<input name="firstName" type="hidden" value="<?php echo $firstName;?>" />
		<input name="lastName" type="hidden" value="<?php echo $lastName;?>" />
		<input name="phoneNumber" type="hidden" value="<?php echo $phoneNumber;?>" />
		<input name="email" type="hidden" value="<?php echo $email;?>" />
		<input name="paymentMode" type="hidden" value="<?php echo $paymentMode;?>" />
		<input name="issuerCode" type="hidden" value="<?php echo $issuerCode;?>" />
		<input name="cardHolderName"  type="hidden" value="<?php echo $cardHolderName;?>" />
		<input name="cardNumber" type="hidden"  value="<?php echo $cardNumber;?>" />
		<input name="expiryMonth" type="hidden" value="<?php echo $expiryMonth;?>" />
		<input name="cardType" type="hidden" value="<?php echo $cardType;?>" />
		<input name="cvvNumber" type="hidden" value="<?php echo $cvvNumber;?>" />
		<input name="expiryYear" type="hidden" value="<?php echo $expiryYear;?>" />
		<input name="returnUrl" type="hidden" value="<?php echo $returnUrl;?>" />
		<input name="notifyUrl" type="hidden" value="<?php echo $notifyUrl;?>" />
		<input name="orderAmount" type="hidden" value="<?php echo $orderAmount;?>" />
		<input name="templateCode" type="hidden"  value="<?php echo $templateCode;?>" />
		<input type="hidden" name="reqtime" value="<?php echo $time;?>" /> 
		<input type="hidden" name="secSignature" value="<?php echo $secSignature;?>" /> 
		<input type="hidden" name="currency" value="<?php echo $currency;?>" />
		<input type="hidden"  class="inputTxt" name="dpFlag" value="<?php echo $dpFlag; ?>" />
				<!-- Custom parameter section starts here. 
				You can omit this section if no custom parameters have been defined.
				Hidden field value should be the name of the parameter created in Checkout settings page.
				It should follow customParams[0].name, customParams[1].name .. naming convention.
				For each custom parameter created, a text field with the naming convention  
				customParams[0].value,customParams[1].value .. should be captured.
				Please refer below code snippet for passing parameters to SSL Page.
				Uncomment the for loop after the PHP tag to pass parameters to SSL Page
				
				Also refer the else part of this loop to see how to capture Custom Params on your website
				
				
				 -->
				<!-- Code for COD --> 
				<!-- <p>
					<label> COD </label><input name="COD" type="text"
						value="<?php //echo $iscod;?>" />
				</p> -->
				<?php 
					/* for($i=0;$i<count($customParamsName);++$i)
					{
					
					echo "<p><input type=\"hidden\" name=\"customParams[$i].name\" value=\"$customParamsName[$i]\" /></p>";
					echo "<p>$customParamsName[$i] <input type=\"text\" name=\"customParams[$i].value\" value=\"$customParamsValue[$i]\" /></p>";
					} */
				}
				else
				{

	  			$taxres = mysqli_query($GLOBALS['con'],"SELECT * FROM tax_master WHERE id='1'");
				$taxRow = mysqli_fetch_assoc($taxres);
				$taxSTname = $taxRow['taxname'];
				$taxSTval = $taxRow['percentage'];
				
				$taxres = mysqli_query($GLOBALS['con'],"SELECT * FROM tax_master WHERE id='2'");
				$taxRow = mysqli_fetch_assoc($taxres);
				$taxSBCname = $taxRow['taxname'];
				$taxSBCval = $taxRow['percentage'];
				
				$taxres = mysqli_query($GLOBALS['con'],"SELECT * FROM tax_master WHERE id='3'");
				$taxRow = mysqli_fetch_assoc($taxres);
				$taxOtherName = $taxRow['taxname'];
				$taxOtherVal = $taxRow['percentage'];
			?>

			<input type="hidden" id="taxST" value="<?php echo $taxSTval; ?>" />
			<input type="hidden" id="taxSBC" value="<?php echo $taxSBCval; ?>" />
			<input type="hidden" id="taxOther" value="<?php echo $taxOtherVal; ?>" />
	      
	    <?php 
		date_default_timezone_set('UTC');

		$currDate = date('dmYGis');
		//print_r($_SESSION);
		$merchantTxnIdGen = $_GET['p']."".$currDate."".$_SESSION['id'];
		$result = mysqli_query($GLOBALS['con'],"SELECT * FROM userlogins WHERE user_id=".$_SESSION['id']);
		
		$orderAmount = '';
		$orderAmountRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='".$_GET['p']."'");
		$orderAmountRow = mysqli_fetch_assoc($orderAmountRes);
		$orderAmountPackage = $orderAmountRow['pamount'];		
			
		$orderAmountRowST = $orderAmountPackage / 100 * $taxSTval;
		$orderAmountRowEC = $orderAmountPackage / 100 * $taxSBCval;
		//$orderAmountRowOther = $orderAmountRowST / 100 * $taxOtherVal;
		$orderAmountFinal = number_format ($orderAmountPackage + $orderAmountRowST + $orderAmountRowEC ,2, '.', '');
		$row = mysqli_fetch_assoc($result);

		?>
	<input type="hidden"  class="inputTxt" name="orderAmountPackage" id="orderAmountPackage"  value="<?php echo $orderAmountRow['pamount'];?>" />
	<input type="hidden"  class="inputTxt" name="addEmailAmountBase" id="addEmailAmountBase" value="<?php echo $orderAmountRow['addemailamount'];?>" />

	<input  class="inputTxt" name="merchantTxnId" type="hidden" value="<?PHP echo $merchantTxnIdGen; ?>" />
	<!-- <input  class="inputTxt" name="lastName" type="hidden" value="-" /> -->
	<input  class="inputTxt" name="returnUrl" type="hidden" value="http://www.vilgst.com/payments/Response.php" />
	<input  class="inputTxt" name="notifyUrl" type="hidden" value="http://www.vilgst.com/payments/Response.php" />
	<input type="hidden"  class="inputTxt" name="dpFlag" value="Yes" />

	<div class="col-md-7 table-container align-article">
	<fieldset class="form padding-t-20">
		<h3>Personal Details</h3>
	      	
			<label>First Name</label>
			<div class="form-group">
				<input  class="form-control" name="firstName" placeholder="First Name" type="text" value="<?php echo $row['firstname'];?>" />  				
			</div> 

			<label>Last Name</label>
			<div class="form-group">
				<input  class="form-control" name="lastName" placeholder="Last Name" type="text" value="<?php echo $row['lastname'];?>" />	
			</div> 

			<label>Company Name</label>
			<div class="form-group">
				<input class="form-control" type="text" name="txtconame" id="txtconame" placeholder="Company Name" value="<?php echo $row['comapany_name'];?>"/>		
			</div> 

			<label>Gender</label>
			<div class="form-group">
				<select class="form-control" name="txtgender" id="txtgender">
					<option value="M" <?php if($row['gender'] == "M") { echo "selected='selected'" ; } ?> >Male</option>
					<option value="F" <?php if($row['gender'] == "F") { echo "selected='selected'" ; }?> >Female</option>
				</select>			
			</div>

			<label>Email</label>
			<div class="form-group">
				<input  class="form-control" name="email" readonly="readonly" type="text" value="<?php echo $row['email_id'];?>" />			
			</div>

			<label>Occupation</label>
			<div class="form-group">
				<input class="form-control" type="text" name="txtocc" id="txtocc" placeholder="Occupation" value="<?php echo $row['occ'];?>"/>			
			</div>

			<label>Designation</label>
			<div class="form-group">
				<input class="form-control" type="text" name="txtcodesg" id="txtcodesg" placeholder="Company Designation" value="<?php echo $row['comapany_desg'];?>"/>
			</div>

			<label>Landline Number </label>
			<div class="form-group">
				<input class="form-control" type="text" name="txtlandno" id="txtlandno" placeholder="Landline Number" value="<?php echo $row['landno'];?>"/>			
			</div> 

			<label>Direct Number</label>
			<div class="form-group">
				<input class="form-control" type="text" name="txtdirectno" id="txtdirectno" placeholder="Direct Number" value="<?php echo $row['directno'];?>"/>			
			</div>

			<label>Mobile Number</label>
			<div class="form-group">
				<input  class="form-control" name="phoneNumber"  id="phoneNumber" type="text"	value="<?php echo $row['mobileno'];?>" />			
			</div>

			<label>Address</label>
			<div class="form-group">
				<textarea  class="form-control" name="addressStreet1" placeholder="Address"><?php echo $row['address'];?></textarea>			
			</div>

			<label>Country</label>
			<div class="form-group">
				<input  class="form-control" name="addressCountry" placeholder="Country" type="text" value="India" />			
			</div>

			<label>State</label>
			<div class="form-group">
				<input  class="form-control" name="addressState" type="text" placeholder="State" value="" />				
			</div>

			<label>City</label>
			<div class="form-group">
				<input  class="form-control" name="addressCity" type="text" placeholder="City" value="" />		
			</div>

			<label>Pin Code</label>
			<div class="form-group">
				<input  class="form-control" maxlength="6" name="addressZip" type="text" placeholder="Pin Code " value="" />			
			</div> 						
		</fieldset>	
	</div> 	

	<div class="col-md-8 table-container order-details">
	<fieldset class="form padding-t-20">
		<h3>Order Details</h3>
	      	
			<label>Package Name</label>
			<div class="form-group">
				<input  class="form-control" name="pdescription" readonly="readonly" type="text" value="<?php if($_GET['p']=='AHC') { echo 'Ad-hoc Amount'; } else { echo $orderAmountRow['pdescription']; } ?>" /> 				
			</div>

			<?php if($_GET['p']!='AHC') { ?>

			<label>Updates on additional Email-id<br /> No. of email-ids</label>
			<div class="form-group">
				<select  class="form-control" name="addemail" id="addemail" onchange="addemailCalc(this.value);" style="width:50px; text-align:center; float:left; margin-right:7px;" >
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
				<div style="float: left; margin-top: 8px;"> X <?php echo  $orderAmountRow['addemailamount']; ?> = <strong id="addemailamount">0.00</strong></div> 				
			</div>

			<label>Annual Subscription Fee (INR)</label>
			<div class="form-group">
				<label id="orderAmountPackage"><?php  echo number_format($orderAmountPackage ,2, '.', ''); ?></label>  				
			</div>

			<label>+ <?php echo $taxSTname; ?> @ <?php echo $taxSTval."%"; ?></label>
			<div class="form-group">
				<label id="orderAmountRowST"><?php echo number_format($orderAmountRowST ,2, '.', ''); ?></label>		
			</div>

			<label>+ <?php echo $taxSBCname; ?> @ <?php echo $taxSBCval."%"; ?></label>
			<div class="form-group">
				<label id="orderAmountRowEC"><?php  echo number_format($orderAmountRowEC ,2, '.', ''); ?></label>
			</div>

			<!-- <label>+ <?php echo $taxOtherName; ?> @ <?php echo $taxOtherVal."%"; ?></label>
			<div class="form-group">
				<label id="orderAmountRowOther"><?php  echo number_format($orderAmountRowOther ,2, '.', '');  ?></label>			
			</div>
 -->
			<?PHP } ?>

			<label>Total Payable Amount (INR) </label>
			<div class="form-group">
				<input  class="form-control" name="orderAmount" id="orderAmount" <?php if($_GET['p']!='AHC') { echo 'readonly="readonly"'; } ?>  style="font-size:14px; font-weight:bold; text-align:right; " type="text" 
				value="<?php echo number_format($orderAmountFinal ,2, '.', '');    ?>" />  	
			</div>

			<label>Payment Mode</label>
			<div class="form-group">
				<select  class="form-control" name="paymentMode" >
					<option value="">Select Payment Mode</option>
					<option value="NET_BANKING">NetBanking</option>
					<option value="CREDIT_CARD">Credit Card</option>
					<option value="DEBIT_CARD">Debit Card</option>
				</select>			
			</div>

			<div id="nonNB" style="display:none">

				<label>Issuer Bank </label>
				<div class="form-group">
					<select  class="form-control" name="issuerCode" >
						<option value="">Select One</option>
						<option value="CID001">ICICI Bank</option>
						<option value="CID002">AXIS Bank</option>
						<option value="CID003">Citibank</option>
						<option value="CID004">YES Bank</option>
						<option value="CID005">SBI Bank</option>
						<option value="CID006">Deutsche Bank</option>
						<option value="CID007">Union Bank</option>
						<option value="CID008">Indian Bank</option>
						<option value="CID009">Federal Bank</option>
						<option value="CID010">HDFC Bank</option>
						<option value="CID011">IDBI Bank</option>
						<option value="CID012">State Bank of    Hyderabad</option>
						<option value="CID013">State Bank of Bikaner    and Jaipur</option>
						<option value="CID014">State Bank of Mysore</option>
						<option value="CID015">State Bank of    Travancore</option>
						<option value="CID016">Andhra Bank</option>
						<option value="CID017">Bank of Bahrain &amp; Kuwait</option>
						<option value="CID018">Bank of Baroda    Corporate Accounts</option>
						<option value="CID019">Bank of India</option>
						<option value="CID020">Bank of Baroda Retail    Accounts</option>
						<option value="CID021">Bank of Maharashtra</option>
						<option value="CID022">Catholic Syrian Bank</option>
						<option value="CID023">Central Bank of India</option>
						<option value="CID024">City Union Bank</option>
						<option value="CID025">Corporation Bank</option>
						<option value="CID026">DCB Bank ( Development    Credit Bank )</option>
						<option value="CID027">Indian Overseas Bank</option>
						<option value="CID028">IndusInd Bank</option>
						<option value="CID029">ING Vysya Bank</option>
						<option value="CID030">Jammu &amp; Kashmir    Bank</option>
						<option value="CID031">Karnataka Bank</option>
						<option value="CID032">KarurVysya Bank</option>
						<option value="CID033">Kotak Mahindra Bank</option>
						<option value="CID034">Lakshmi Vilas Bank    NetBanking</option>
						<option value="CID035">Oriental Bank of    Commerce</option>
						<option value="CID036">Punjab National Bank    Corporate Accounts</option>
						<option value="CID037">South Indian Bank</option>
						<option value="CID038">Standard Chartered    Bank</option>
						<option value="CID039">Syndicate Bank</option>
						<option value="CID040">Tamilnad Mercantile    Bank</option>
						<option value="CID041">United Bank of India</option>
						<option value="CID042">Vijaya Bank</option>
						<option value="CID043">State Bank of Patiala</option>
						<option value="CID044">Punjab National Bank    Retail Accounts</option>
					</select>
				</div>

				<label>Card Holder Name</label>
				<div class="form-group">
					<input  class="form-control" name="cardHolderName" type="text" value="" />
				</div>

				<label>Card Number</label>
				<div class="form-group">
					<input  class="form-control" name="cardNumber" type="text" value="" />
				</div>

				<label>Card Expiry (MM/YYYY)</label>
				<div class="form-group">
					<input  class="form-control" style="width:20px" maxlength="2" name="expiryMonth" type="text" value="" />
					<input  class="form-control" style="width:50px" maxlength="4" name="expiryYear" type="text" value="" />
				</div>

				<label>Card Type</label>
				<div class="form-group">
					<input  class="form-control" name="cardType" type="text" value="" />
				</div>

				<label>CVV Number </label>
				<div class="form-group">
					<input  class="form-control" name="cvvNumber" type="text" value="" />
				</div>

			</div>
			
	</fieldset>
	</div>

<!-- COD section END -->
	<div class="col-md-8 t-margin-10 table-container">
		<fieldset class="form padding-t-20">
			<div class="pull-right">
				<input type="submit" name="submit" class="btn btn-lg-big btn-success" value="Place Order" />
			</div>
			<div class="clear padding-t-20"></div>

			<div>If you have opted for updates on additional email IDs, Please send all such email IDs at <a href="mailto:support@vatinfoline.com">support@vatinfoline.com</a></div>
		</fieldset>
	</div>	
<?php } ?>
	</form>

<?php  if($flag == "post") { ?>
<script type="text/javascript">
	document.getElementById("transactionForm").submit();
</script>
<?php  } ?>

<script>
	function addemailCalc(val) {
		var value2 = $("#addEmailAmountBase").val();
		var addemailres =  eval(val) * eval(value2);
		$("#addemailamount").text(addemailres .toFixed(2));
		
		var taxST = $("#taxST").val();
		var taxSBC = $("#taxSBC").val();
	//	var taxOther = $("#taxOther").val();
	     
		
		var orderAmountPackage = $("#orderAmountPackage").val();
		var orderAmountRowST = (eval(orderAmountPackage) + eval(addemailres))  / 100 * eval(taxST);
		var orderAmountRowEC = (eval(orderAmountPackage) + eval(addemailres))  / 100 * eval(taxSBC);
		//var orderAmountRowOther = eval(orderAmountRowST) / 100 * eval(taxOther);	
		var orderAmount = eval(orderAmountPackage) + eval(addemailres) + eval(orderAmountRowST) +  eval(orderAmountRowEC) ;
		//alert(orderAmount + " - " +orderAmountRowST  + " - " + orderAmountRowEC + " - " + orderAmountRowOther);
		$("#orderAmountRowST").text(orderAmountRowST .toFixed(2));
		$("#orderAmountRowEC").text(orderAmountRowEC .toFixed(2));
		//$("#orderAmountRowOther").text(orderAmountRowOther .toFixed(2));
		$("#orderAmount").val(orderAmount .toFixed(2));

	}
</script>

<?php  } else {  
  
		include('../loggedInError.php');
	
  } ?>
</div>

<?php include('../footer.php') ?>

