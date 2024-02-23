<?php 
  $page = 'index';
  include('header.php'); 
?>

<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Recent Cases<small>it all starts here</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title">Recent Cases</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div>            
        <div class="box-body">
          <form name="form1" class="col-sm-3" method="post"  enctype="multipart/form-data">
            <div class="form-group">
              <label>Main Product Type</label>
              <select id=prod_id style="width:188px;" class="form-control" name=prod_id onchange="reload(this.form,'prod_id');">
                <option value="ALL">ALL TYPES</option>                        
                <?php
                  $prod_id='';
                  if(isset($_GET['prod_id']))
                  {
                    $prod_id=$_GET['prod_id'];
                  }

                  $result = mysqli_query($GLOBALS['con'],"SELECT * FROM product where prod_id != '' order by prod_id");

                  while($row = mysqli_fetch_array($result))
                  {
                    if($row['prod_id']==@$prod_id)
                    {
                     echo "<option selected value='$row[prod_id]'>$row[prod_name]</option>"."<BR>";
                    }
                    else
                    {
                     echo "<option value='$row[prod_id]'>$row[prod_name]</option>";
                    }
                  }
                //mysqli_free_result($result);
                ?>
              </select>
            </div>
          </form>
          <form name="form2" class="col-sm-3" method="post"  enctype="multipart/form-data">
            <div class="form-group">
              <label style="float: left; width: 100%;">Circular No.</label>  
              <input type="text" id="circularNo" name="circularNo" placeholder="Enter Circular No." class="form-control" style="float: left; width: 70%; margin-right: 2%;" 
                  <?php 
                    if(isset($_GET['circularNo']))
                    {
                      echo "value = '".$_GET['circularNo']."'";
                    }
                    ?>
              />
              <button type="submit" name="circularNoBtn" id="circularNoBtn" class="btn btn-primary" style="float: left;" onclick="reload(this.form,'circularNo');">Search</button>              
            </div>  
          </form>
          <form name="form3"  class="col-sm-5" method="post"  enctype="multipart/form-data">
            <div class="form-group" style="float: left; margin-right: 5%;">
              <label>From Date</label>
              <input type="text" id="fromDate" name="fromDate" placeholder="From Date" class="form-control"  />
            </div>  
            <div class="form-group" style="float: left; width: 50%">
              <label style="float: left; width: 100%;">To Date</label>
              <input type="text" id="toDate" name="toDate" placeholder="To Date" class="form-control" style="float: left; width: 65%;    margin-right: 2%;" /> 
              <button type="submit" name="dateSearch" id="dateSearch" class="btn btn-primary" onclick="reload(this.form,'dateSelect');" style="float: left;">Search</button>            
            </div>
          </form>          
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>