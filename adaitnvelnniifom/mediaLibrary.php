<?php 
  $pageType = 'mediaImages';
  include('header.php'); 
  $pageHead = 'Media Library';
  $addText =  '';  
  $tableName = 'media_library' ;
?>
<?php
if(isset($_POST['submit'])){
    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                //save the url and the file
                $file_path = "/media/" . date('dmYHis').'-'.$_FILES['upload']['name'][$i];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $_SERVER['DOCUMENT_ROOT'].$file_path)) {

                    $files[] = $shortname;
                    $filenameExtn = array_pop(explode(".", $shortname));

                    $form_data = array(
                      'media_type' => "images:".strtolower($filenameExtn),
                      'file_path' => $file_path,
                      'uploaded_by' => $_SESSION['user'],
                      'uploaded_dt' => date('Y-m-d H:i:s')
                    );

                    dbRowInsert($tableName, $form_data);

                }
              }
        }
    }
    header('Location: mediaLibrary.php');
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
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small>All data related to <?php echo "$pageHead $addText"; ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <div>  <i class="icon fa fa-check"></i> Data (Case id #<strong></strong>) <span>updated</span> successfully !</div>
      </div>   
      <div class="alert alert-error alert-dismissable alert-error-primary">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
      </div>
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title">Upload New Images</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>            
        <div class="box-body">
              <div class="row">
               <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <form action="" enctype="multipart/form-data" method="post"  class="form-group">
                    <div class="row" style="text-align: center; width: 100%;">

                      <div style="margin: 0 auto; width: 50%; ">
                        <label for='upload' style="float: left; margin-right: 15px">Select Images </label>
                        <input id='upload' name="upload[]" type="file" multiple="multiple" style="float: left; margin-right: 15px" />
                        <input type="submit" name="submit" value="Upload" class="btn btn-primary" style="width: 100px;"  />
                      </div>
                    </div>
                  </form> 
     
                </div>
 
              </div>


         </div><!-- /.box-body -->        
      </div><!-- /.box -->

      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
          <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Image Preview</th>
                <th style="min-width: 400px;">Image Path</th>
                <th  style="text-align: center; width: 120px;">Uploaded Date</th>
                <th>EDIT</th>
                <th>DELETE</th>
              </tr>
            </thead>  
            <tbody>      
          <?php  
        
            $result = mysqli_query($GLOBALS['con'],"SELECT * FROM ".$tableName." ORDER BY media_id DESC");
            if($result === FALSE) { 
                die(mysql_error());  
            }
            while($row = mysqli_fetch_array($result)) {
              $abs_path = "https://www.vilgst.com".$row['file_path']; //https://www.vatinfoline.com/".substr("$filePath$img",3);
              $uploaded_dt = date('d-m-Y',strtotime($row['uploaded_dt']));

              ?>    <tr>
                      <td>
                        <a href='<?php echo $abs_path; ?>' target='_blank' data-url='$abs_path' class='modal-image'>
                          <img src='<?php echo $abs_path; ?>' style='max-height: 50px;' /></a>
                      </td>
                      <td><?php echo $abs_path; ?> </td>
                      <td style='text-align: center'><?php echo $uploaded_dt; ?></td>
                      <td>
                        <a href='MediaLibraryEdit.php?id=<?php echo $row['media_id']; ?>' data-id='<?php echo $row['media_id']; ?>' data-table='media_library' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>
                      </td>
                      <td>
                        <a href='#' data-id='<?php echo $row['media_id']; ?>' data-table='media_library' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>
                      </td>
                    </tr><?php    
            }
           
          ?>  
            </tbody>      
            <tfoot>
              <tr>
                <th>Image Preview</th>
                <th>Image Path</th>
                <th>Uploaded Date</th>
                <th>EDIT</th>
                <th>DELETE</th>
              </tr>
            </tfoot>
          </table> 
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
 
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
//        viewDataTableCustom();
        $('#dataResult').dataTable({
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            "dom": '<"row"<"col-md-4"f><"col-md-4"><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
            "drawCallback": function() {
                loadPopupModalDeleteAll('media_library', 'delete');
                copyLinkToClipboard();
//                initHtmlEditPage();
            },
            "initComplete": function() {
                $('[data-toggle="tooltip"]').tooltip();
                loadPopupModalDeleteAll('media_library', 'delete');
                copyLinkToClipboard();
//                initHtmlEditPage();
            }
        });
    });

    var loadPopupModalDeleteAll = function(file, action) {

        var $modal = $('#load-popup-modal'),
                alertSuccess = $('.alert-success'),
                alertError = $('.alert-error'),
                alertErrorModal = $('.alert-error-modal'),
                alertErrorPrimary = $('.alert-error-primary');


        $('.' + action + '-data').on('click', function(e) {
            e.preventDefault();

            var dataType = $(this).data('table');

            if (dataType != null) {
                dataType = 'data=' + dataType;
            }


            $modal.load('modals/' + action + '/' + file + '.php?' + 'data=' + $(this).data('table'), {'id': $(this).data('id')},
            function() {
                $modal.modal('show');

                $('#' + action + '-form').on("submit", function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    $.ajax({
                        url: 'modals/' + action + '/' + file + '.php?' + action + '=' + $('#' + action + '-id').val() + '&' + dataType,
                        type: 'POST',
                        data: new FormData(this),
                        cache: false,
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(data, textStatus, jqXHR) {

                            if ($.trim(data) == 'success') {
                                $modal.modal('hide');
                                alertSuccess.show().find('strong').html($('#' + action + '-id').val());
                                alertSuccess.show().find('span').html('' + action + 'd');
                                window.alert('Data id #' + $('#' + action + '-id').val() + ' ' + action + 'd successfully !');
                                setTimeout(function() {
                                    alertSuccess.fadeOut(800);
                                    //refresh this page.
                                    location.reload();
                                }, 2000);
                                //viewDataTableCustom();
                            } else if ($.trim(data) == 'securityerror') {
                                alertErrorModal.show().find('span').html('You have entered wrong security. Please enter correct code.');
                                window.alert('You have entered wrong security. Please enter correct code.');
                                $('#txtCode').addClass('error');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertErrorPrimary.show().find('span').html(action);
                            setTimeout(function() {
                                alertErrorPrimary.fadeOut(800);
                            }, 2000);
                        }
                    });


                });
            });
        });
    };


</script>

