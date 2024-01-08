<?php 

$page = 'paidService';

include('../header.php') ?>

<?php



set_include_path('../lib'.PATH_SEPARATOR.get_include_path());

require_once 'Zend/Crypt/Hmac.php';



function generateHmacKey($data, $apiKey=null){

	$hmackey = Zend_Crypt_Hmac::compute($apiKey, "sha1", $data);

	return $hmackey;

}



$txnid = "";

$txnrefno = "";

$txnstatus = "";

$txnmsg = "";

$firstName = "";

$lastName = "";

$email = "";

$street1 = "";

$city = "";

$state = "";

$country = "";

$pincode = "";

$mobileNo = "";

$signature = "";

$reqsignature = "";

$data = "";

$txnGateway = "";

$paymentMode = "";

$maskedCardNumber = "";

$cardType = "";

$flag = "dataValid";



if(isset($_POST['TxId']))

{

	$txnid = $_POST['TxId'];

	$data .= $txnid;

}

if(isset($_POST['TxStatus']))

{

	$txnstatus = $_POST['TxStatus'];

	$data .= $txnstatus;

}

if(isset($_POST['amount']))

{

	$amount = $_POST['amount'];

	$data .= $amount;

}

if(isset($_POST['pgTxnNo']))

{

	$pgtxnno = $_POST['pgTxnNo'];

	$data .= $pgtxnno;

}

if(isset($_POST['issuerRefNo']))

{

	$issuerrefno = $_POST['issuerRefNo'];

	$data .= $issuerrefno;

}

if(isset($_POST['authIdCode']))

{

	$authidcode = $_POST['authIdCode'];

	$data .= $authidcode;

}

if(isset($_POST['firstName']))

{

	$firstName = $_POST['firstName'];

	$data .= $firstName;

}

if(isset($_POST['lastName']))

{

	$lastName = $_POST['lastName'];

	$data .= $lastName;

}

if(isset($_POST['pgRespCode']))

{

	$pgrespcode = $_POST['pgRespCode'];

	$data .= $pgrespcode;

}

if(isset($_POST['addressZip']))

{

	$pincode = $_POST['addressZip'];

	$data .= $pincode;

}

if(isset($_POST['signature']))

{

	$signature = $_POST['signature'];

}

/*signature data end*/



if(isset($_POST['TxRefNo']))

{

	$txnrefno = $_POST['TxRefNo'];

}

if(isset($_POST['TxMsg']))

{

	$txnmsg = $_POST['TxMsg'];

}

if(isset($_POST['email']))

{

	$email = $_POST['email'];

}

if(isset($_POST['addressStreet1']))

{

	$street1 = $_POST['addressStreet1'];

}

if(isset($_POST['addressStreet2']))

{

	$street2 = $_POST['addressStreet2'];

}

if(isset($_POST['addressCity']))

{

	$city = $_POST['addressCity'];

}

if(isset($_POST['addressState']))

{

	$state = $_POST['addressState'];

}

if(isset($_POST['addressCountry']))

{

	$country = $_POST['addressCountry'];

}



if(isset($_POST['mandatoryErrorMsg']))

{

	$mandatoryerrmsg = $_POST['mandatoryErrorMsg'];

}

if(isset($_POST['successTxn']))

{

	$successtxn = $_POST['successTxn'];

}

if(isset($_POST['mobileNo']))

{

	$mobileNo = $_POST['mobileNo'];

}

if(isset($_POST['txnGateway']))

{

	$txnGateway = $_POST['txnGateway'];

}

if(isset($_POST['paymentMode']))

{

	$paymentMode = $_POST['paymentMode'];

}

if(isset($_POST['maskedCardNumber']))

{

	$maskedCardNumber = $_POST['maskedCardNumber'];

}

if(isset($_POST['cardType']))

{

	$cardType = $_POST['cardType'];

}



$respSignature = generateHmacKey($data,"94913099f8929255cf6991421d4a4b6e7cca90ac");



if($signature != "" && strcmp($signature, $respSignature) != 0)

{

	$flag = "dataTampered";

}



?>

