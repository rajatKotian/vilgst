<?php 
  $pageType = 'addLibTypeData';
  include('header.php'); 
  $pageHead = 'Library Type';
  $addText =  '';  

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
      <div>  <i class="icon fa fa-check"></i> Data (Library id #<strong></strong>) <span>updated</span> successfully !</div>
    </div>   
    <div class="alert alert-error alert-dismissable alert-error-primary">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
    </div>  
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title"><?php echo "Add "."$pageHead "; ?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>            
        <div class="box-body">
          <div class="row">
           <div class="box-body" id="load-add-form"> </div>
          </div>

         </div><!-- /.box-body -->        
      </div><!-- /.box -->

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View <?php echo "$pageHead"; ?> Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
 
          <table id="dataResult" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">Library  ID</th>
                <th >Library Type</th>
                <th style="min-width: 50px;">Active</th>
                <th style="min-width: 100px;">Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Library  ID</th>
                <th>Library Type</th>
                <th>Active</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>

<script type="text/javascript" language="javascript" class="init">

var viewDataTableCustom = function(whereQuery) {
    var viewDataTable = $('#dataResult').dataTable({ 
      "bDestroy": true,
      "order": [[ 0, "desc" ]],
      "processing": true, 
      "serverSide": true, 
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "ajax": "response/viewLibTypeData.php?"+whereQuery,
      "dom": '<"row"<"col-md-6"f><"col-md-6"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
      "columns": [
              { "data": "id" },
              { "data": "library_name" },
              { "data": "active_flag" },
              { "data": null, render: function ( data, type, row ) {
                return "<a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";
                } 
              }  
        ],
        "columnDefs": [
          {
             "targets": [ 1, 2, 3],
              orderable: false
            } 

        ],
      "drawCallback" : function () {
        loadPopupModalUpdateDelete('libType','update');
        loadPopupModalUpdateDelete('libType','delete');      
      },            
      "initComplete": function () {
        loadPopupModalUpdateDelete('libType','update');
        loadPopupModalUpdateDelete('libType','delete');        
      }
    });  
};

$(document).ready(function(){
 
  viewDataTableCustom();
  loadAddForm('libType');

 
}); 

</script>