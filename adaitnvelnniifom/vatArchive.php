<?php 
	$page = 'vat';
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
      	<div class="alert alert-warning"><h6>Please select State</h6></div>
   		<?php
			$table = 'recent_data';
			$prod = $_GET["prod_id"];
			$subprod = $_GET["sub_prod_id"];

			$getDbRecord = getDbRecord('product', 'prod_id', $prod);
			$dataType = $getDbRecord['dbsuffix']; 

			$tableName = 'casedata_'.$dataType;


			$sql = "SELECT DISTINCT(sm.state_name) 
							FROM $tableName vd, state_master sm 
							WHERE prod_id = $prod
							AND sub_prod_id = $subprod
							AND vd.state_id = sm.state_id
							ORDER BY sm.state_name";

			$result = mysqli_query($GLOBALS['con'],$sql);

			if(mysqli_num_rows($result) == 0) 	{   

				echo "<div class='alert alert-danger'>No Data Found</div>";

			} else {
				$fields_num = mysqli_num_fields($result);	

				echo "<ul class='boxed-list'>";	

				while($row = mysqli_fetch_array($result)) {

					$stateName = ($row['state_name'] == 'Central' && $_GET['prod_id'] == 7) ? 'Compensation Cess' : $row['state_name'];
					$dataCentral = ($row['state_name'] == 'Central') ? 'central-row' : '';

					if($subprod==53  || $subprod==63) {
	 				   	echo "<li class='padding-b-15 ".$dataCentral."' style='width: 50%; ' >
					  			<div class='table-container'>
					  			<h3 class='t-margin-10'>".$stateName."</h3>
					  			<ul class='boxed-list'>";
						  			echo "<li style='width:50%'><a href='".$getBaseUrl."archdata?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=N&state={$row['state_name']}&s=0&e=20' >Notification</a></li>";
						  			echo "<li style='width:50%'><a href='".$getBaseUrl."archdata?prod_id=$prod&sub_prod_id=$subprod&sub_subprod_id=RN&state={$row['state_name']}&s=0&e=20' >Rate Notification</a></li>";
								echo "</ul>
								</div>
							</li>";  			 
					} else {
						echo "<li class='".$dataCentral."'>";
						echo "<a href='".$getBaseUrl."archdata?prod_id=$prod&sub_prod_id=$subprod&state={$row['state_name']}&s=0&e=20'>".$stateName."</a>";
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.central-row').each(function() {
			$(this).prependTo($(this).closest('ul'));
		});
	});
</script>
