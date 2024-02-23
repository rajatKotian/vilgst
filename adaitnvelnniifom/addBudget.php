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
      <h1>Add Budget<small>it all starts here</small></h1>
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
         <h3 class="box-title">Add Budget</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div>            
        <div class="box-body">
          <form name="form1" class="form-horizontal" method="post" action="../addbudgetauth.php" enctype="multipart/form-data" onSubmit="return ValidateForm()">
            <div class="form-group">
              <label class="col-sm-3 control-label">Circular Date</label>     
                <?php 
                  $cir_date = '';

                  if(isset($_GET['cir_date']))
                  {           
                    $cir_date=$_GET['cir_date'];   
                  }

                  echo "<input type='text' class='form-control' name='txtCirDate' id='txtCirDate' placeholder='Circular Date' value='$cir_date' style='width: 20%; float: left;' />"
                ?>
              <span> &nbsp;(YYYY-MM-DD HH:MM:SS)</span>                    
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Circular No.</label> 
                <?php 
                  $cir_no = '';

                  if(isset($_GET['cir_no']))
                  {           
                    $cir_no=$_GET['cir_no'];   
                  }

                  echo "<input type='text' name='txtCirNo' id='txtCirNo' placeholder='Circular No.' class='form-control' value='$cir_no' style='width: 20%;'/>"
                ?>
            </div>
            <div class="form-group">
              <fieldset class="form-group" style="border:1px solid #3c8dbc; background: #fafafa; border-radius: 5px; margin:0px auto">
                <legend style="margin-left: 10px; font-size: 15px; width: 31%;border: none; color: #3c8dbc;">Want to duplicate this record in some other Category</legend>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Product Type</label>
                  <select class="form-control" id="product" name="product" style="width: 20%;" onchange="reload(this.form);">
                    <!--?php
                      $table = 'Product';
                      // sending query
                      $product=$_GET['product'];

                      if(strlen($product) > 0 and !is_numeric($product))
                      {
                        //check if $product is numeric data or not.
                        echo "Data Error";
                        //exit;
                      }
                      $result = mysqli_query($GLOBALS['con'],"SELECT prod_id,prod_name FROM product where active_flag = 'Y'");

                      if (!$result)
                      {    
                        die("Query to show fields from table failed");
                      } 

                      while($row = mysqli_fetch_array($result))
                      {
                        if($row['prod_id']==@$product)
                        {
                          echo "<option selected value='$row[prod_id]'>$row[prod_name]</option>"."<BR>";
                        }
                        else
                        {
                          echo "<option value='$row[prod_id]'>$row[prod_name]</option>";
                        }
                      }
                      mysqli_free_result($result);
                    ?-->
                  </select>      
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Sub Product</label> 
                  <select class="form-control" id="subproduct" name="subproduct" style="width: 20%;" onchange="reload(this.form);">
                    <option value="">Select Sub-Product</option>
                      <!--?php
                        $table = 'sub_product';
                        $product=$_GET['product'];
                        $subproduct=$_GET['sub_prod'];
                        // sending query

                        if(isset($product) and strlen($product) > 0)
                        {
                          $result=mysqli_query($GLOBALS['con'],"SELECT sub_prod_id,sub_prod_name FROM sub_product where prod_id = $product and active_flag = 'Y'");
                        }
                        else
                        {
                          $result=mysqli_query($GLOBALS['con'],"SELECT sub_prod_id,sub_prod_name FROM sub_product where active_flag = 'Y'"); 
                        }
                        if (!$result) 
                        {    
                          die("Query to show fields from table failed");
                        }
                        while($row = mysqli_fetch_array($result))
                        {
                          if($row['sub_prod_id']==@$subproduct)
                          {
                            echo "<option selected value='$row[sub_prod_id]'>$row[sub_prod_name]</option>"."<BR>";
                          }

                          else
                          {
                            echo "<option value='$row[sub_prod_id]'>$row[sub_prod_name]</option>";
                          } 
                        } 
                        mysqli_free_result($result);
                      ?-->
                  </select>
                </div>

                  <?php 
                    if(isset($_GET['sub_prod'])  && ($_GET['product']==4 || $_GET['product']==5) )
                    {
                      if($_GET['sub_prod']==21 || $_GET['sub_prod']==35) { ?>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Notification Type</label>
                        <select name="sub_subprod_id" class="form-control">
                          <option value="Tariff">Tariff</option>
                          <option value="Non-Tariff">Non-Tariff</option>
                          <?php if($_GET['product']==5) { ?>
                          <option value="Safeguards">Safeguards</option>
                          <option value="Anti Dumping Duty">Anti Dumping Duty</option>
                          <option value="Others">Others</option>
                          <?php  } ?>
                        </select>            
                      </div>
                      <?php 
                      }
                      else if($_GET['sub_prod']==22 || $_GET['sub_prod']==36) { ?>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Circular Type</label>
                        <select name="sub_subprod_id" class="form-control">
                          <option value="Circulars">Circulars</option>
                          <option value="Instructions">Instructions</option>
                        </select> 
                      </div>
                      <?php } 
                    }
                  ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Upload File</label>
                    <input name="upload" type="file" placeholder="Upload">                      
                </div>
              </fieldset>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Subject</label> 
                <textarea name="txtSub" id="txtSub" class="form-control" rows="5" placeholder="Subject" style="width: 50%;"></textarea>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Code</label> 
                <input type="text" name="txtCode" id="txtCode" placeholder="Code" class="form-control" multiline="true" style="width: 20%;">
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Upload Budget File</label>
                <input name="uploadBudget" type="file" placeholder="Upload">                      
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Upload TXT File (For Search)</label>         
                <input name="uploadTXT" type="file" placeholder="Upload TXT">                  
            </div>  
            <div class="box-footer">
                <button type="submit" id="Submit" class="btn btn-primary">Add Budget</button>                    
            </div>
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<?php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>