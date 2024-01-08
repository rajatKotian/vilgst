<?php include('conn.php'); ?>
<?php include_once('functions.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <style>
    .q-search
    {
        position: absolute;
        right: 2%;
        margin-top: -33px;
        border: 1px solid #006a96;
        background: #006a96;
        color: #fff;
        padding: 1px 7px;
        font-size: 20px;
        border-radius: 3px;
    }
    
    #arrange-demo{
        float: right;
        width: 175px;
        font-weight: bold;
        text-transform: uppercase;
        height: 36px;
        margin-top: -53px;
        /* border: 1px solid; */
        /* padding: 10px; */
        text-align: center;
        /* background: orange; */
        cursor: pointer;
        /* text-decoration: blink;*/
    }
    
    #arrange-demo img{
        width: 175px;
    }
    
    #arrange-demo:hover img{
         width: 180px;
         /*height: 38px;*/
     }
    #arrange-demo:hover {
         width: 180px;
         /*height: 38px;*/
     }
  </style>


  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 	
	  $seoMetaTitle = "Updates on GST & Indirect Taxes | Tax updates and News | VILGST";
  	$seoMetaKeywords = "indirect taxes, tax information, tax news, gst information, gst updates, gst news, gst notification, gst circular, gst articles, vat information, value added tax information, service tax updates, service tax notification, dgft notification, gst advance ruling, customs notification, excise notification, tax solution, income tax updates, goods and services tax updates";
  	$seoMetaDesc = "VILGST provides Tax news and Indirect Taxes updates complete solution by providing latest information on GST to the professionals and businesses.";

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

 		  }else if(isset($_GET['page']) && ($_GET['page']=="taxvista")){
         		$tableName = $_GET['page'];
           
                $decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));
         
                $getParam = getDbRecord($tableName, 'article_id', $decryptID);
    
                $seoMetaTitle = "TAX VISTA: ".$getParam['subject'] . " [" . (String) date('d-m-Y', strtotime($getParam['article_date'])) . "]"; 
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
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/main-style.css?ver=2508202012390" >
  <!-- magnific popup styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/magnific-popup.css">
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css"> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
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
     
<meta name="google-site-verification" content="6KPaHMYQCC1ppecAlDAu2cR3VrXgMfGxVjcltDOnoOI" />
     
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MGM2FTK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- preloader start 
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
        
        <br/>
                <a href='#scheduleADemo' class='open-popup-link' data-effect="mfp-zoom-in" id='arrange-demo'><img src="<?php echo $getBaseUrl; ?>images/ask-for-demo.png" /></a>
        
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
            <!--<div class="toggle-search-container">-->
            <!--  <a href="javascript:;" class="toggle-search pull-right">-->
            <!--    <span class="search-text">SEARCH</span>-->
            <!--    <span class="ion-ios-search"></span>-->
            <!--  </a>-->
            <!--</div>-->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <?php include('navigation_1.php'); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- nav end --> 
      
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
    $BannerResult = mysqli_query($GLOBALS['con'],"SELECT * FROM banner");
    if($result === FALSE) { 
		die(mysqli_error());  
	}
	$bannerRow = mysqli_fetch_array($BannerResult);
	  
    if($active_flag == 'Y') {
    ?> 
  <!-- Homepage Banner -->
  <div class="container banner-container">
    <a href="<?php echo $url; ?>" target="_blank">
      <img src="<?php echo $row['file_path']; ?>" alt="Source" class="img-responsive"/>
    </a>
  </div>
  <!--<div style="display:<?php if(!empty($bannerRow['image_name']) && $bannerRow['to1']<=date('Y-m-d') && $bannerRow['active']=='Yes'){echo "block";}else{ echo "none";} ?>"class="container banner-container">-->
  <!--   <a href="< ?php echo $url; ?>" target="_blank"><img src="< ?php echo $row['file_path']; ?>" alt="" /></a> -->
  <!--  <a  href="<?php if(!empty($bannerRow['link']) && $bannerRow['link']!=''){echo $bannerRow['link'];}?>" target="_blank"><img src="<?php echo "banner/".$bannerRow['image_name'];?>" class="img-responsive" /></a>-->
  <!--</div>-->
  <?php  } ?>
  
  <?php
  } 
  ?>
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
<!-- Main Container start -->
<div class="container main-container">
  <div class="row"> 
 
