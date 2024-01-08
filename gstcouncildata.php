<?php
$page = 'showCOI';
include('header.php');
?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@600&display=swap" rel="stylesheet">
<style type="text/css">

/* Style the buttons that are used to open and close the accordion panel */
.accordion {
  background-color: #502b53;
  font-size: 16px;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
  background-color: #292d41;
  font-size: 20px;
  color: #f3bf00;
  font :bold;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
  padding: 5px 20px;
  background-color: #6b8280;
  display: none;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.accordion:after {
  content: '\02795'; /* Unicode character for "plus" sign (+) */
  font-size: 12px;
  color: #777;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2796"; /* Unicode character for "minus" sign (-) */
}

.link {
  color: white;
  font-size: 18px;
  font-family: swap;
  /*text-decoration: underline;*/
  /*text-decoration-color: #04040d;*/
}

.link:hover {
  color: #221c01;
  font-size: 18px;
  /*text-decoration: underline;*/
  /*text-decoration-color: #1414b4;*/
}
</style>
<div class="col-md-16 col-sm-16 left-section">

        <h1>
            GST Council Meeting
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
            </ol>
        </h1>
        <div class="col-md-16">
            <?php
                $tableData = "";
                $query = "SELECT * from gst_council_meeting_chapter order by id DESC";
                $result = mysqli_query($GLOBALS['con'],$query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $Chapter_Date = DateTime::createFromFormat('Y-m-d', $row['chapter_date'])->format('d-m-Y');?>
                    <button class="accordion" style="margin-top: 2px;"><span style="padding-right: 15px;"><?php echo $row['chapter_name']; ?></span>[<span><?php echo $Chapter_Date; ?></span>]</button>
                    <div class="panel">
                    <?php 
                    $sectionQuery = "SELECT * from gst_council_meeting WHERE chapter_id=" . $row['id'] . " order by meeting_no ASC";
                    $SectionResult = mysqli_query($GLOBALS['con'],$sectionQuery);
                    while ($sectionRow = mysqli_fetch_assoc($SectionResult)) {    
                        $encryptyId = base64_encode(base64_encode($sectionRow['id']));?>
                            <p><?php echo "<a class='link' target='_blank' href='" . $getBaseUrl . "showiframe4?V1Zaa1VsQlJQVDA9=$encryptyId&showGSTCouncilMeeting'> " . $sectionRow['meeting_name'] . " </a>";?>
                            </p>
             <?php  }?>
                    </div>
          <?php } ?>
        </div>
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