<div class="col-md-16 col-sm-16">

   <h1>Payment Response

  		<ol class="breadcrumb">

           <li><a href="/index.php">Home</a></li>

           <li class="breadCrumbsSprt">&gt;</li>

           <li>Payment Response</li>

       </ul>

   

   </h1>

	<div class="table-container" style="width: 100%; padding: 20px !important">

		<?php 

					if($flag == "dataValid")

					{

	
$curDate = date("Y/m/d");

$userid = $_SESSION['id'];	

	$strQuery = "insert into payment_history (
	`userid`,
	`txnid`,
	`txnrefno`,
	`txnstatus`,
	`txnmsg`,
	`paymentdate`,
	`amount`,
	`firstName`,
	`lastName`,
	`email`,
	`street1`,
	`city`,
	`state`,
	`country`,
	`pincode`,
	`mobileNo`,
	`signature`,
	`reqsignature`,
	`txnGateway`,
	`paymentMode`,
	`maskedCardNumber`,
	`cardType` )  values (

	'$userid',
	'$txnid',
	'$txnrefno',
	'$txnstatus',
	'$txnmsg',
	NOW(),
	'$amount',
	'$firstName',
	'$lastName',
	'$email',
	'$street1',
	'$city',
	'$state',
	'$country',
	'$pincode',
	'$mobileNo',
	'$signature',
	'$reqsignature',
	'$txnGateway',
	'$paymentMode',
	'$maskedCardNumber',
	'$cardType' )";

   $result =  mysqli_query($GLOBALS['con'],$strQuery);
$flag = '';
// echo '<div style="display: none">'.$strQuery.'</div>';

// 	if($result)
// {
// echo "s";

// }
// else
// {
// echo "e";

// }

	/* Mail Start */

	

	        

                                

                            

                                

  



$message1 = "<html>

<head>

<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

<title>| VATinfoline | Updates on VAT, Service Tax, Central Excise & GST</title>

 </head>



<body>

 

 <h3>Payment Confirmation</h3>

                    <table  width='100%' cellspacing='0' cellpadding='10' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#868F98;background-color:#EEE;border-collapse:collapse;border:2px solid #9cae3d'>

                    <tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'>Txn Id</th>

                        <th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'>Txn Ref No</th>

                        <th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'>Txn Status</th>

                        <th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'>Txn Message</th>

                        <th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'>Amount</th>

                    </tr>

                    <tr>

                    	<td>$txnid</td>

                        <td>$txnrefno</td>

                        <td>$txnstatus</td>

                        <td>$txnmsg</td>

                        <td>$amount</td>

                    </tr>

                    </table>

					<hr />

                    

					<h3>Consumer Details:</h3>

                    

                    <table  width='100%' cellspacing='0' cellpadding='10' border='0' style='font-family:Calibri, Tahoma,Verdana,sans-serif;font-size:13px;color:#422b03;background-color:#faf8f4 ;border-collapse:collapse;border:2px solid #832f0c'>

                    <tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>First Name: </label> </th>

                        <td>$firstName</td>

                    </tr>

                    <tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Last Name: </label> </th>

                        <td>  $lastName</td>

                    </tr>

                    <tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Email: </label> </th>

                        <td> $email</td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Address: </label></th>

                        <td>  $street1 </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>City: </label></th>

                        <td>  $city </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>State: </label></th>

                        <td>  $state </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Country: </label></th>

                        <td>  $country </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Zip Code: </label></th>

                        <td>  $pincode </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Mobile Number: </label></th>

                        <td>  $mobileNo </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Payment Mode: </label></th>

                        <td>  $paymentMode </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Transaction gateway: </label></th>

                        <td>  $txnGateway </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Masked Card Number: </label></th>

                        <td>  $maskedCardNumber </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Card Type: </label></th>

                        <td>  $cardType </td>

                    </tr>

				</table>

</body>

</html>

";



$mailheaders  = 'MIME-Version: 1.0' . "\r\n";

$mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$mailheaders .= 'To: samir@vilgst.com' . "\r\n";

$mailheaders .= 'From: ' . '$email' ."\r\n";

$mailheaders .= 'Cc: ' . "\r\n";

