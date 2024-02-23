<?php 
  $pageType = 'viewGSTNotications';
  include('header.php'); 
  $pageHead = 'GST Notification';
  $addText =  '';  

?>
<style type="text/css">
  .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 0px 8px 2px;
  }

  .table > tbody > tr > td a { text-decoration: underline; }

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
          <div class="box-tools pull-right">
            <a href="addGSTNotiCSV.php">Add <?php echo "$pageHead"; ?></a>           
          </div>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container">
          
          <table id="dataResult" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px">No.</th>
                <th>Date</th>
                <th>Effective From</th>
                <th>Type</th>
                <th>Rate Type</th>
                <th>Chapter</th>
                <th>Linked Section</th>
                <th>Linked Rule</th>
                <th>Linked Notification</th>
                <th>Objective</th>
                <th>Industry</th>
                <th>Business Type</th>
                <th>Taxpayer Type</th>
              </tr>
            </thead>
<?php 
$result = mysqli_query($GLOBALS['con'],"SELECT * FROM casedata_gstnoticsv ORDER BY data_id DESC");
  while($row = mysqli_fetch_array($result)) {
             
    echo "<tbody>
              <tr>";
          echo "<td>";

            $rate_type = (strtolower($row['rate_type']) == 'rate') ? " - Rate" : '';

            
            $noti_number = preg_split("/\//", $row['noti_no']);
            $noti_no = "<a href=''>Notification No. ".$noti_number[0].''.$rate_type.'</a>';
            echo $noti_no;

          echo "</td>";
          echo "<td>".date('d-M-Y', strtotime($row['noti_date']))."</td>
                <td>".date('d-M-Y', strtotime($row['effective_date']))."</td>";
          echo "<td>".$row['gst_type']."</td>
                <td>".$row['rate_type']."</td>
                <td>".$row['chapter']."</td>";

          echo "<td>";
            $linked_section = $row['linked_section'];
            if($linked_section != '') {
              $linkedSecArray = explode(',', $linked_section);
              $count = 0;
              foreach($linkedSecArray as $section){
                $keys = array_keys($linkedSecArray);
                $keys = end($keys);
                echo "<a href=''>Section No. ".$section.'</a>';
                if($keys != $count) {
                  echo ",<br>";
                }
                $count++;
              }
            }  
          echo "</td>";

          echo "<td>";
            $linked_rule = $row['linked_rule_CGST'];
            if($linked_rule != '') {
              $linkedRuleArray = explode(',', $linked_rule);
              $count = 0;              
              foreach($linkedRuleArray as $Rule){
                $keys = array_keys($linkedRuleArray);
                $keys = end($keys);
                echo "<a href=''>Rule No. ".$Rule.'</a>';  
                if($keys != $count) {
                  echo ",<br>";
                }
                $count++;
              }
            }
          echo "</td>";

          echo "<td>";
            $linked_notification = $row['linked_notification'];
            if($linked_notification != '') {
              $linkedNotiArray = explode(',', $linked_notification);
              $count = 0;              
              foreach($linkedNotiArray as $Rule){
                $keys = array_keys($linkedNotiArray);
                $keys = end($keys);
                echo "<a href=''>Notication No. ".$Rule.'</a>'; 
                if($keys != $count) {
                  echo ",<br>";
                }
                $count++;
              }
            }
          echo "</td>";

          echo "<td>".$row['objective']."</td>
                <td>".$row['industry']."</td>
                <td>".$row['business_type']."</td>
                <td>".$row['taxpayer_type']."</td>
              </tr>
            </tbody>";
  } 
  mysqli_free_result($result);

?>
            

            <tfoot>
              <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Effective From</th>
                <th>Type</th>
                <th>Rate Type</th>
                <th>Chapter</th>
                <th>Linked Section</th>
                <th>Linked Rule</th>
                <th>Linked Notification</th>
                <th>Objective</th>
                <th>Industry</th>
                <th>Business Type</th>
                <th>Taxpayer Type</th>
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
        "paging":   false,
        "ordering": false,
        "info":     false,
        "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">' 
    });  
};

$(document).ready(function(){

  viewDataTableCustom();
 

 
}); 

</script>
