<?php
$page = 'showCOI';
include('header.php');
?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
<style type="text/css">
<style type="text/css">
    html, body {
        overflow: auto !important;
    }
    .style {
        width: 100%;
        background: linear-gradient(130deg,#ff7a18,#af002d 41.07%,#319197 76.05%);
        height: 350px;
        border-radius: 10px 10px 10px 10px;
        text-align: center;
        padding-top: 150px;
    }
    .btn {
        padding: 21px;
        border-radius: 10px;
        background: linear-gradient(130deg,#ff7a18,#976572 41.07%,#319197 76.05%);
        border-color: darkslategrey;
    }
    .link {
        color: white;
        font-size: 18px;
        font-family: swap;
    }
    .btn:hover {
        background: linear-gradient(130deg,#121220,#a33753 41.07%,#301807 76.05%);
    }
</style>

<div class="col-md-16 col-sm-16 left-section">
    <form method="post" action="" id="formDownload" name="formDownload">
        <h1>
            GST Resources
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
            </ol>
        </h1>
        <div class="col-md-10 style">
            <div class="btn-group">
              <button class="btn"><a class="link" target='_blank' href="gstcouncildata.php">GST Council Meeting</a></button>
              <button class="btn"><a class="link" target='_blank' href="gsteflyerdata.php">GST e-flyer</a></button>
              <button class="btn"><a class="link" target='_blank' href="gstpressreleasedata.php">GST Press Release</a></button>
            </div>
        </div>
    </form>
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
<?php
include('footer.php');
?>