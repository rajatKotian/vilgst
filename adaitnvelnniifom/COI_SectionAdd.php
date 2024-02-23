<?php
$dataType = 'addSection';
$pageType = 'COISectionAddSection';
$pageHead = '';

include('header.php');
$addText = ' - COI Section';
if (isset($_GET['chapter_id'])) {
    $chapter_id = $_GET['chapter_id'];
}

?>
<div class="wrapper">
    <?php include('titlebar.php'); ?>
    <?php include('sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content-header">
            <input type="hidden" id="dataType" value="<?php echo "$dataType"; ?>" />
            <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
            <input type="hidden" id="chapterId" value="<?php echo "$chapter_id"; ?>" />
            <h1>Add <?php echo "$pageHead $addText"; ?> <small> Add <?php echo "$pageHead $addText"; ?> data here</small></h1>
        </section>



        <!-- Main content -->
        <section class="content">
            <div class="alert alert-error alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div><i class="icon fa fa-warning"></i><span></span> </div>
            </div>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div>  <i class="icon fa fa-check"></i> <span></span></div>
            </div>
            <!-- Default box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$pageHead"; ?></h3>
                    <div class="box-tools pull-right">
                        <a href="COI_SectionList.php">List <?php echo "$pageHead"; ?> Sections</a> &nbsp; &nbsp;             
                    </div>
                </div> 
                <div class="box-body" id="load-add-form">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php include('copyright.php'); ?>
</div><!-- ./wrapper -->
<?php include('footer.php'); ?>
<!--<script src='//tinymce.cachefly.net/4.3/tinymce.min.js'></script>-->
<script type="text/javascript">
    $(document).ready(function() {
        loadAddFormCOIArticle('coi_section', $('#chapterId').val());
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