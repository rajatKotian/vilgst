<?php 

$page = 'paidService';

include('../header.php') ?>

<?php


$payment_request_id = $_GET[payment_request_id];
$paymentid = $_GET[payment_id];

echo($_SESSION['TXNS_ID']);
if ($_SESSION['TXNS_ID'] == $_GET['payment_request_id']) {
	echo"<div class='alert alert-success col-md-6 offset-3'>
			Payment Successful
		</div>";
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
$companyname = "";

$flag = "dataValid";







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

$flag = '';
$payment_status = '';
if($GET[payment_status] == `Credit`) {
   $payment_status = "SUCCESS"; 
}
else {
    $payment_status ="CANCELED";
}

 $sql = "UPDATE `payment_history` SET `txnstatus` = '$payment_status',`txnmsg` = '$payment_status', `signature` = '$paymentid'  WHERE `payment_history`.`txnrefno` = '$payment_request_id' ";
	$result = mysqli_query($GLOBALS['con'],$sql);
	$selectionnQuery = "Select txnid, txnrefno, txnstatus, txnmsg, paymentdate, amount, firstName, lastName, email, mobileNo, signature, street1, city, state, country, pincode from payment_history where txnrefno = '$payment_request_id' ";
    $result_primary = mysqli_query($GLOBALS['con'],$selectionnQuery);
            while ($r = mysqli_fetch_assoc($result_primary)) {
                $txnid = $r['txnid'];
                $txnrefno = $r['txnrefno'];
                $txnstatus = $r['txnstatus'];
                $txnmsg = $r['txnmsg'];
                $firstName = $r['firstName'];
                $lastName = $r['lastName'];
                $email = $r['email'];
                $street1 = $r['street1'];
                $city = $r['city'];
                $state = $r['state'];
                $country = $r['country'];
                $pincode = $r['pincode'];
                $mobileNo = $r['mobileNo'];
                $signature = $r['signature'];
                $amount = $r['amount'];

            }
    $selectionnQuery1 = "Select comapany_name from userlogins where user_id = '$userid' ";
    $result_primary1 = mysqli_query($GLOBALS['con'],$selectionnQuery1);
            while ($r = mysqli_fetch_assoc($result_primary1)) {
                $companyname = $r['comapany_name'];

            }        


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

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Company Name: </label></th>

                        <td>  $companyname </td>

                    </tr>

					<tr>

                    	<th  style='font-weight:bold;background-color:#af4013;text-align:right;color:#fff'><label>Payment Gateway ID: </label></th>

                        <td>  $signature </td>

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

$mailheaders1 .= 'Cc: samir@vilgst.com' . "\r\n";

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

                    	<th><label>Company Name: </label></th>

                        <td> <?php echo $companyname;?> </td>

                    </tr>
                    <tr>

                    	<th><label>Payment Gateway ID: </label></th>

                        <td> <?php echo $signature;?> </td>

                    </tr>
				</table>

					

					
				 

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







