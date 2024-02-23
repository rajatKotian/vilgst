<?php 
  $pageType = 'viewTax';
  include('header.php'); 
  $pageHead = 'Tax';
  $addText =  'Master';  

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
      <div>  <i class="icon fa fa-check"></i> Data (Tax id #<strong></strong>) <span>updated</span> successfully !</div>
    </div>   
    <div class="alert alert-error alert-dismissable alert-error-primary">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
    </div>  
    <!-- Default box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
 
          <table id="dataResult" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">ID</th>
                <th>Tax Name</th>
                <th style="min-width: 150px;">Percentage</th>
                <th style="min-width: 100px;">Edit</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Tax Name</th>
                <th>Percentage</th>
                <th>Edit</th>
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

var viewDataTableCustom = function() {
    var viewDataTable = $('#dataResult').dataTable({ 
      "bDestroy": true,
      "processing": true, 
      "serverSide": true, 
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "ajax": "response/viewTaxData.php",
      "dom": '<"row"<"col-md-6"f><"col-md-6"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
      "columns": [
              { "data": "id" },
              { "data": "taxname" },
              { "data": "percentage" },
              { "data": null, render: function ( data, type, row ) {
                  return "<a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>";
                  } 
              }   
        ],
        "columnDefs": [
          {
             "targets": [ 1, 2, 3],
              orderable: false
            },
            { className: "right-aligned", "targets": [ 2 ] },
            { className: "center-aligned", "targets": [ 3 ] } 

        ],
      "drawCallback" : function () {
        loadPopupModalUpdateDelete('tax','update');
      },            
      "initComplete": function () {
        loadPopupModalUpdateDelete('tax','update');
      }
    });  
};

$(document).ready(function(){
 
  viewDataTableCustom();
 
}); 

</script>
