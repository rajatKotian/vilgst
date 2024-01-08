<?php
  $page = 'homePage';
  $seoTitle = (isset($_GET['type'])) ? $_GET['type'] : ' ';
  include('header.php');
?>
<style type="text/css">
  .show-more { 
    margin: 0px 0px 20px 0px;
    overflow: hidden;
    height: 50px;
  }
</style>
    <!-- left sec start <div class="col-md-16 col-sm-16"> -->
    <div class="col-md-11 col-sm-9 left-section">
      <h1>
        <?php
         if(isset($_GET['V1Zaa1VsQlJQVDA9'])) {

            $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));
            echo getCircularNumber($decryptID, 'recent_data'); 
          }
        ?>
          <ol class="breadcrumb">
            <li><a href="<?php echo $getBaseUrl; ?>">Home</a></li>
            <li class="active"><?php
               if(isset($_GET['V1Zaa1VsQlJQVDA9'])) {

                  $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));
                  echo getCircularNumber($decryptID, 'recent_data'); 
                }
              ?>
            </li>
        </ol>
      </h1>
      <div class="col-md-16">
      
        <?php 
          if(isset($_GET['V1Zaa1VsQlJQVDA9'])) {

            $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));
           
            if(isset($_GET['t'])) {

              echo getSingleRecordByProduct($decryptID, $_GET['t']); 
            } else {
              echo getSingleRecordByProduct($decryptID, 'recent_data'); 
            }

          }
        ?>

      </div> 

    </div>
    <!-- left sec end --> 
<?php 
  include('footer.php');
?>
