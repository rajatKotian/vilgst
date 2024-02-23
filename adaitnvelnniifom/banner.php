<?php 
  $pageType = 'mediaImages';
  include('header.php'); 
  $pageHead = 'Media Library';
  $addText =  '';  
  $tableName = 'banner' ;
?>
<?php
if(isset($_POST['submit'])){
    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
       
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            $active = $_POST['active'];
            $link = $_POST['link'];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'];
				$url = "../banner/"; 
                //save the url and the file
                $file_path =  date('dmYHis').'-'.$_FILES['upload']['name'];

                //Upload the file into the temp dir
                move_uploaded_file($tmpFilePath, $url.$file_path);

              

				  $result = mysqli_query($GLOBALS['con'],"update banner set image_name='$file_path'");
                
              }
			  $result = mysqli_query($GLOBALS['con'],"update banner set from1 = '$from', to1 = '$to', active='$active', link='$link'");
			header('Location: banner.php?success');
        
    }
}
?>
 
<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small>All data related to <?php echo "$pageHead $addText"; ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title">Upload New Images</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>            
        <div class="box-body">
		 <?php  
        
            $result = mysqli_query($GLOBALS['con'],"SELECT * FROM ".$tableName." ");
            if($result === FALSE) { 
                die(mysql_error());  
            }
            $row = mysqli_fetch_array($result)
              
           
          ?> 
              <div class="row">
               <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <form action="" enctype="multipart/form-data" method="post"  class="form-group">
                    <div class="row">
						<div class="col-sm-2">
							<div class="form-group">
							  <label for="">From:</label>
							  <input type="text" class="form-control"  name="from" value="<?php if(isset($row['from1']) && !empty($row['from1'])){echo $row['from1'];}?>" >
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
							  <label for="">To:</label>
								<input type="text" class="form-control" name="to" value="<?php if(isset($row['to1']) && !empty($row['to1'])){echo $row['to1'];}?>" >
							</div>						
						</div>
						<div class="col-sm-2">
							<div class="form-group">
							  <label for="sel1">Active</label>
							  <select class="form-control" name="active">
								<option value="Yes" <?php if(isset($row['active']) && !empty($row['active']) && $row['active'] =='Yes'){echo "selected";}?>>Yes</option>
								<option value="No" <?php if(isset($row['active']) && !empty($row['active']) && $row['active'] =='No'){echo "selected";}?>>No</option>
							  </select>
							</div>
						</div>
                      <div class="col-sm-3">
                        <div class="form-group">
						<label for='upload' style="float: left; margin-right: 15px">Select Images </label>
                        <input id='upload' name="upload" type="file" multiple="multiple" style="float: left; margin-right: 15px" />
						<img style="width:100px" src="<?php if(isset($row['image_name']) && !empty($row['image_name'])){echo "../banner/".$row['image_name'];}?>">
						</div>
                      </div>
						<div class="col-sm-2">
							<div class="form-group">
							  <label for="">Link:</label>
								<input type="text" class="form-control" name="link" value="<?php if(isset($row['link']) && !empty($row['link'])){echo $row['link'];}?>" >
							</div>						
						</div>
                     </div>
                      <div class="row">
                      <div class="col-sm-12 ">
                        <div class="form-group">
					  
							<input type="submit" name="submit" value="Upload" class="btn btn-primary" style="width: 100px;"  />
						
						</div>
						</div>
                    </div>
                  </form> 
     
                </div>
 
              </div>


         </div><!-- /.box-body -->        
      </div><!-- /.box -->

      

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 7px 10px 25px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
 
      </div>
    </div>
  </div>
</div>

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>
 


