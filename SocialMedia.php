<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
	.social_area {
		top: 50%;
    	left: 0%;
    	opacity: 1;
    	position: fixed;
    	-webkit-transform: translateY(-50%);
    	-ms-transform: translateY(-50%);
    	transform: translateY(-50%);
    	z-index: 999999;
	}
	ul {
		margin: 0px;
		padding: 0px;
	}
	i.fa.fa-facebook{
		color:#fff;
		background-color:#3b5998;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-facebook:hover {
		background-color:#17233E;
	}

	i.fa.fa-twitter{
		color:#fff;
		background-color:#55acee;;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-twitter:hover {
		background-color:#084674;
	}

	i.fa.fa-linkedin{
		color:#fff;
		background-color:#007bb5;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-linkedin:hover {
		background-color:#0c577a;
	}

	i.fa.fa-whatsapp{
		color:#fff;
		background-color:#43d854;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-whatsapp:hover {
		background-color:#067212;
	}

	i.fa.fa-skype{
		color:#fff;
		background-color:#0078ca;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-skype:hover {
		background-color:#0544d3;
	}

	i.fa.fa-envelope{
		color:#fff;
		background-color:#292a2b;
		border-radius: 0px 0px 10px 0px;
		width:40px;
		height:40px;
		line-height:40px;
	    font-size: 20px;
		text-align:center;
		transition:0.5s all;
		-webkit-transition:0.5s all;
		-moz-transition:0.5s all;
		-o-transition:0.5s all;
		-ms-transition:0.5s all;
	}
	i.fa.fa-envelope:hover {
		background-color:#17233E;
	}
	#ShareExpandDiv{
        display: none; background: #fffff0; color: #d8ff00; border-radius: 0 20px 20px 0px;
        border-left: 0px; font-family:'calibri'; font-size: 14px; z-index: 12000;
    }

    #ShareDiv{
        display: block; background: #b40d5a; position: fixed; top: 50%;	left: 0%; color: #FFF;
        border-radius: 0 20px 20px 0px; padding: 17px; writing-mode: vertical-rl; text-align: 
        center; font-weight: bold; cursor: pointer; letter-spacing: 5px; z-index: 12000;
    }
    #ShareExpandDiv .share-header{
        text-align:left; width:100%; cursor: pointer; font-size: 20px; clear:both;
        border-bottom: 1px solid #700541; margin-bottom: 1px; background: #08594e; color:#FFF;
        padding: 20px 15px; border-radius: 0px 10px 0px 0px;
    }

    #ShareExpandDiv .share-hide{
        text-align:right; width:50%; font-weight:normal; cursor: pointer; float:right; font-size: 12px; color:#FFF;
    }
</style>
<?php
//$login = 'samirksingh'; 
//$login2 = 'davidwalshblog';
//$apikey = 'd741f16e9c461b741215b9b10fd23892da192dc2';
//$apikey2 = 'R_96acc320c5c423e4f5192e006ff24980';
$Url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$Url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
//$Url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $Url;

//gets the data from a URL  
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}

//test it out!
//$new_url = get_tiny_url($Url);
$new_url = urlencode($Url);
//echo $new_url


?>
<div id='ShareDiv'>
    <i class="fa fa-chevron-right"></i>
</div>
<div class="social_area" id='ShareExpandDiv'>
	<div class='share-header'>
        <div class='share-hide'><i class="fa fa-chevron-left"></i></div>
    </div>
    <ul class="social_nav">
    	<li class="facebook">
    		<!-- <a href="https://www.facebook.com/sharer.php?display=page&u=<?php echo $new_url; ?>%2F">Facebook</a> -->
    		<a href="http://www.facebook.com/sharer/sharer.php?display=page&u=<?php echo $new_url; ?>" target="_blank">
    			<i class="fa fa-facebook"></i>
    		</a>
    	</li>
    	<li class="twitter">		
			<!-- <a href="https://twitter.com/intent/tweet?url=<?php echo $Url; ?>%2F&text=Tips%2C+Tricks%2C+and+Techniques+on+using+Cascading+Style+Sheets.">Twitter</a> -->
    		<a href="https://twitter.com/share?url=<?php echo $new_url; ?>&page=" target="_blank">
    			<i class="fa fa-twitter"></i>
    		</a>
    	</li>
    	<li class="linkedin">
    		<!-- <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $new_url; ?>%2F&title=CSS-Tricks&summary=Tips%2C+Tricks%2C+and+Techniques+on+using+Cascading+Style+Sheets.&source=CSS-Tricks">linkedin</a> -->
    		<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $new_url; ?>" target="_blank">
    			<i class="fa fa-linkedin"></i>
    		</a>
    	</li>
    	<li class="whatsapp">
    		<a href="whatsapp://send?text=<?php echo $new_url; ?>" data-action="share/whatsapp/share" target="_blank">
    			<i class="fa fa-whatsapp"></i>
    		</a>
    	</li>
    	<li class="skype">
    		<a target="_blank"href="skype:-skype-name-?chat=<?php echo $new_url; ?>">
    			<i class="fa fa-skype"></i>
    		</a>
    	</li>
    	<li class="mail">
    		<a href="mailto:?subject=[SUBJECT]&body=<?php echo $new_url; ?>" target="_blank">
    			<i class="fa fa-envelope"></i>
    		</a>
    	</li>
    </ul>
</div>
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
<script src="<?php echo $getBaseUrl; ?>js/custom.js?ver=160720200100"></script>