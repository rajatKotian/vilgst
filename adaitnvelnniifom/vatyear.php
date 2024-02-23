<?php 
	$page = '';
	include('header.php'); 
?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>
      	<?php 
	    	$getProdname = mysqli_query($GLOBALS['con'],"SELECT prod_name FROM product where prod_id	 = '".$_GET['prod_id']."'");	
       		$rowProdname = mysqli_fetch_array($getProdname);
			echo $rowProdname['prod_name'];
			echo ' - ';
		    $getSubProdname = mysqli_query($GLOBALS['con'],"SELECT sub_prod_name FROM sub_product where sub_prod_id = '".$_GET['sub_prod_id']."'");	
       		$rowSubProdname = mysqli_fetch_array($getSubProdname);
			echo $rowSubProdname['sub_prod_name'];
		?>
      		<ol class="breadcrumb">
		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <li class="active"><?php echo $rowProdname['prod_name'] . ' - '.$rowSubProdname['sub_prod_name'];  ?></li>
	      </ol>
      </h1>
      <div class="col-md-16">
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
			
			$sql = "SELECT  DISTINCT(year(circular_date))'year'
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
					echo "<li>";
					echo "<a href='".$getBaseUrl."vatyearfilter?prod_id=$prod&sub_prod_id=$subprod&year={$row['year']}&s=0&e=20'>{$row['year']}</a>";
					echo "</li>"; 
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
