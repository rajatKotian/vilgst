<?php 
	$page = '';
	include('header.php');
// 	ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div id="show_gst_rate" style="display: none;"></div>
    <div class="col-md-11 col-sm-9 left-section main_div">
      <h1>
      	<?php 
 	    	$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
       		$rowProdname = mysqli_fetch_array($getProdname);
			echo $rowProdname['prod_name'];
			echo ' - ';
		    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
			echo $rowSubProdname['sub_prod_name'];
		 
			if(isset($_GET["sub_subprod_id"])) {
				if($_GET["sub_subprod_id"]=='T') {
					echo ' - Tariff ';
				} else if($_GET["sub_subprod_id"]=='NT') {
					echo ' - Non-Tariff ';
				}
			}
			if(isset($_GET["year"])) {
				echo ' - '.$_GET['year'];
			}
		?>
 
      	  <ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active">
	        	<?php 
	        		$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
	       			$rowProdname = mysqli_fetch_array($getProdname);
					echo $rowProdname['prod_name'];

					if(isset($_GET['sub_prod_id'])) { 
						 
	                    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
			       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
						echo ' - '.$rowSubProdname['sub_prod_name'];             
					}
				?>
			</li>
	      </ol>
      </h1>
      <div class="col-md-16 <?php echo 'prod_'.$_GET['prod_id']; ?>">

      <?php 
		if(isLogeedIn()) {
			if($_SESSION["userStatus"]=="expired") {
				include('expiredUserError.php'); 
			} else {
		?>
      	<div class="alert alert-warning"><h6>Please select year</h6></div>

 		<?php
			$prod = $_GET["prod_id"];
			$subprod = $_GET["sub_prod_id"];

			$getDbRecord = getDbRecord('product', 'prod_id', $prod);
			$dataType = $getDbRecord['dbsuffix']; 

			$tableName = 'casedata_'.$dataType;					

		$sql = "SELECT 	DISTINCT(year(circular_date))'year'
						FROM $tableName 
						WHERE prod_id = $prod
						AND sub_prod_id = $subprod
						ORDER BY circular_date DESC";	
						

		$result = mysqli_query($GLOBALS['con'],$sql);

		if(mysqli_num_rows($result) == 0) {   

			echo "<div class='alert alert-danger'>No Data Found</div>";

		} else {
			$fields_num = mysqli_num_fields($result);	

			echo "<ul class='boxed-list'>";	
			
			while($row = mysqli_fetch_array($result)) {
				
				if($subprod==21) {
				  echo "<li class='padding-b-15' style='width: 50%; ' >
				  			<div class='table-container'>
				  			<h3 class='t-margin-10'>{$row['year']}</h3>
				  			<ul class='boxed-list'>";
							echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=T&year={$row['year']}&s=0&e=20'>Tariff</a></li>";
					  		echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=NT&year={$row['year']}&s=0&e=20'>Non-Tariff</a></li>";
							echo "</ul>
							</div>
						</li>";  
 				} else if($subprod==35) {
				  echo "<li class='padding-b-15' style='width: 100%; ' >
				  			<div class='table-container'>
				  			<h3 class='t-margin-10'>{$row['year']}</h3>
				  			<ul class='boxed-list'>";
					  			echo "<li style='width:20%'><a style='width:90%;' href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=T&year={$row['year']}&s=0&e=20'>Tariff</a></li>";
					  			echo "<li style='width:20%'><a style='width:90%;' href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=NT&year={$row['year']}&s=0&e=20'>Non-Tariff</a></li>";
					  			echo "<li style='width:20%'><a style='width:90%;' href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=SG&year={$row['year']}&s=0&e=20'>Safeguards</a></li>";
					  			echo "<li style='width:20%'><a style='width:90%;' href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=ADD&year={$row['year']}&s=0&e=20'>Anti Dumping Duty</a></li>";
					  			echo "<li style='width:20%'><a style='width:90%;' href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=OTHERS&year={$row['year']}&s=0&e=20'>Others</a></li>";
							echo "</ul>
							</div>
						</li>";  
 				} else if($subprod==22  || $subprod==36) {
 				   echo "<li class='padding-b-15' style='width: 50%; ' >
				  			<div class='table-container'>
				  			<h3 class='t-margin-10'>{$row['year']}</h3>
				  			<ul class='boxed-list'>";
					  			echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=C&year={$row['year']}&s=0&e=20' >Circulars</a></li>";
					  			echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=I&year={$row['year']}&s=0&e=20' >Instructions</a></li>";
							echo "</ul>
							</div>
						</li>";  			 
				} else if($subprod==63  || $subprod==73 || $subprod==84) {
 				   echo "<li class='padding-b-15' style='width: 50%; ' >
				  			<div class='table-container'>
				  			<h3 class='t-margin-10'>{$row['year']}</h3>
				  			<ul class='boxed-list'>";
					  			echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=N&year={$row['year']}&s=0&e=20' >Notification</a></li>";
					  			echo "<li style='width:50%'><a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=RN&year={$row['year']}&s=0&e=20' >Rate Notification</a></li>";
							echo "</ul>
							</div>
						</li>";  			 
				} else {
					echo "<li>";
					echo "<a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&year={$row['year']}&s=0&e=20''>{$row['year']}</a>";  
					echo "</li>";
				}

				
			}

		    echo "</ul>";
		}
		mysqli_free_result($result);

	?>	
		<?php 
			}
		} else {
			include('loggedInError.php');
	 	}
		?>

      </div> 

    </div>
    <!-- left sec end --> 

<?php 
  include('footer.php');
?> 
