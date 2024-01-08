<?php 
	$page = 'schedules';
$seoTitle = 'Schedules';
$seoKeywords = 'Schedules';
$seoDesc = 'Schedules';
	include('header.php'); 
?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>VAT - Schedules 
      		<ol class="breadcrumb">
		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <li class="active">Schedules</li>
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
			$sql =  "SELECT DISTINCT(state_id)'state' FROM	schedules ORDER BY state_id";
			$result = mysqli_query($GLOBALS['con'],$sql);

			if(mysqli_num_rows($result) == 0) {    
				echo "<div class='alert alert-danger'>No Data Found</div>";
			} else {
				$fields_num = mysqli_num_fields($result);				
				
				echo "<ul class='boxed-list'>";	
				while($row = mysqli_fetch_array($result))
				{
					echo "<li>";
					echo "<a href='".$getBaseUrl."schedulesDetails?state_id=".$row['state']."'>{$row['state']}</a>";
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
