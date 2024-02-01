<?php

  $page = 'homePage';
$seoTitle = 'Clients';
$seoKeywords = 'Clients';
$seoDesc = 'Clients';
  include('header.php');

?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">

      <h1>Clients
      		<ol class="breadcrumb">

		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

		        <li class="active">Clients</li>

	      </ol>

      </h1>

      <div class="col-md-16">

      	<div class="row">

	      	<div class="col-md-8 panel panel-default">

			  <div class="panel-body">

			   	<strong>The purpose of every business and organization is to get and keep customers</strong>

			  </div>

			  <div class="panel-footer"><em class="pull-right">- Shep Hyken</em></div>

			</div>

      	 </div>

		<br />

		<p>Our client list is testimony to quality of service we deliver. It gives us immense pleasure acknowledge that many Fortune 500 companies, large to mid-size Corporates, major business houses, Tax Consultants, CA & Advocates and Commercial Taxes Department of various States, are our subscribing member. A brief list our clients is as below: </p>

		<br />		 

		<div class='table-container'>

			<table class='table table-hover' >

				<tr> 

					<td>

						<ul class="client-list">

							<?php 

								$client=mysqli_query($GLOBALS['con'],"SELECT * FROM client ORDER BY cname"); 

							     while($fetch=mysqli_fetch_array($client)) {

							?>

							<li><?php echo $fetch['cname']; ?></li>

							<?php } ?>

						</ul>

					</td>

				</tr>

			</table>

		</div>



		   

      </div> 



    </div>

    <!-- left sec end --> 



<?php 

  include('footer.php');

?>
