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
          <h1>Remove Archive Cases<small>it all starts here</small></h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Remove Archive Cases</h3>
                </div><!-- /.box-header -->
                 <!-- form start -->
                <form role="form" class="form-horizontal" method="post" action="authRemoveAData.php" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ID</label>
                            <input type="text" name="txtid" id="txtid" placeholder="ID" class="form-control" style="width: 20%;"> 
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Code</label>
                            <input type="text" name="txtCode" id="txtCode" placeholder="Code" class="form-control" multiline ="true" style="width: 20%;">
                        </div>  
                    </div><!-- /.box-body -->  
                    <div class="box-footer">
                        <button type="submit" id="Submit" class="btn btn-primary">Remove Archive Case</button>                    
                    </div>            
                </form>
            </div><!-- /.box -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>
 
</div><!-- ./wrapper -->

<?php include('footer.php'); ?>