$mailheaders .= 'Bcc: ' . "\r\n";



$mailheaders1  = 'MIME-Version: 1.0' . "\r\n";

$mailheaders1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$mailheaders1 .= 'To: support@vilgst.com' . "\r\n";

$mailheaders1 .= 'From: ' . '$email' ."\r\n";

$mailheaders1 .= 'Cc: ' . "\r\n";

$mailheaders1 .= 'Bcc: ' . "\r\n";









mail ('samir@vilgst.com','Payment Confirmation',$message1,$mailheaders);

mail ('support@vilgst.com','Payment Confirmation',$message1,$mailheaders1);



				   

	/* Mail End*/

	

					?>

					<?php if($txnstatus == 'SUCCESS') { ?> 
					<div class="alert alert-success always-show" > Thank you for the payment. ! </div> 
					<?php } else if($txnstatus == 'CANCELED') { ?>
					<div class="alert alert-warning always-show" > Your payment has failed. Please try again ! </div> 
					<?php } ?>

					<h3>Transaction Response</h3>

                    <table class="table table-hover">

                    <tr>

                    	<th>Txn Id</th>

                        <th>Txn Ref No</th>

                        <th>Txn Status</th>

                        <th>Txn Message</th>

                        <th>Amount</th>

                    </tr>

                    <tr>

                    	<td><?php echo $txnid;?></td>

                        <td><?php echo $txnrefno;?></td>

                        <td><?php echo $txnstatus;?></td>

                        <td><?php echo $txnmsg;?></td>

                        <td><?php echo $amount;?></td>

                    </tr>

                    </table>

					<hr />

                    

					<h3>Consumer Details:</h3>

                    

                    <table class="table table-hover">

                    <tr>

                    	<th><label>First Name: </label> </th>

                        <td><?php echo $firstName;?></td>

                    </tr>

                    <tr>

                    	<th><label>Last Name: </label> </th>

                        <td> <?php echo $lastName;?></td>

                    </tr>

                    <tr>

                    	<th><label>Email: </label> </th>

                        <td><?php echo $email;?></td>

                    </tr>

					<tr>

                    	<th><label>Address: </label></th>

                        <td> <?php echo $street1;?> </td>

                    </tr>

					<tr>

                    	<th><label>City: </label></th>

                        <td> <?php echo $city;?> </td>

                    </tr>

					<tr>

                    	<th><label>State: </label></th>

                        <td> <?php echo $state;?> </td>

                    </tr>

					<tr>

                    	<th><label>Country: </label></th>

                        <td> <?php echo $country;?> </td>

                    </tr>

					<tr>

                    	<th><label>Zip Code: </label></th>

                        <td> <?php echo $pincode;?> </td>

                    </tr>

					<tr>

                    	<th><label>Mobile Number: </label></th>

                        <td> <?php echo $mobileNo;?> </td>

                    </tr>

					<tr>

                    	<th><label>Payment Mode: </label></th>

                        <td> <?php echo $paymentMode;?> </td>

                    </tr>

					<tr>

                    	<th><label>Transaction gateway: </label></th>

                        <td> <?php echo $txnGateway;?> </td>

                    </tr>

					<tr>

                    	<th><label>Masked Card Number: </label></th>

                        <td> <?php echo $maskedCardNumber;?> </td>

                    </tr>

					<tr>

                    	<th><label>Card Type: </label></th>

                        <td> <?php echo $cardType;?> </td>

                    </tr>

				</table>

					

						<?php 

						/* Suppose a Custom parameter by name Roll Number Comes in Post Parameter.

						 * then we need to retreive the RollNumber as

						 * $rollNumber = $_POST['Roll Number'];

						 * and the display the response value as shown in below HTML This code 

						 * can be added n times for n number of Custom Parameters*/

						?>

						<!-- <li class="clearfix"><label>Roll Number </label> <?php //echo $rollNumber;?>

						</li>  -->

				 

					<?php 

					}

					else

					{

					?>

						<h3>Signature mismatch!!!</h3>

					<?php 	

					}

					?>

  </div>  

</div> 

   



<?php include('../footer.php') ?>







