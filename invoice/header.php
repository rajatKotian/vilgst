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
 			    
  ?>

  <title>VILGST | <?php echo $seoMetaTitle; ?></title>
  <meta name="keywords" content="<?php echo $seoMetaKeywords; ?>"/>
  <meta name="description" content="<?php echo $seoMetaDesc; ?>" />
  <meta name="google-site-verification" content="G4rE9FfwZe9hUWlnO1diWo6BvDk8iT_czayXasC5iXc" />
  <link href="<?php echo $getBaseUrl; ?>images/favicon.ico" type="image/x-icon" rel="shortcut icon">
  <!-- bootstrap styles-->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/bootstrap.min.css">
  <!-- google font -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800|Titillium+Web" type="text/css">
  <!-- ionicons font -->
  <link rel="stylesheet" href="/css/ionicons.min.css">
  <!-- animation styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/animate.css"  />
  <!-- custom styles -->
  <link rel="stylesheet" href="<?php echo $getBaseUrl; ?>css/main-style.css?ver=0306201701010" >
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
            <li> 
        <?php 
          if(isLogeedIn()) { 
            $result = mysqli_query($GLOBALS['con'],"SELECT firstname, totalhitcount, hitcount FROM userlogins where user_id = '".$_SESSION['id']."'");  
            $row = mysqli_fetch_array($result);          
             echo "Welcome <strong>";
            //if($row['firstname'] != null) { 
            //  echo $row['firstname'];
           // } else {
              echo $_SESSION['user'];
           // } 
            echo "</strong> ";
             
           } 
        ?>
              </li>
              <?php if(isLogeedIn()) {   ?>
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
        <a id="logo" href="<?php echo $getBaseUrl; ?>" title="VATinfoline"><img src="<?php echo $getBaseUrl; ?>images/vatinfoline-logo.png" style="max-width: 250px;" /></a>
        <img src="images/invoice-master.png" style="float: right;" />  
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
             
            <div class="collapse navbar-collapse" id="navbar-collapse">
              <?php include('navigation.php'); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- nav end --> 
    </nav>
    <!--nav end--> 
  </div>
  
  <!-- nav and search end--> 
  
  
<!-- Main Container start -->
<div class="container main-container">
  <div class="row"> 
 
