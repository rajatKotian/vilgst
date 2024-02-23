<?php
$dataType = 'EditArticle';
$pageType = 'COIArticleEditArticle';
$pageHead = '';

include('header.php');
$addText = ' - COI Article';
//$chapter_id = $_GET['id'];

if (isset($_GET['id'])) {
    //get chapter detail by id
    $id = cleanForDB($_GET['id']);
    $article_data = getCOIArticlebyId($_GET['id']);
}
$article_id = 0;
if (count($article_data) > 0 && $article_data['id'] == $id) {
    $validId = true;
    $article_id = $id;
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
            <input type="hidden" id="article_id" value="<?php echo "$article_id"; ?>" />
            <h1>Add <?php echo "$pageHead $addText"; ?> <small> Add <?php echo "$pageHead $addText"; ?> data here</small></h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="alert alert-error alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div><i class="icon fa fa-warning"></i><span>Invalid Article id</span> </div>
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
                        <a href="COI_ArticleList.php">List <?php echo "$pageHead"; ?> Articles</a> &nbsp; &nbsp;             
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
        if ($('#article_id').val() != 0) {
            loadEditFormCOI('coi_article', $('#article_id').val());
        } else {
            $('.alert-error').show();
        }
    });
</script>
