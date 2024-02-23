<?php
$dataType = 'EditMenu';
$pageType = 'EditMenu';
$pageHead = '';

include('header.php');
$addText = ' - Menu';

if (isset($_GET['id'])) {
    //get Mapping detail by id
    $id = cleanForDB($_GET['id']);
    $menu = getMenubyId($_GET['id']);
}
$menu_id = 0;
if (count($menu) > 0 && $menu['id'] == $id) {
    $validId = true;
    $menu_id = $id;
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
            <input type="hidden" id="menu_id" value="<?php echo "$menu_id"; ?>" />
            <h1>Edit <?php echo "$pageHead $addText"; ?> <small> Edit <?php echo "$pageHead $addText"; ?> data here</small></h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="alert alert-error alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div><i class="icon fa fa-warning"></i><span>Invalid Chapter id</span> </div>
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
                        <a href="menu_list.php">List <?php echo "$pageHead"; ?> Menu</a> &nbsp; &nbsp;             
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
        if ($('#menu_id').val() != 0) {
            loadEditFormCOI('menu', $('#menu_id').val());
        }else{
            $('.alert-error').show();
        }
    });
</script>
