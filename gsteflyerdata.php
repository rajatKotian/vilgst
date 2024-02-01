<?php
$page = 'showCOI';
include('header.php');
?>
<style type="text/css">
  html, body {
      overflow: auto !important;
  }
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
</style>
<script type="text/javascript">
    var calcHeight = function() {
        var the_height = document.getElementById('iFramePopupFrame').contentWindow.document.body.scrollHeight + 50;
         //isPdf=0
                              
        if ($('#iFramePopupFrame').attr('isPdf')=='0'){
            document.getElementById('iFramePopupFrame').height = the_height;    
        }
        
        
//        document.getElementById('navigation-left').height = the_height;
        $('#navigation-left').css('height', the_height + 'px');
        $('.expanding-blocks').click(function() {
            if ($(this).find('.expand').html() == '+') {
                $('.expand').html('+');
                $('.listing-blocks').hide();
                var data_block = $(this).attr('data-block');
                $('#listing-' + data_block).show();
                $(this).find('.expand').html('-');
            } else {
                $('.expand').html('+');
                $('.listing-blocks').hide();
            }
        });

        $('.listing-blocks a').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            var linktoopen = $(this).attr('perm-link');

            var linktoOpenNew = $(this).attr('href');
            $('.btn_open_new_window').attr('href', linktoOpenNew);

            $('#iFramePreviewFrame').attr('src', linktoopen);
            var the_height2 = document.getElementById('iFramePreviewFrame').contentWindow.document.body.scrollHeight + 50;
            $('#iFramePreviewFrame').height('580px');
//            iFramePreviewFrame
            $('#recordInfoModal').modal('show');
        });
              
      // alert($( window ).width());
        if($( window ).width() < 768 ){
            $('#navigation-left').css('display','none');
            $('#rightDisplayBordered').css('width','100%');
        }else{
            $('#navigation-left').css('display','table');
        }        
    }
</script>
<div class="col-md-16 col-sm-16 left-section">
    <h1>
        GST e-flyer
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
        </ol>
    </h1>
    <div class="col-md-16">
      <?php 
      if (isLogeedIn()) {
        $bordered_width = "100%"; ?>
        <div id='rightDisplayBordered' class="bordered" style="width:<?php echo $bordered_width;?>;float:right">
        <?php
        $destination_Path = '/data/GSTCouncilMeeting/';
        $file_path = 'GST E-Flyers.htm'; 
        $isPDFLink =  "isPdf=0";
        if ($file_extn == 'pdf') { 
            $isPDFLink =  "isPdf=1";
        }?>
        <iframe onLoad="calcHeight();" <?php echo $isPDFLink ; ?>   id='iFramePopupFrame' name='iFramePopupFrame' <?php      
          if ($file_extn == 'pdf') {?>
            src='<?php echo $getBaseUrl . $destination_Path . $file_path; ?>' <?php
          } else {
              ?> src='<?php echo "-?l=" . encrypt_url($getBaseUrl . $destination_Path . $file_path); ?>' <?php
          } ?> frameborder='0' allowtransparency='true' scrolling='no' width="100%" <?php

          if ($file_extn == 'pdf') {
              echo " height='1130' ";
          }?> >
        </iframe>
      </div>
<?php } else {?>
        <div class="col-md-16">
          <div class="alert alert-warning always-show" style="display: none;">This is <strong>Member Area </strong>- Please <a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Login</a> to view this page. </div>
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
