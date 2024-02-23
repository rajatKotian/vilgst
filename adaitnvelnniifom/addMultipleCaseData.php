<?php 
  $pageType = 'addMultipleCaseData';
  $pageHead = 'Add Multiple Cases';
  include('header.php'); 
  $addText = ' Upload CSV file to add multiple case data';
?>


<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 
    <!-- Main content -->

    <section class="content-header">
      <input type="hidden" id="dataType" value="" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead"; ?> <small> <?php echo "$addText"; ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="alert alert-error alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div><i class="icon fa fa-warning"></i><span>You have entered wrong security. Please enter correct code.</span> </div>
      </div>
      <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div>  <i class="icon fa fa-check"></i> Multiple case data added successfully !</div>
      </div>

    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title"><?php echo "$pageHead"; ?></h3>
          <div class="box-tools pull-right">
            <a href="multiplecase.csv" target="_blank">Download Sample CSV</a> &nbsp; | &nbsp; 
            <a href="masterIdReference.php" target="_blank">Get Product IDs</a> &nbsp;  &nbsp;
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
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
<script type="text/javascript">
  $(document).ready(function() {
    loadAddForm('archivecsv');
  });
</script>