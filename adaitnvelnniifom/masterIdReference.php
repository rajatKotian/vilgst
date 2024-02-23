<?php 
  $pageType = 'addMultipleCaseData';
  $pageHead = 'Master IDs reference';
  include('header.php'); 
  $addText = ' ';
?>
 
<div class="wrapper">

<?php include('titlebar.php'); ?>

<?php include('sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <input type="hidden" id="dataType" value="<?php echo "$pageHead"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small>Get Product IDs for Master Tables</small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content row">
    <!-- Default box -->
    <div class="col-sm-6">
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Product Master Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
          <table id="" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Product ID</th>
                <th style="min-width: 400px;">Product Name</th>
              </tr>
            </thead>  
            <tbody>      
          <?php  
        
            $result = mysqli_query($GLOBALS['con'],"SELECT prod_id,prod_name FROM product ORDER BY prod_id ");
            if($result === FALSE) { 
                die(mysql_error());  
            }
            while($row = mysqli_fetch_array($result)) {
              echo "<tr>
                      <td align='center'>".$row['prod_id']."</td>
                      <td>".$row['prod_name']."</td>
                    </tr>";    
            }
           
          ?>  
            </tbody>      
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">State Master Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
          <table id="" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>State ID</th>
                <th style="min-width: 400px;">State Name</th>
              </tr>
            </thead>  
            <tbody>      
          <?php  
        
            $result = mysqli_query($GLOBALS['con'],"SELECT state_id,state_name FROM state_master ORDER BY state_id ");
            if($result === FALSE) { 
                die(mysql_error());  
            }
            while($row = mysqli_fetch_array($result)) {
              echo "<tr>
                      <td align='center'>".$row['state_id']."</td>
                      <td>".$row['state_name']."</td>
                    </tr>";    
            }
           
          ?>  
            </tbody>      
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <div class="col-sm-6">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Sub-Product Master Data</h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" >
          <table id="" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Sub Product ID</th>
                <th style="min-width: 200px;">Sub Product Name</th>
                <th style="text-align: center">Main Product</th>
              </tr>
            </thead>  
            <tbody>      
          <?php  
        
            $result = mysqli_query($GLOBALS['con'],"SELECT p.prod_id 'prod_id', p.prod_name 'prod_name', sp.sub_prod_id 'sub_prod_id', sp.sub_prod_name 'sub_prod_name'  FROM sub_product sp, product p WHERE sp.prod_id = p.prod_id  ORDER BY sp.prod_id, sp.sub_prod_name ");
            if($result === FALSE) { 
                die(mysql_error());  
            }
            while($row = mysqli_fetch_array($result)) {

              if($row['prod_id'] == '1') { $rowColor = '#e3b9b9'; $textColor = '#600303'; }
              else if($row['prod_id'] == '2') { $rowColor = '#b9bde5'; $textColor = '#0b1678'; }
              else if($row['prod_id'] == '3') { $rowColor = '#efacee'; $textColor = '#7c037b'; }
              else if($row['prod_id'] == '4') { $rowColor = '#9cd7ba'; $textColor = '#026433'; }
              else if($row['prod_id'] == '5') { $rowColor = '#e4dfb5'; $textColor = '#655b04'; }
              else if($row['prod_id'] == '6') { $rowColor = '#c9a3e3'; $textColor = '#330154'; }

              echo "<tr style='background: $rowColor; color: $textColor'>
                      <td align='center'>".$row['sub_prod_id']."</td>
                      <td>".$row['sub_prod_name']."</td>
                      <td align='center'>".$row['prod_name']."</td>
                    </tr>";    
            }
           
          ?>  
            </tbody>      
          </table> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
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
 


