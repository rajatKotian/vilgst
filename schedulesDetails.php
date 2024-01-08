<?php 
	$page = 'schedules';
$seoTitle = 'VAT - Schedules ('.$_GET['state_id'].')';
$seoKeywords = 'VAT - Schedules ('.$_GET['state_id'].')';
$seoDesc = 'VAT - Schedules ('.$_GET['state_id'].')';
	include('header.php'); 
?>
<!-- left sec start <div class="col-md-16 col-sm-16"> -->
<div class="col-md-11 col-sm-9 left-section">
      <h1>VAT - Schedules 
      		<ol class="breadcrumb">
		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
		        <li><a href="<?php echo $getBaseUrl; ?>schedules">Schedules</a></li>
		        <li class="active">
	        	<?php
					$state_id = $_GET['state_id'];
					   								
					$sql1=mysqli_query($GLOBALS['con'],"SELECT state_id FROM schedules WHERE state_id ='$state_id' ");
					$row1 = mysqli_fetch_row($sql1);
					echo $row1[0]; 
			   ?>
			   </li>
	      </ol>

      </h1>
      <div class="col-md-16">
      	 
      	<?php
        if(isLogeedIn()) {  

        	if($_SESSION["userStatus"]=="expired") {

				include('expiredUserError.php'); 
				
			} else {
												
					$sql="SELECT * FROM schedules WHERE state_id = '$state_id' ";
					$result = mysqli_query($GLOBALS['con'],$sql);
					
					if (mysqli_num_rows($result) == 0)  {    
						echo "<div class='alert alert-danger'>No Data Found</div>";
					} else {
						
						$fields_num = mysqli_num_fields($result);
				 
						if(mysqli_num_rows($result) == 0)			{
							echo '<div class="notification error">Record not found</div>';
						}
						echo "<table class='table table-hover' >";
						echo "<tbody><tr><th colspan='2' style='text-transform:uppercase;font-size:15px; font-weight:bold; padding:10px; text-align:center;'>$state_id</th></tr>";

						while($row = mysqli_fetch_array($result)) {
							$schedule_date = new DateTime($row['schedule_date']);
						 	$schedule_date = $schedule_date->format('d-M-Y');
							echo "<tr><td><strong>{$row['schedule_narration']}</strong><div class='clear'></div><span style='font-size:12px; color:#999'>(Last updated on : $schedule_date)</span></td>";
							echo "<td style='width:100px'><a href='$getBaseUrl".$row['file_path']."' class='btn ' target='_blank'>Download File</a></td>";
							echo "</tr>";
						}	

						echo "</tbody></table>";
						mysqli_free_result($result);

					}	

					

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
