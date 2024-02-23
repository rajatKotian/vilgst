<?php

  $page = 'homePage';
$seoTitle = 'Login History';
$seoKeywords = 'Login History';
$seoDesc = 'Login History';

  include('header.php');

?>

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">

      <h1>Login History

      		<ol class="breadcrumb">

		        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

		        <li class="active">Login History</li>

	      </ol>

      </h1>



<?php

if(isLogeedIn()) {

	

	$uid = $_SESSION["id"];



	$sql = "SELECT *  FROM login_history WHERE user_id =$uid ORDER BY login_dt  DESC"; 

	$result=mysqli_query($GLOBALS['con'],$sql);

	echo "<div class='table-container' style='width: 75%'>";

	echo "<table class='table table-hover' >";

	echo "<tr><th class='center-aligned'>Login Date</th><th class='center-aligned'>Login Time</th></tr>";

	while ($row = mysqli_fetch_array($result)) {

		$loginDt = strtotime($row["login_dt"]);

		echo '<tr>';

		echo "<td class='center-aligned'>".date("d-M-Y", $loginDt)."</td>";

		echo "<td class='center-aligned'>".date("h:i A", $loginDt)."</td>";

		echo '</tr>';

	} 

	echo "</table>";

	echo "</div>";

	mysqli_free_result($result);

} else {

 	include('loggedInError.php');


 } ?>	



    </div>

    <!-- left sec end --> 



<?php 

  include('footer.php');

?>
