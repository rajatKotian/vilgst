<?php 
	$page = '';
	include('header.php'); 
	$Months = $_GET['month'];
	$year = $_GET['year'];
	$dateObj2   = DateTime::createFromFormat('!m', $Months);
    $monthName2 = $dateObj2->format('F');
?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div id="show_gst_rate" style="display: none;"></div>
    <div class="col-md-11 col-sm-9 left-section" main_div>
      <h1>Weekly Summary - <?php echo $monthName2.' '.$year ?>
      	 <ol class="breadcrumb">
	        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
	        <li class="active">Weekly Summary - <?php echo $monthName2.' '.$year ?></li>
	     </ol>
      </h1>
      <div class="col-md-16">
      <?php 
		if(isLogeedIn()) {
			if($_SESSION["userStatus"]=="expired") {
				include('expiredUserError.php'); 
			} else {
			    if ($_SESSION["type"]=="T") {
					include('expiredUserError.php');
				} else{
		?>

      	<div class="alert alert-warning"><h6>Please Select Date</h6></div>
   		
		<?php
			$tableName = "highlights";
				$sql = "SELECT * FROM $tableName WHERE YEAR(`highlight_date`) = $year AND MONTH(`highlight_date`) = $Months ORDER BY highlight_date DESC" ;
				$result = mysqli_query($GLOBALS['con'],$sql);

					if(mysqli_num_rows($result) == 0) {   

						echo "<div class='alert alert-danger'>No Data Found</div>";

					} else {
						$fields_num = mysqli_num_fields($result);
			
						echo "<ul class='boxed-list'>";
						
						while($row = mysqli_fetch_array($result)) {
							$id = $row['highlight_id'];
							$highlight_date = $row['highlight_date'];
							$subject = $row['subject'];
							$time2=strtotime($highlight_date);
							$month3=date("F",$time2);
							$year3=date("Y",$time2);
							$day=date("d",$time2);
							$date = $day. ' ' .$month3. ' ' .$year3;
							$highlight_id = base64_encode(base64_encode($id));
							if ($subject=="Weekly Summary") {
								echo "<li>";
								echo "<a href='".$getBaseUrl."showiframe?V1Zaa1VsQlJQVDA9=$highlight_id&page=highlights'>{$date}</a>";
								echo "</li>";
							}  
						}

					    echo "</ul>";
					}
			
			mysqli_free_result($result);
			//mysqli_free_result($result2);
	
		?>	
		<?php 
			    }
			}
		} else {
			include('loggedInError.php');
	 	}
		?>
      </div> 

    </div>
    <!-- left sec end --> 
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
    authDomain: "vilgst.firebaseapp.com",
    projectId: "vilgst",
    storageBucket: "vilgst.appspot.com",
    messagingSenderId: "493343969816",
    appId: "1:493343969816:web:2ea8047fba70f4980d696d",
    measurementId: "G-DQNYHJLPB3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
<?php 
  include('footer.php');
?>