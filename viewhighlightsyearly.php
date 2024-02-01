<?php 
  $page = '';
  include('header.php');
?>
<style type="text/css">
.boxed-list li {
    display: inline-block;
    padding: 0 0;
    vertical-align: middle;
    width: 30%;
}
.year {
    color: #746601;
    font-size: 20px !important;
}
</style>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div id="show_gst_rate" style="display: none;"></div>
    <div class="col-md-11 col-sm-9 left-section" main_div>
      <h1>Weekly Summary
         <ol class="breadcrumb">
          <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
          <li class="active">Weekly Summary</li>
       </ol>
      </h1>
      <div class="col-md-12" style="width: 100%;">
          <div class="alert alert-warning"><h6>Please Select Year</h6></div>
          <?php
          $tableName = "highlights";
          $sql = "SELECT  DISTINCT(SUBSTRING(highlight_date, 1, 4))'year', subject FROM $tableName ORDER BY highlight_date DESC";
    
          $result = mysqli_query($GLOBALS['con'],$sql);

          if(mysqli_num_rows($result) == 0) {   

            echo "<div class='alert alert-danger'>No Data Found</div>";

          } 
          else {
            $fields_num = mysqli_num_fields($result);
            echo "<ul class='boxed-list'>"; 
            
            while($row = mysqli_fetch_array($result)) {
              $year = $row['year'];
              $subject = $row['subject'];
              if ($subject=="Weekly Summary") {
                  echo "<li style='padding-top: 30px;'>";
                  echo "<a class='year'>{$year}</a>";
                  echo "</li>";
          
                $sql2 = "SELECT DISTINCT MONTH(highlight_date) AS 'Month' FROM $tableName WHERE YEAR(`highlight_date`) = $year ORDER BY highlight_date DESC";
                $result2 = mysqli_query($GLOBALS['con'],$sql2);
                
                if(mysqli_num_rows($result2) == 0) {
                  echo "<div class='alert alert-danger'>No Data Found</div>";
                }
                else {
                  $fields_num2 = mysqli_num_fields($result2);
                  echo "<ul class='boxed-list'>";
                  
                  while($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
                    $highlights_date2 = $row2['Month'];
                    //$subject2 = $row2['subject'];
                    $dateObj   = DateTime::createFromFormat('!m', $highlights_date2);
                    $monthName = $dateObj->format('F');
                    echo "<li>";
                    echo "<a href='".$getBaseUrl."viewhighlightsweakly?month={$highlights_date2}&year={$year}'>{$monthName}</a>";
                    echo "</li>";
                  }
                  echo "</ul>";
                }
              }
            }
            echo "</ul>";
          }
      mysqli_free_result($result);
      mysqli_free_result($result2);
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