<?php
$dataType = 'EditSearchHistory';
$pageType = 'EditSearchHistory';
$pageHead = '';

include('header.php');
$addText = ' - Search History';

if (isset($_GET['id'])) {
    //get Search History detail by id
    $id = cleanForDB($_GET['id']);
    $SearchHistory = getSearchHistoryDatabyId($_GET['id']);
}

$SearchHistory_id = 0;
if (count($SearchHistory) > 0 && $SearchHistory['search_id'] == $id) {
    $validId = true;
    $SearchHistory_id = $id;
} else {
    $validId = false;
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
            <input type="hidden" id="SearchHistory_id" value="<?php echo "$SearchHistory_id"; ?>" />
            <h1>Edit <?php echo "$pageHead $addText"; ?> <small> Edit <?php echo "$pageHead $addText"; ?> data here</small></h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="alert alert-error alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div><i class="icon fa fa-warning"></i><span>Invalid Case id</span> </div>
            </div>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div>  <i class="icon fa fa-check"></i> <span>sdasd</span></div>
            </div>
            <!-- Default box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$pageHead"; ?></h3>
                    <div class="box-tools pull-right">
                        <a href="viewSearchHistoryList.php">List <?php echo "$pageHead"; ?> Search History</a> &nbsp; &nbsp;      
                    </div>
                </div> 
                <div class="box-body" id="load-Edit-form">

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
        if ($('#SearchHistory_id').val() != 0) {
            loadEditFormCOI('search_history', $('#SearchHistory_id').val());
        }else{
            $('.alert-error').show();
        }
    });
</script>