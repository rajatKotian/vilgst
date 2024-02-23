<?php 
  $pageType = 'HomePage';
  include('header.php'); 
  $pageHead = "Dashboard";
  $addText = "Control Panel";

?>
<style>
.bg-red-gradient h1.box-title {
  padding: 20px;
  font-size: 25px;
  margin-bottom: 0;
  text-align: center;
  display: block;
  font-weight: bold;
}
 
</style>

<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 
    <!-- Main content -->

    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead"; ?> <small> <?php echo "$addText"; ?> </small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead"; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="box box-solid bg-red-gradient" style="margin-bottom: 0">
            <h1 class="box-title">Welcome to Admin Panel</h1>
          </div>
        </div> 
        <div class="box-body" >

      <div class="row">
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php 
                  $result = mysqli_query($GLOBALS['con'],"SELECT * FROM userlogins WHERE user_type != 'A'");  
                  echo mysqli_num_rows($result);
                 ?>  
              </h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="viewUsersData.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
                  <!-- Small boxes (Stat box) -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php 
                  $result = mysqli_query($GLOBALS['con'],"SELECT * FROM payment_history WHERE txnstatus = 'SUCCESS' AND paymentdate BETWEEN NOW() - INTERVAL 360 DAY AND NOW()");  
                  echo mysqli_num_rows($result);
                 ?>
               </h3>

              <p>New Online Orders (Last 3 Months)</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="viewPaymentData.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         

         
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">         

          <!-- solid sales graph -->
          <div class="box box-solid bg-yellow-gradient">
            <div class="box-header">
              <i class="fa fa-users"></i>

              <h3 class="box-title"> User Registrations</h3>
                <?php $time = $_SESSION['expire_time'];
                
                echo $time;?>
              <div class="box-tools pull-right">
                <span>(Last 10 Year records) &nbsp;</span>
                <button type="button" class="btn bg-yellow btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-yellow btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="users-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->         

        </section>
        <!-- /.Left col -->
        <!-- right col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="box box-solid bg-teal-gradient">
            
            <div class="box-header">
              <i class="fa fa-line-chart"></i><h3 class="box-title"> Sales</h3>
              <div class="box-tools pull-right">
                <span>(Last 5 Year records) &nbsp;</span>
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="sales-chart" style="height: 250px;"></div>
            </div>

          </div>
          <!-- /.nav-tabs-custom -->
        </section>
        
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
   </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->



<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>

<script type="text/javascript">

$(function () {
 

  var line = new Morris.Line({
    element: 'users-chart',
    resize: true,
    data: [
     <?php 
      $years = array();
      $currYear = date("Y");
      for ($x = 0; $x <= 9 ; $x++) {
        array_push($years, $currYear - $x);
      }
      //$years = array("2010", "2011", "2012", "2013","2014", "2015", "2016", "2017"); 
      foreach ($years as $value) {
       
        $resultAll = mysqli_query($GLOBALS['con'],"SELECT * FROM userlogins WHERE YEAR(created_dt) = $value AND user_type != 'A'");  
        $resultTemp = mysqli_query($GLOBALS['con'],"SELECT * FROM userlogins WHERE YEAR(created_dt) = $value AND user_type = 'T'");  
        $resultSubscriber = mysqli_query($GLOBALS['con'],"SELECT * FROM userlogins WHERE YEAR(created_dt) = $value AND user_type = 'S'");  
        echo "{y: '$value', item1: ".mysqli_num_rows($resultAll).", item2: ".mysqli_num_rows($resultTemp).", item3: ".mysqli_num_rows($resultSubscriber)."},";
      }
     ?>
 
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2', 'item3'],
    labels: ['All User', 'Temp User', 'Subscribers'],
    lineColors: ["#9152af", "#c62500", "#00867b"],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#9152af", "#c62500", "#00867b"],
    gridLineColor: "#efefef",
    gridTextSize: 12
  });

  var line = new Morris.Line({
    element: 'sales-chart',
    resize: true,
    data: [
    <?php 
      $years = array();
      $currYear = date("Y");
      for ($x = 0; $x <= 4 ; $x++) {
        array_push($years, $currYear - $x);
      }
      // $years = array("2014", "2015", "2016", "2017"); 
      foreach ($years as $value) {
        $resultPayment = mysqli_query($GLOBALS['con'],"SELECT sum(amount) 'total' FROM payment_history WHERE YEAR(paymentdate) = $value AND txnstatus = 'SUCCESS'");  
        $row = mysqli_fetch_array($resultPayment);
        $total = (isset($row['total']) || $row['total'] != '') ? $row['total'] : 0;
        echo "{y: '$value', item1: '".$total."'},";
      }
     ?>
    ],
    xkey: 'y',
    ykeys: ['item1'],
    labels: ['Revenue'],
    lineColors: ['#efefef'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef"],
    gridLineColor: "#efefef",
    gridTextSize: 12,
    preUnits: 'Rs. '
  });

});


</script>
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