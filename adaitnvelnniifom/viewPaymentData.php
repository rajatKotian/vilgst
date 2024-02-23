<?php 
  $pageType = 'viewPayment';
  include('header.php'); 
  $pageHead = 'Payment';
  $addText =  'History';  

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
                <th style="min-width: 20px;">User ID</th>
                <th>Name</th>
                <th style="min-width: 170px;">Transaction ID</th>
                <th style="min-width: 170px;">Transaction Ref No.</th>
                <th style="min-width: 40px;">Transaction Status</th>
                <th style="min-width: 70px;">Amount</th>
                <th style="min-width: 80px;">Payment Date</th>
                <th style="min-width: 100px;">Payment Mode</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Transaction ID</th>
                <th>Transaction Ref No.</th>
                <th>Transaction Status</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Payment Mode</th>
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

var viewDataTableCustom = function(dataType, whereQuery) {
    var customWhereQuery = "";
    var viewDataTable = $('#dataResult').dataTable({ 
      "bDestroy": true,
      "order": [[ 0, "desc" ]],
      "processing": true, 
      "serverSide": true, 
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "ajax": "response/viewPaymentData.php",
      "dom": '<"row"<"col-md-6"f><"col-md-6"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
      "columns": [
              { "data": "id" },
              { "data": "userid" },
              { "data": "name" },
              { "data": "txnid" },
              { "data": "txnrefno" },
              { "data": "txnstatus" },
              { "data": "amount" },
              { "data": "date" },
              { "data": "paymentMode" }   
        ],
        "columnDefs": [
          {
             "targets": [ 1, 2, 3, 4, 5, 6, 7, 8],
              orderable: false
            },
          { className: "right-aligned", "targets": [ 6 ] },
          { className: "center-aligned", "targets": [ 5, 7, 8 ] }


        ],
      "initComplete": function () {
        popOverCustom();
      }
    });  
};

$(document).ready(function(){
 
  viewDataTableCustom();
 
});  

</script>