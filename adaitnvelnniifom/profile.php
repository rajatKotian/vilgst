<?php 
  $pageType = 'HomePage';
  include('header.php'); 
  $pageHead = "Admin Profile";
  $addText = "Customise your settings";

?>

<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 
    <!-- Main content -->

    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead"; ?> <small> <?php echo "$addText"; ?> </small></h1>
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
        <div>  <i class="icon fa fa-check"></i> Settings updated successfully ! Please Logout and relogin the system to reflect changes !</div>
      </div>
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title">Update your profile and customise settings</h3>
           
        </div> 
        <div class="box-body" id="load-add-form" >

        

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function() {
    loadAddForm('profile');
  });
</script>