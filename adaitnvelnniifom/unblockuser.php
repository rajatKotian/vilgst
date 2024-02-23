<?php 
  $page = 'index';
  include('header.php'); 
?>

<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Unblock User<small>it all starts here</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
         <h3 class="box-title">Unblock User</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div>            
        <div class="box-body">
        <!--?php if(isset($_GET['username'])){ ?-->
          <form name="form1" class="form-horizontal" method="post" action="authblockuser.php" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-3 control-label">User ID</label> 
              <input type="text" name="txtid" id="txtid" placeholder="User ID" value="<?php echo $_GET['username']; ?>" class="form-control" style="width: 20%;" >
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">User ID</label> 
              <input type="text" name="txtid" id="txtid" placeholder="User ID" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>"  class="form-control" style="width: 20%;" >
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Code</label> 
              <input type="text" name="txtCode" id="txtCode" placeholder="Code" multiline ="true" class="form-control" style="width: 20%;" >
            </div>
            <div class="box-footer">
              <button type="submit" id="Submit" class="btn btn-primary">Block User</button>                    
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>