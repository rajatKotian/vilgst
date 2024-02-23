<?php 
  $pageType = '';
  include('header.php'); 
  $pageHead = 'Edit HTML File';
  $addText =  ''; 
  $primaryKey = $_GET['primarykey'];
  $tableName = $_GET['table'];
  $title = $_GET['title'];
  $name = $_GET['name'];
  $tableType = 'a';
?>

<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<?php 
  if(isset($_POST['save-html'])) {

	$data_to_write = stripslashes($_POST['editor']);
	$file_path = $_POST['file_path'];
  $data_id = $_POST['data_id'];
  $dataTypeText = $_POST['dataType'];
  $cir_no = $_POST['cir_no'];
	// Write the contents back to the file

  // file_put_contents("../$file_path", utf8_decode($data_to_write)); // for server
   if(file_put_contents("../$file_path", utf8_decode($data_to_write))){
      $file_data=addslashes($data_to_write);
      $where_clause=$_POST['field_name']."=".$data_id;
      $form_data = array(
          'file_data'=>strip_tags($file_data),
          'updated_by' => $_SESSION['user'],
          'updated_dt' => date('Y-m-d H:i:s')
        );
      dbRowUpdate($_POST['table_name'],$form_data,$where_clause);
   }
	 

  echo '<div class="content-wrapper">
  <!-- Content Header  -->
    <section class="content-header">

      <h1><?php echo "'.$dataTypeText  .'"; ?>  </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "'.$dataTypeText .'"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="alert alert-success alert-dismissable" style="display: block; margin-top: 30px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div style=" font-size: 20px; text-align: center;">  <i class="icon fa fa-check"></i> HTML Data File (<b>'.$cir_no. '</b> <u>#'.$data_id.'</u>) updated successfully !</div>
        <div style=" font-size: 12px; text-align: center; margin-top: 10px"> <em>Automatically closing this page after 3 seconds.</em> </div>
      </div>
    </section> 
    <script>
     setTimeout("window.close()", 3000);
    </script>
  </div>';
  } 
 
?>



<?php 

    if(isset($_GET['V1Zaa1VsQlJQVDA9'])) {				
			//$encryptID = base64_encode(base64_encode($_GET['id']));
			$decryptID = base64_decode(base64_decode($_GET['V1Zaa1VsQlJQVDA9']));

			$result = mysqli_query($GLOBALS['con'],"SELECT * FROM $tableName where  $primaryKey = '$decryptID'");

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

			        while($row = mysqli_fetch_array($result)) {
 	        // $file_path = str_replace(" ","%20","http://localhost/harry/Vligst%20Download/".$row['file_path']); localhost
					$file_path = str_replace(" ","%20","https://www.vatinfoline.com/".$row['file_path']);	
					$file_extn = strtolower(substr($file_path,-3));	

				// 	$pageContent = file_get_contents("$file_path",false, stream_context_create($arrContextOptions));
					
					$fileUrl = __DIR__. "/../" . str_replace("https://www.vilgst.com","",$row['file_path']);	
					$htmlUrl = "https://vilgst.com/". $row['file_path'];
		            $handle = fopen ($fileUrl, "r", false, stream_context_create($arrContextOptions));
                    $pageContent = stream_get_contents($handle);
                    fclose($handle);
					
					
					
         // $pageContent = mb_convert_encoding($pageContent, 'HTML-ENTITIES', "UTF-8");
          $pageContent = cleanname(utf8_encode($pageContent));


    ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 
    <!-- Main content -->

    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small> <?php echo "$pageHead $addText"; ?> data here</small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
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
        <div>  <i class="icon fa fa-check"></i> HTML Data File updated successfully !</div>
      </div>

    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title"><?php echo "$title". " [<b>".$row[$name] ." - #".$row[$primaryKey] ."</b> ]"; ?></h3>
          <div class="box-tools pull-right">
          	<a href="mediaLibrary.php" target="_blank">Media Library</a> &nbsp; &nbsp; 
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div> 
        <div class="box-body" >

    		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="editHTML" name="editHTML" method="post" >
          <input id="file_path" name="file_path" type="hidden" value="<?php echo $row['file_path']; ?>" />
          <input id="cir_no" name="cir_no" type="hidden" value="<?php echo $row[$name]; ?>" />
          <input id="field_name" name="field_name" type="hidden" value="<?php echo $primaryKey; ?>" />
          <input id="table_name" name="table_name" type="hidden" value="<?php echo $tableName; ?>" />
          <input id="data_id" name="data_id" type="hidden" value="<?php echo $row[$primaryKey]; ?>" />
          <input id="dataTypeText"  name="dataTypeText" type="hidden" value="<?php echo "$pageHead"; ?>" />
			   	<textarea id="editor" name="editor"></textarea>
				<div class="box-footer">
			      	<label class="col-sm-5 control-label"></label>
			    	<div class="col-sm-7">
			      		<button type="submit" class="btn btn-lg btn-primary" name="save-html" id="save-html">Save HTML</button>
			      	</div>
			    </div>
			</form>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->


<?php } } ?>

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>
<!-- <script src='//tinymce.cachefly.net/4.3/tinymce.min.js'></script> -->
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
        <script>
        
            $(document).ready(function() {
               //function created by harshal to load full html page including css file.
                $.get("<?php echo $htmlUrl; ?>", function(data, status){
                     CKEDITOR.replace('editor', {fullPage: true,
        allowedContent: true });
                     CKEDITOR.instances['editor'].setData(data);
                });
            });

        </script>


