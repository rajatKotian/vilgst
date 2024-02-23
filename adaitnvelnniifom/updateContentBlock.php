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
      <h1><!--?php echo str_replace("-", " ", $row['content_type']). ' Setting';  ?--><small>it all starts here</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title"><!--?php echo str_replace("-", " ", $row['content_type']). ' Setting';  ?--> </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div>            
        <div class="box-body">
          <form name="form1" class="form-horizontal" method="post" action="../editContentBlock.php" enctype="multipart/form-data"  onSubmit="return ValidateForm()">
            <input type="hidden" name='content_id' id='content_id' value="<?php echo $row['content_id'];?>" />
            <div class="form-group">            
              <label class="col-sm-3 control-label">Active on Home page</label>
              <div class="checkbox">
                <label><input type="checkbox" <?php if($row['active_flag']=="Y") { echo 'checked="checked"'; } ?>  name="active_flag" id="active_flag" class="checkbox" value="Y" style="width: 20%;" ></label>  
              </div>              
            </div>
            <!--?php if($row['title'] != '' || $row['title'] != null) {  ?-->
            <div class="form-group">
              <label class="col-sm-3 control-label">Title</label> 
              <input type="text" name="contentTitle"  id="contentTitle" value="<?php echo $row['title']; ?>" class="form-control" style="width: 20%;">
            </div>
            
            <!--?php }  ?-->
            <!--?php if($row['file_path'] != '' || $row['file_path'] != null) {  ?-->
            
            <div class="form-group">
              <label class="col-sm-3 control-label">Upload File</label>
              <input type="file" name="fileStatus"  id="fileStatus" value="old"/>
                <div id="fileLinkContainer" style="padding-top:5px;">            
                  <!--a href="<?php echo $row['file_path'];?>" style="border-radius:5px; border:1px solid #CCC; padding:3px 7px; background:#EEE;" target="_blank"><?php echo $row['file_path'];?></a>&nbsp; &nbsp;<a href="javascript:void(0)" onclick="removefile()" style="text-decoration:underline">Remove (X) </a-->
                </div>
                <div style="display:none" id="fileContainer">
                  <input name="upload" type="file" placeholder="Upload" class="form-control" />
                </div>                     
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Code</label> 
              <input type="text" name="txtCode" id="txtCode" placeholder="Code" class="form-control" multiline="true" style="width: 20%;">
            </div>
            <div class="box-footer">
              <button type="submit" id="Submit" class="btn btn-primary">Update Setting</button>                    
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>