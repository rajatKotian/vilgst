<?php 
  include('header.php'); 
  include('plugins/browser/Mobile_Detect.php');
  include('plugins/browser/BrowserDetection.php');
  $pageType = 'viewUsers';
  $pageHead = 'Users';
  $addText =  '';   
  $table = 'login_history';
  date_default_timezone_set('Asia/Kolkata');
  $browser=new Wolfcast\BrowserDetection;
  $browser_name=$browser->getName();
  $browser_version=$browser->getVersion();

  $detect=new Mobile_Detect();

  if($detect->isMobile()){
    echo $type='Mobile';
  }elseif($detect->isTablet()){
    echo $type='Tablet';
  }else{
    echo $type='PC';
  }

  if($detect->isiOS()){
    echo $os='IOS';
  }elseif($detect->isAndroidOS()){
    echo $os='Android';
  }else{
    echo $os='Window';
  }
?>
<style type="text/css">
    .main-filter-filter {
      position: absolute;
      top: 5px;
      left: 30%;
      width: 300px;
    }
    #custom_search_container {
        background: #FFF;
        left: 0; 
        padding-top:5px;
        position: absolute;
        width: 500px;
        z-index: 100;
        top: 0;
    }

    #custom_search_container label { font-weight: normal;}

    #custom_search_container .form-group { overflow: hidden; margin-bottom: 0 }


    #custom_search_container #custom_search_input_container * {
        float: left;
    }

    #custom_search_container #custom_search_input_container {
        margin-top: 4px;
        margin-left: 8px;
        display: none;
    } 

    #custom_search_container #custom_search_input_container input {
        width: 280px;
        margin-left: 6px;
    }

    #custom_search_container #custom_search_input_container label {
        margin-top: 5px;
        width: 375px;
    }

    #custom_search_container #custom_search_input_container label span {
        padding-top: 4px;
        padding-left: 8px;

    }

    #custom_search_container button {
        width: 100px;
        margin-top: 2px;
    }
</style>
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

      <div class="box">

        <div class="box-header">

          <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>

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

          <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
            <?php $date = date('m/d/Y H:i:s', time());?>
            <thead>
                <tr>
                    <th style="min-width: 5px;">Login ID</th>
                    <th style="min-width: 20px;">User Name</th>
                    <th>Login Date</th>
                    <th>IP ADDRESS</th>
                    <th>ONLINE/OFFLINE</th>
                    <th>Devices</th>
                    <th>OS</th>
                    <th>Browser Name</th>
                    <th>Browser Version</th>
                    <th>User Type</th>
                </tr>
            </thead>
            <tbody>
              <?php
                  $query = "SELECT * FROM $table";
                  $result = mysqli_query($GLOBALS['con'],$query);
                  while ($row = mysqli_fetch_array($result)) {
                    $user_id = $row['user_id'];
                    $login_dt = $row['login_dt'];
                    $query2 = "SELECT * FROM userlogins WHERE user_id = $user_id";
                    $result2 = mysqli_query($GLOBALS['con'],$query2);
                    while ($row2 = mysqli_fetch_array($result2)) {
              ?>
              <tr>
                <td><?php echo $row['log_hist_id']; ?></td>
                <td><?php echo $row2['username']; ?></td>
                <td><?php echo $row['login_dt']; ?></td>
                <td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
                <td><?php if (($login_dt) > ($date)) { echo '<h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;">ONLINE</h5>'; } else { echo '<h5 class="btn btn-danger" style="padding-left: 5px; padding-right: 5px;">OFFLINE</h5>'; } ?></td>
                <td><?php if($detect->isMobile()){ echo '<h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;">Mobile</h5>'; } elseif($detect->isTablet()){ echo '<h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;">Tablet</h5>'; }else { echo '<h5 class="btn btn-danger" style="padding-left: 5px; padding-right: 5px;">PC</h5>'; } ?></td>
                <td><?php if($detect->isiOS()){ echo '<h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;">IOS</h5>'; } elseif($detect->isAndroidOS()){ echo '<h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;">Android</h5>'; } else { echo '<h5 class="btn btn-danger" style="padding-left: 5px; padding-right: 5px;">Window</h5>'; } ?></td>
                <td><h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;"><?php echo $browser_name; ?></h5></td>
                <td><h5 class="btn btn-success" style="padding-left: 5px; padding-right: 5px;"><?php echo $browser_version; ?></h5></td>
                <td><?php echo $row2['user_type']; ?></td>
              </tr>
              <?php } 
                }
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Login ID</th>
                <th>User Name</th>
                <th>Login Date</th>
                <th>IP ADDRESS</th>
                <th>ONLINE/OFFLINE</th>
                <th>Devices</th>
                <th>OS</th>
                <th>Browser Name</th>
                <th>Browser Version</th>
                <th>User Type</th>
              </tr>
            </tfoot>
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  // var firebaseConfig = {
  //   apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
  //   authDomain: "vilgst.firebaseapp.com",
  //   projectId: "vilgst",
  //   storageBucket: "vilgst.appspot.com",
  //   messagingSenderId: "493343969816",
  //   appId: "1:493343969816:web:2ea8047fba70f4980d696d",
  //   measurementId: "G-DQNYHJLPB3"
  // };
  // Initialize Firebase
  //firebase.initializeApp(firebaseConfig);
  //firebase.analytics();
</script>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

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
  

<?php include('copyright.php'); ?>
</div><!-- ./wrapper -->

<?php include('footer.php'); ?>

<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-firestore.js"></script>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
//        viewDataTableCustom();
        $('#dataResult').dataTable({
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            "dom": '<"row"<"col-md-4"f><"col-md-4"><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
        });
    });

</script>