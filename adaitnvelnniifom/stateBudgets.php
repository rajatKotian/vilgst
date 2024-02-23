<?php 

	$page = '';
$seoTitle = 'State Budget';
$seoKeywords = 'State Budget';
$seoDesc = 'State Budget';

	include('header.php'); 

?>

 

    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">

    <h1>State Budget

      <ol class="breadcrumb">

        <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>

        <li class="active">State Budget</li>           

      </ol>

    </h1>



    <div class="col-md-16">

      <?php  

        $budgetsql = "SELECT * FROM budgets_state ORDER BY updated_dt DESC "; 



        $result = mysqli_query($GLOBALS['con'],$budgetsql);



        while ($budgetRow = mysqli_fetch_array($result)) {

           

        $encryptID = base64_encode(base64_encode($budgetRow['budget_id']));



        echo "<div class='widget-box'>";  

        echo "<h4><strong><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"stateBudget\")' title='Click here to download the file'>{$budgetRow['subject']}</a> </strong></h4>";

        echo "<div class='widget-content'>

        <div class='widget-actions  pull-right'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"stateBudget\")' title='Click here to download the file' class='btn btn-text-icon pull-right t-margin-none'><i class='ion-android-archive'></i> Download File</a></div>

        <p>{$budgetRow["summary"]}</p>

        </div>";

        echo "</div>";                  

    } ?>

    </div> 



  </div>

    <!-- left sec end --> 



<?php include('footer.php'); ?>
