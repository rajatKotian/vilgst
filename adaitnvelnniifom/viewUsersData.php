<?php 
  $pageType = 'viewUsers';
  include('header.php'); 
  $pageHead = 'Users';
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
      <div>  <i class="icon fa fa-check"></i> Data (User id #<strong></strong>) <span>updated</span> successfully !</div>
    </div>   
    <div class="alert alert-error alert-dismissable alert-error-primary">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
    </div>  
    <!-- Default box -->
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
         <h3 class="box-title">Filter</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
          </div>
        </div>            
        <div class="box-body">
          <div class="row">
            <div class="col-md-9">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Select Users Date Range</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    
                  <form class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="control-label">Start Date</label>
                        <input type="text" name="start_date" id="start_date" placeholder="Start Date" class="form-control" value=""  />
                      </div>
                      <div class="col-md-4">
                        <label class="control-label">End Date</label>
                        <input type="text" name="end_date" id="end_date" placeholder="End Date" class="form-control" value=""  />
                      </div>
                      <div class="col-md-4">
                        <label class="control-label" style="width:100%"> &nbsp;</label>
                        <button class="btn btn-block btn-primary pull-left" id="daterange-btn-search">Search</button>
                        <button class="btn btn-default pull-left" id="clear-search" type="reset">Clear Search</button>
                      </div>

                    </div>
                  </form>
                </div>
              </div><!-- /.box -->
 
            </div>
            <div class="col-md-6">
              <!-- Horizontal Form -->                 
            </div>            
          </div>
        </div><!-- /.box-body -->        
      </div><!-- /.box -->

      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
          <div class="box-tools pull-right">
            <a href="addUserData.php">Add <?php echo "$pageHead"; ?></a>           
          </div>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container">
         <div class="form-group main-filter-filter">
            <label>User Type</label>
            <select id="user_type" class="form-control" name="user_type" style="width: 150px;">
              <option value="0">All Users</option>                        
              <option value="A">Admin</option>                        
              <option value="S">Subscriber</option>                        
              <option value="T">Temp User</option>                        
            </select>
          </div>
          <table id="dataResult" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th style="min-width: 150px;">Company Name</th>
                <th>Email ID</th>
                <th style="min-width: 80px;">From Date<br />To Date</th>
                <th style="min-width: 35px;">User Type</th>
                <th style="min-width: 25px;">Hit counts</th>
                <th style="min-width: 80px;">Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>User ID</th>
                <th>Username </th>
                <th>Password</th>
                <th>Company Name</th>
                <th>Email ID</th>
                <th>From Date<br />To Date</th>
                <th>User Type</th>
                <th>Hit counts</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
    authDomain: "vilgst.firebaseapp.com",
    projectId: "vilgst",
    storageBucket: "vilgst.appspot.com",
    messagingSenderId: "493343969816",
    appId: "1:493343969816:web:2ea8047fba70f4980d696d",
    measurementId: "G-DQNYHJLPB3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
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
      "autoFill": true,
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "ajax": "response/viewUsersData.php?"+whereQuery,
      "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
      "columns": [
              { "data": "id" },
              { "data": "username" },
              { "data": "pwd" },
              { "data": "comapany" },
              { "data": "email" },
              { "data": "user_date" },
              { "data": "user_type" },
              { "data": "totalhitcount" },
              { "data": null, render: function ( data, type, row ) {
                  return " <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";                  
                  } 
              } 
        ],
        "columnDefs": [
          {
             "targets": [ 1, 2, 3, 4, 5, 6, 7, 8],
              orderable: false
            } 

        ],
      "drawCallback" : function () {
        loadPopupModalUpdateDelete('user','update');
        loadPopupModalUpdateDelete('user','delete'); 
      },            
      "initComplete": function () {
        popOverCustom();
        loadPopupModalUpdateDelete('user','update');
        loadPopupModalUpdateDelete('user','delete');      
      }
    });  
};

$(document).ready(function(){

  viewDataTableCustom();

  $('#user_type').on('change', function() {
      $( "#start_date, #end_date" ).val('');
      viewDataTableCustom('user_type='+$('#user_type').val());
  });

  $('#daterange-btn-search').on('click', function(e) { 
    e.preventDefault();
    var user_type = $('#user_type').val(),
        start_date = $('#start_date').val(),
        end_date = $('#end_date').val();

    if(user_type != '0') {
      viewDataTableCustom('user_type='+user_type+'&start_date='+start_date+"&end_date="+end_date);
    } else {
      viewDataTableCustom('start_date='+start_date+"&end_date="+end_date);
    }
  });

  $('#clear-search').on('click', function() { 
    var user_type = $('#user_type').val();

    if(user_type != '0') {
      viewDataTableCustom('user_type='+sub_prod_id);
    } else {
      viewDataTableCustom();
    }
  });

 
}); 

</script>