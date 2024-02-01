<?php include('conn.php'); ?>
<?php include('functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 	
	  $seoMetaTitle = "Updates on GST, VAT, Service Tax, Central Excise, Customs and DGFT";
  	$seoMetaKeywords = "Leading information service provider on GST, SGST, CGST, UTGST, IGST, VAT, Central Excise, Service Tax, Customs, DGFT";
  	$seoMetaDesc = "GST, SGST, CGST, UTGST, IGST, VAT, Central Excise, Service Tax, Customs, DGFT, VAT Acts, VAT Rules, VAT Rate, VAT Schedule, Tax, Sales Tax, Service Tax, Excise, Andhra VAT, Assam VAT, Bihar VAT, Chhattisgarh VAT, Chandigarh vat, Delhi VAT, goa vat, Gujarat VAT, Haryana VAT, Himachal Pradesh vat, Jammu and Kashmir vat,  Jharkhand vat, Karnataka VAT, Kerala VAT, Madhya Pradesh vat, Maharashtra VAT, Orissa vat, Puducherry vat, Punjab vat, Rajasthan vat, Tamil Nadu VAT, Uttar Pradesh VAT, Uttarakhand VAT, west Bengal VAT";

  	if(isset($seoTitle) && $seoTitle != '') { $seoMetaTitle = $seoTitle." | ".$seoMetaTitle; }

  	if(isset($seoKeywords) && $seoKeywords != '') { $seoMetaKeywords = $seoKeywords; }

  	if(isset($seoDesc) && $seoDesc != '') { $seoMetaDesc = $seoDesc; }
 
  	if(preg_match('/showiframe/', $_SERVER['PHP_SELF'])) {

  		if((isset($_GET['datatable']) && $_GET['datatable'] != 'undefined') || (isset($_GET['page']) && ($_GET['page']=="recent" || $_GET['page']=="unionBudget")) ) {

        
        if(isset($_GET['page']) && $_GET['page']=="recent") { $tableName = 'recent_data'; } 
        else if(isset($_GET['page']) && $_GET['page']=="unionBudget") { $tableName = 'budgets_union'; } 
        else { $tableName = 'casedata_'.$_GET['datatable']; }
   
			  $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));
 
	  	 	$getParam = getDbRecord($tableName, 'data_id', $decryptID);
	  	 	$getProdName = getDbRecord('product', 'prod_id', $getParam['prod_id']);
	  	 	$getSubProdName = getDbRecord('sub_product', 'sub_prod_id', $getParam['sub_prod_id']);
	  	 	$getSubSubprod = ($getParam['sub_subprod_id'] != null) ? " (".$getParam['sub_subprod_id'].")" : '';

			  $seoMetaTitle = $getProdName['prod_name']. " - ".$getSubProdName['sub_prod_name'].$getSubSubprod." | ".$getParam['circular_no']; 
			  $seoMetaKeywords = $getProdName['prod_name']. ", ".$getSubProdName['sub_prod_name'].$getSubSubprod; 
			  $seoMetaDesc = $getParam['cir_subject'].", ".$getProdName['prod_name'].", ".$getSubProdName['sub_prod_name'].$getSubSubprod; 
 		  } 
      else if(isset($_GET['page']) && ($_GET['page']=="features" || $_GET['page']=="articles" || $_GET['page']=="highlights" || $_GET['page']=="budgets_analysis" || $_GET['page']=="stateBudget")) {

        
        $tableName = ($_GET['page']=="stateBudget") ? 'budgets_state' : $_GET['page'];
   
        $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));

        if($_GET['page']=="features") { $data_id = 'feature_id'; }
        else if($_GET['page']=="articles") { $data_id = 'article_id'; }
        else if($_GET['page']=="highlights") { $data_id = 'highlight_id'; }
        else if($_GET['page']=="budgets_analysis") { $data_id = 'analysis_id'; } 
        else if($_GET['page']=="stateBudget") { $data_id = 'budget_id'; } 
 
        $getParam = getDbRecord($tableName, $data_id, $decryptID);

        $seoMetaTitle = ucwords($tableName)." | ".$getParam['subject']; 
        $seoMetaKeywords = $tableName; 
        $seoMetaDesc = $getParam['summary'].", ".$tableName; 

 		  }  				 
 
  	} else if(preg_match('/vatArchive/', $_SERVER['PHP_SELF']) || 
              preg_match('/centralExcise/', $_SERVER['PHP_SELF']) || 
              preg_match('/vatyear/', $_SERVER['PHP_SELF']) || 
              preg_match('/archdata/', $_SERVER['PHP_SELF']) ) {

        if(isset($_GET['prod_id']) || isset($_GET['sub_prod_id'])) {
          $getProd = getDbRecord('product', 'prod_id', $_GET['prod_id']);
          $getSubProd = getDbRecord('sub_product', 'sub_prod_id', $_GET['sub_prod_id']);
          if(isset($_GET['sub_subprod_id'])) {

            $subSubprod = $_GET['sub_subprod_id'];    

            if($subSubprod=='T')    { $subSubProdName = ' (Tariff) '; }
            else if($subSubprod=='NT')  { $subSubProdName = ' (Non-Tariff) '; }
            else if($subSubprod=='SG')  { $subSubProdName = ' (Safeguards) '; }
            else if($subSubprod=='ADD') { $subSubProdName = ' (Anti Dumping Duty) '; }
            else if($subSubprod=='OTHERS') { $subSubProdName = ' (Others) '; }
            else if($subSubprod=='C')   { $subSubProdName = ' (Circulars) '; }
            else if($subSubprod=='I')   { $subSubProdName = ' (Instructions) '; }
            else if($subSubprod=='N')   { $subSubProdName = ' (Notification) '; }
            else if($subSubprod=='RN')  { $subSubProdName = ' (Rate Notification) '; }
          } else {
            $subSubProdName = '';
          } 

          if(isset($_GET['state'])) { 
            if($_GET['state'] == 'Central' && $_GET['prod_id']=='7') {
              $stateName = ' - Compensation Cess'; 
            } else {
              $stateName = ' - '.$_GET['state'];  
            }           
          } else { $stateName = ""; }

          $seoMetaTitle = $getProd['prod_name']." - ".$getSubProd['sub_prod_name'].$subSubProdName.$stateName; 
          $seoMetaKeywords = $getProd['prod_name'].", ".$getSubProd['sub_prod_name'].$subSubProdName.", ".$seoMetaKeywords; 
          $seoMetaDesc = $getProd['prod_name'].", ".$getSubProd['sub_prod_name'].", ".$seoMetaDesc;         

        }
        

    }
			    
  ?>

  <title>VILGST | <?php echo $seoMetaTitle; ?></title>
  <meta name="keywords" content="<?php echo $seoMetaKeywords; ?>"/>
  <meta name="description" content="<?php echo $seoMetaDesc; ?>" />
  <meta name="google-site-verification" content="G4rE9FfwZe9hUWlnO1diWo6BvDk8iT_czayXasC5iXc" />
  <link href="<?php echo $getBaseUrl; ?>images/favicon.ico" type="image/x-icon" rel="shortcut icon">
  <!-- bootstrap styles-->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/bootstrap.min.css">
  <!-- google font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800|Titillium+Web" type="text/css">
  <!-- ionicons font -->
  <link rel="stylesheet" href="/css/ionicons.min.css">
  <!-- animation styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/animate.css"  />
  <!-- custom styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/main-style.css?ver=110620181119" >
  <!-- magnific popup styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/magnific-popup.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php if(isset($_SESSION["id"])) { ?>
<script type="text/javascript">
  var dataLayer = window.dataLayer = window.dataLayer || [];
  dataLayer.push({
     'userID' : '<?php echo $_SESSION["id"]; ?>'
  });  
</script>
<?php  } ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MGM2FTK');</script>
<!-- End Google Tag Manager -->
     
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MGM2FTK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- preloader start -->
<div id="preloader">
  <div id="status"></div>
 <div class="loading-text">Loading...</div>
