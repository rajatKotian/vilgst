<?php

  $page = 'subscription';
$seoTitle = 'Online Subscription';
$seoKeywords = 'Online Subscription';
$seoDesc = 'Online Subscription';
  include('header.php');

?>

 <!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">   	    

    <div class="col-md-16 col-sm-16">

    <div class="row">

		<h1>online subscription

			<ol class="breadcrumb">

	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

	        <li class="active">online subscription</li>

		  </ol>

		</h1>

	</div>	

    </div>



	<div class="col-md-16">

		<div class="row">

			<div class="col-md-8 panel panel-default">

			  <div class="panel-body">

			   	<strong>Price is what you pay, Value is what you get</strong>

			  </div>

			  <div class="panel-footer"><em class="pull-right">- Warren Buffett </em></div>

			</div>

		</div><br /> 	

		<p>Our subscription modules have been designed to give you best value for your money. It gives dual advantages of reasonable pricing combined with timely and regular email updates in the area of GST, VAT, Central Excise, Service Tax and Customs.</p>

		<div class="col-md-16 table-container packages-details">

			<form class="form">

				<h2>Terms and Conditions</h2>

				<p>By subscribing you agree with following Terms and Conditions:</p>

				

				<ul class="list-unstyled">

					<li>Subscription expires upon the expiry of the allotted web accesses or period of subscription, whichever is earlier.</li>

					<li>Subscriber is NOT permitted to forward our email updates to recipient outside the organization/firm or to multiple users within the company/firm. Doing so will lead to termination of service without any refund.</li>

					<li>We don't send email updates on generic email-id i.e. accounts@xyz.com / tax@abc.com etc</li>

					<li>All contents are owned by VATinfoline Multimedia. You may not modify, publish, transmit, transfer, sell, reproduce, create derivative work, distribute, report or in any way commercially exploit any of its content.</li>

					<li>One subscription is valid for only one location - Group companies / offices located at different locations are required to take separate subscriptions for use at each location.</li>

					<li>VATinfoline Multimedia reserves the right to suspend services if subscriber is found violating any of above mentioned terms and conditions.</li>

					<li>VATinfoline Multimedia retains the right and discretion to amend the content of any module anytime during the subscription period; and it cannot be construed as an infringement of rights of any subscriber.</li>

					<li>Email updates will be sent as attachment and/or downloadable hyperlink depending on the file size.   </li>

				</ul>

			</form>	 

		</div> 

		<div class="packages-container">

		 	<ul>

		 		<div class="col-md-16">	   			



				    <div class="col-md-8">

			   			<li class="package-box">



						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='ITP'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <strong>[GST + VAT + Central Excise + Service Tax + Customs]</strong>

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="itpAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=ITP">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>

				    <div class="col-md-8">

			   			<li class="package-box">



						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='CP'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <strong>[GST + VAT + Central Excise + Service Tax]</strong>

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="cpAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=CP">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>

				</div>

				<div class="col-md-16 " style="display: none">



					<div class="col-md-4">

			   			<li class="package-box">

						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='VUM'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="vatAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=VUM">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>

				    <div class="col-md-4">

			   			<li class="package-box">

						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='CEM'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="ceAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=CEM">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>

				    <div class="col-md-4">

			   			<li class="package-box">

						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='STM'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="stAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=STM">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>

				    <div class="col-md-4">

			   			<li class="package-box">

						<?php $packageRes = mysqli_query($GLOBALS['con'],"SELECT * FROM package_master WHERE pname='CM'");

									$packageRow = mysqli_fetch_assoc($packageRes);

						?>

					        <h2><?php echo $packageRow['pdescription']; ?></h2>



					        <div>    

						        <h3><strong>Rs.</strong> <?php $pamount = number_format ($packageRow['pamount'],2, '.', ','); echo  $pamount;	?></h3>

						        <h6>(+ GST)</h6> <br>

						        <h6 class="package-email-id"><span style="display:none"><input type="checkbox" name="cmAddEmail" /></span><span> [additional email-id @ <?php echo $packageRow['addemailamount']; ?>+GST]</span></h6>             

						        <div class="clear"></div>

						        <a href="payments/vilssl.php?p=CM">Subscribe Now</a>

					        </div>					     	

					    </li>

				    </div>



				</div>

		   		 <div class="col-md-8 adhoc-amount">

		   			<li class="package-box">

		   				<h2>Ad-hoc Amount</h2>

				        <div>

				        	<a href="payments/vilssl.php?p=AHC">SUBSCRIBE NOW [Confirm with us before using this option]</a>

				        </div>					     	

				    </li>

			    </div>    

		    </ul>

	    </div>

	</div> 

	<div class="clear"></div> 

	 

	<div class="col-md-10 table-container packages-details" style="display: none">

		<form class="form">

			<h2>VAT UPDATE MODULE</h2>

			<p>This  module keeps you up-to-date with all critical information related with Value  Added Tax. It is an email-based service combined with web access to our  database. This also includes all updates on GST. Given below is the detail of  service:</p>

			

			<h4>EMAILING  OF FOLLOWING VAT UPDATES</h4>

			<ul class="list-unstyled">

				<li>Notifications and Circulars from across the  states</li>

				<li>Supreme Court &amp; High Court judgements </li>

				<li>Amendments in VAT Rules, Acts and Regulation</li>

				<li>Amendments in VAT Rate/Schedule &amp; Forms</li>

				<li>Latest news updates and researched articles  on VAT/GST</li>

				<li>Regular updates on implementation status of  Goods and Services Tax</li>

				<li>Access to our online database</li>

			</ul>

		</form>	    

	</div>

	

	<div class="col-md-10 table-container packages-details" style="display: none">

		<form class="form">

			<h2>CENTRAL EXCISE MODULE</h2>

	  		<p>As a subscriber to our services you get the dual benefit of timely updates and information from both Central as well as State level, all under one roof. Our CENTRAL EXCISE package will include following services:</p>



	  		<h4>EMAILING  OF FOLLOWING CENTRAL EXCISE UPDATES:</h4>

			<ul class="list-unstyled">

				<li>Notifications and Circulars from MoF/CBEC</li>

				<li>Amendment to Central Excise Act and Rules</li>

				<li>Supreme Court, High Court, CESTAT and AAR judgment</li>

				<li>Latest news updates and researched articles</li>

				<li>Apart from these you may also send us request for your specific requirement e.g. request for any previous circular/notification or judgement etc.</li>

				<li>Access to our online database</li><p></p>

			</ul>

		</form>

	</div>

	

	<div class="col-md-10 table-container packages-details" style="display: none">

		<form class="form">

			<h2>SERVICE TAX MODULE</h2>

	  		<p>We offer following services in the area of Service Tax:</p>



	  		<h4>EMAILING  OF FOLLOWING SERVICE TAX UPDATES:</h4>

			<ul class="list-unstyled">

				<li>Notifications and Circulars from CBEC/MoF</li>

				<li>Supreme Court, High Court, CESTAT and AAR judgment</li>

				<li>Service Tax Forms issued by CBEC </li>

				<li>Latest news updates and researched articles</li>

				<li>Service Tax procedures and tariffs</li>

				<li>Access to our online database</li><p></p>

			</ul>

		</form>

	</div>



	<div class="col-md-16 table-container packages-details">

		<form class="form">

  			<h4>Annual Subscription Fees (Updates on only one email-id)</h4>

  			<p>Payment can also be made by Cheque/Demand Draft drawn in favor of VATINFOLINE MULTIMEDIA or NEFT/direct deposit to our bank account. Please note all subscriptions are on annual basis as per calendar year. For any query or clarification please call us at: <h4>+22 25881396 / 09833019272 / 08104690026<h4> or email us at <a href="mailto:sales@vilgst.com">sales@vilgst.com</a> </p>

  		</form>	

  	</div> 



	<div class="col-md-16 table-container packages-details align-center">

		<form class="form">

	  		<h4>We Accept Netbanking Transactions from-</h4>

	  		<p><img src="images/weAcceptLogos.jpg" style="width:100%;" class="list-spacing"/></p>

	  	</form>

	</div>

</div>

<?php 

  include('footer.php');

?>
