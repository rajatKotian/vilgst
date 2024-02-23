<?php
  $page = 'homePage';
  $seoTitle = (isset($_GET['data'])) ? ucwords($_GET['data']) : ' ';
  include('header.php');

  $getData =  ucwords(strtolower(str_replace('_', ' ', $_GET['data'])));

if($_GET['data'] == 'highlights') {

  $result1 = mysqli_query($GLOBALS['con'],"SELECT title FROM sidebar_widgets WHERE widget_type = 'highlights' ");  
  $row1 = mysqli_fetch_array($result1); 

  $getData =  ucwords(strtolower(str_replace('_', ' ', $row1['title'])));
}

if(isset($_GET["WlZkV2FHTm5QVDA9"])) {
    $decryptYear = base64_decode(base64_decode($_GET['WlZkV2FHTm5QVDA9']));
    $getData = $getData.' - ' .$decryptYear.' - '.(substr($decryptYear,2)+1);
  } 

?>
<style type="text/css">

  .category-tags { text-align: center; padding-bottom: 10px;   }
  .category-tags a[data-tag='all'] { display: inline-block !important; }
  .category-tags a {
    display: none;
    border-radius: 20px;
    margin: 10px 5px; 
    padding: 5px 12px; 
    color: #fff;
    background: #00789e; /* Old browsers */
    background: -moz-linear-gradient(top, #00789e 0%, #00548a 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #00789e 0%,#00548a 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #00789e 0%,#00548a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00789e', endColorstr='#00548a',GradientType=0 ); /* IE6-9 */
  }

  .category-tags a.active,
  .category-tags a:hover {
    box-shadow: inset 1px 1px 1px 0 rgba(0, 0, 0, 0.5);
    background: #ff7708; /* Old browsers */
    background: -moz-linear-gradient(top, #ff7708 1%, #ffa000 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #ff7708 1%,#ffa000 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #ff7708 1%,#ffa000 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff7708', endColorstr='#ffa000',GradientType=0 ); /* IE6-9 */
  }

</style>

 
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>
        <?php 
            if(isset($_GET['data'])) { 
            echo "More ". $getData ;
             
            
         } ?>
          <ol class="breadcrumb">
            <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
            <li class="active">
                <?php 
                    if(isset($_GET['data'])) { 
                    echo "More ". $getData;

                 } ?>
            </li>
        </ol>
      </h1>
      <div class="col-md-16">
      
        <?php 



         if(isset($_GET['data'])) {
            if($_GET['data'] == 'Judgements') {
              echo getRecentData($_GET['data'], '4'); 
            } else if($_GET['data'] == 'Notifications') {
              echo getRecentData($_GET['data'], '7'); 
            } else if($_GET['data'] == 'articles' || $_GET['data'] == 'highlights' || $_GET['data'] == 'features'  || $_GET['data'] == 'budgets_analysis') {

                  if($_GET['data'] == 'articles') {
                      $tableName  = "articles";  
                      $additionalFields = "article_id 'id', DATE_FORMAT( article_date, GET_FORMAT( DATE, 'EUR' ) )  'Date',  author 'Author'"; 
                      $whereQuery = "   ";
 
                  } else if($_GET['data'] == 'highlights') {
                      $tableName  = "highlights";  
                      $additionalFields = "highlight_id 'id', DATE_FORMAT( highlight_date, GET_FORMAT( DATE, 'EUR' ) )  'Date',  author 'Author'"; 
                      $whereQuery = "  WHERE active_flag = 'Y' ";
  

 
                  } else if($_GET['data'] == 'budgets_analysis') {
                      $tableName  = "budgets_analysis";  
                      $additionalFields = "analysis_id 'id', DATE_FORMAT( analysis_date, GET_FORMAT( DATE, 'EUR' ) )  'Date',  author 'Author'"; 
                      $whereQuery = "   ";

                        if(isset($_GET["WlZkV2FHTm5QVDA9"])) {
                          $decryptYear = base64_decode(base64_decode($_GET['WlZkV2FHTm5QVDA9']));

                        $whereQuery = ' WHERE analysis_date like "%'.$decryptYear.'%" ';
                        } 
 
                  } else {
                      $tableName  = "features";  
                      $additionalFields =  "feature_id 'id', DATE_FORMAT( feature_date, GET_FORMAT( DATE, 'EUR' ) )  'Date' "; 
                      $whereQuery = "  ";
                  }

                  $sql = "SELECT  $additionalFields, subject, summary, new_flag
                          FROM $tableName  
                          $whereQuery
                          ORDER BY updated_dt DESC"; 
 
                   $result = mysqli_query($GLOBALS['con'],$sql);

                  if(mysqli_num_rows($result) == 0) {   

                    echo "<div class='alert alert-danger'>No Data Found</div>";

                 } else {
                    $fields_num = mysqli_num_fields($result);                    
                    
                    while($row = mysqli_fetch_array($result)) {

                      $encryptID = base64_encode(base64_encode($row['id']));
                      $author = '';
                      if($_GET['data'] == 'articles') { $author = ' | '.$row['Author']; }

                     echo "<div class='widget-box'>
                              <h4><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$tableName\")'>".$row['subject']."</a> <span>".$row['Date']."".$author."</span></h4>
                              <div class='widget-content'>";
                      echo "<p>".stripslashes($row['summary'])."</p>";
                      echo "  <div class='widget-actions'><a href='javascript:void(0)' onclick='showFrame(\"$encryptID\",\"$tableName\")' class='ion-android-archive' title='Click here to download the file'></a></div>";
                      echo "  </div> 
                          </div>";
                    }

                 }
                  mysqli_free_result($result);

            }  

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
    var categoryTags = $('.category-tags a');

    categoryTags.each(function() {
      var thisTag = $(this),
          thisTagData = $(this).data('tag');

      $("[data-catrow]").each(function() {
        catrowData = $(this).data('catrow');
        if(catrowData == thisTagData) {
          thisTag.css('display','inline-block');
        }        
      });
      
    });

    categoryTags.on('click', function(e) {
      e.preventDefault();
      var thisTag = $(this),
          thisTagData = $(this).data('tag');
      categoryTags.removeClass('active');
      $(this).addClass('active');
      $("[data-catrow]").hide();

      if(thisTagData == 'all') {
        $("[data-catrow]").show();
      } else {
       $("[data-catrow]").each(function() {
        catrowData = $(this).data('catrow');
        if(catrowData == thisTagData) {
          $(this).show();
        } 
       });

      }
      
    });

  });

  

</script>
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