</div>
<!-- preloader end -->
<?php if(isset($_GET['req'])){ ?>
  <input type="hidden" value="<?php echo $_GET['req'];?>" name="ReqUrl" id="ReqUrl" />
<?php }  else { ?>
  <input type="hidden" value="<?php echo $currentUrl;?>" name="ReqUrl" id="ReqUrl" />
<?php } ?>
<!-- wrapper start -->
 
<div class="wrapper"> 
  <!-- header toolbar start -->
  <div class="header-toolbar">
    <div class="container">
      <div class="row">
        <div class="col-md-16 text-uppercase">
          <div class="row">
            <div class="col-sm-16 col-md-4 col-xs-16 ion-android-time">
              <div id="time-date"></div>
            </div>
            <div class="col-sm-16 col-md-12 col-xs-16">
              <div class="row text-right">
              <ul id="inline-popups" class="list-inline">
              <?php if(!isLogeedIn()) {  ?>
                <li><a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Login</a></li>
                <li><a class="open-popup-link" href="#create-account" data-effect="mfp-zoom-in">Register with us</a></li>
              <?php } ?>
                <li><a href="<?php echo $getBaseUrl; ?>submitArticle">Submit your article</a></li>
                <li><a href="<?php echo $getBaseUrl; ?>subscription">subscription</a></li>
                <li><a href="<?php echo $getBaseUrl; ?>about">About us</a></li>
                <li><a href="<?php echo $getBaseUrl; ?>clients">Clients</a></li>
                <li><a href="<?php echo $getBaseUrl; ?>feedback">Feedback</a></li>
                <li><a href="<?php echo $getBaseUrl; ?>contacts">Contact us</a></li>
              <?php if(isLogeedIn()) { 
                  echo "<li><a href='".$getBaseUrl."loghistory'>Login History</a></li>"; ?>
                  <li><a class="open-popup-link" href="#change-password" data-effect="mfp-zoom-in">Change password</a></li>
                  <li><a href="<?php echo $getBaseUrl; ?>logout">Log out</a></li>
              <?php } ?> 
              </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- header toolbar end --> 
  
  <!-- header start -->
  <div class="container header">
    <div class="row">
      <div class="col-lg-16 wow fadeInUpLeft animated">
        <a id="logo" href="<?php echo $getBaseUrl; ?>" title="VATinfoline"><img src="<?php echo $getBaseUrl; ?>images/vatinfoline-logo.png" /></a>
        <?php 
          if(isLogeedIn()) { 
            $result = mysqli_query($GLOBALS['con'],"SELECT firstname, totalhitcount, hitcount FROM userlogins where user_id = '".$_SESSION['id']."'");  
            $row = mysqli_fetch_array($result);          
            echo "<div  class='user-details pull-right' style='float:right;'>";
            echo "Welcome <strong>";
            //if($row['firstname'] != null) { 
            //  echo $row['firstname'];
           // } else {
              echo $_SESSION['user'];
           // } 
            echo "</strong> ";
            if($row['totalhitcount'] <= $row['hitcount']) {
              echo '<em>(Access : '.$row['totalhitcount'].' / '.$row['hitcount'].')</em>';  
            }            
            
            echo '</div>'; 
          } 
        ?>  
      </div>
    </div>
  </div>
  <!-- header end --> 
  <!-- nav and search start -->
  <div class="nav-search-outer"> 
    <!-- nav start -->    
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="row">
          <div class="col-sm-16">
            <div class="toggle-search-container">
              <a href="javascript:;" class="toggle-search pull-right">
                <span class="search-text">SEARCH</span>
                <span class="ion-ios-search"></span>
              </a>
            </div>
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <?php include('navigation.php'); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- nav end --> 
      <!-- search start -->
      <div class="search-container ">
        <div class="container ">
          <div class="col-sm-8 pull-right">
          <form name="searchmainForm">
            <div class="form-group">
              <div class="col-sm-8">
                <label class="pull-right">Select your search</label>
              </div>
              <div class="col-sm-8">
                <select name="searchFile"  id="searchFile" class="form-control" onchange="searchFileName(this.value)">
                    <option value="0">Select One</option>
                    <option value="searchCaseLaw"  
            <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='searchCaseLaw') {echo "selected='selected'";}?>>Case Law Quick Search</option>
                    <option value="searchCaseLawAdv"
                         <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='searchCaseLawAdv') {echo "selected='selected'";}?>>Case Law Advance Search</option>
                    <option value="searchNotificationCircular"
                         <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='searchNotificationCircular') {echo "selected='selected'";}?>>Notification/Circular Search</option>                        
                    <option value="searchNotificationCircularAdv"
                         <?php if(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING'])=='searchNotificationCircularAdv') {echo "selected='selected'";}?>>Notification/Circular Advance Search</option>                        
                   
                </select>
              </div>
            </div>
           </form>
            </div>
        </div>
      </div>
      <!-- search end --> 
    </nav>
    <!--nav end--> 
  </div>
  
  <!-- nav and search end--> 
  <!-- top sec start -->

  <div class="container">
    <div class="row"> 
      <!-- hot news start -->
<?php
              $marqueeSql = "SELECT *  FROM marquee WHERE status = 1 ORDER BY updated_dt  DESC"; //"SELECT * FROM marquee WHERE 'status' = 1 ORDER BY 'updated_dt' DESC";
              $marqueeResult=mysqli_query($GLOBALS['con'],$marqueeSql);
         
              ?>
      <div class="hot-news hidden-xs" <?php if(mysqli_num_rows($marqueeResult) == 0) {    ?> style="border: 0; height: 0; padding: 0; " <?php } ?> >
        <?php if(mysqli_num_rows($marqueeResult) > 0) {    ?>
        <div class="row">
          <div class="col-sm-16"> <span class="ion-speakerphone icon-news pull-left"></span>
            <ul id="js-news" class="js-hidden">
            <?php
             while ($marqueeRow = mysqli_fetch_array($marqueeResult)) {
                echo '<li class="news-item">';
                echo $marqueeRow["marq_text"];
                echo '</li>';
              } 
            ?>
            </ul>
          </div>
        </div>
       <?php  }  ?>
      </div>
      <!-- hot news end --> 
    </div>
  </div>

  <!-- top sec end --> 
  <?php if($page == 'homePage' && (isset($pageType) && $pageType =='index')) { 
    $result = mysqli_query($GLOBALS['con'],"SELECT active_flag, file_path, url FROM contentblocks where content_id = '1'");  
    $row = mysqli_fetch_array($result); 
    $active_flag = $row['active_flag']; 
    $url = $getBaseUrl.'unionBudgets?year='.$row['url']; 

   // if($active_flag == 'Y') {
    ?> 
  <!-- Homepage Banner -->
  <div class="container banner-container">
    <!-- <a href="< ?php echo $url; ?>" target="_blank"><img src="< ?php echo $row['file_path']; ?>" alt="" /></a> -->
    <a style="display:none"  href="https://masterclass.economictimes.indiatimes.com/courses/managing-tax-litigation-masterclass-mumbai/91#course-intro" target="_blank"><img src="http://vilgst.local/uploads/banner-728X90.jpg" alt="" /></a>
  </div>
  <?php // } ?>
  
  <?php
  } 
  ?>
  
<!-- Main Container start -->
<div class="container main-container">
  <div class="row"> 
 
