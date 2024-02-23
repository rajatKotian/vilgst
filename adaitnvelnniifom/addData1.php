<?php 
$page='';
$page = 'addRecent';
include('header.php') ?>
<script language="javascript">

function reload(form){
	var val=form.product.options[form.product.options.selectedIndex].value; 
	var state=form.state.options[form.state.options.selectedIndex].value; 
	var sub_prod=form.subproduct.options[form.subproduct.options.selectedIndex].value; 
	var cir_date=form.txtCirDate.value; 
	var cir_no=form.txtCirNo.value;
	cir_no = cir_no.replace("&","%26");
	self.location='addData.php?product=' + val + '&sub_prod=' + sub_prod + '&state=' + state + '&cir_date=' + cir_date + '&cir_no=' + cir_no;
}
function ValidateForm(){	


if (document.form1.txtCirDate.value == '')
{
alert("Please Enter Circular Date")
document.form1.txtCirDate.focus()
return false
}

if (document.form1.txtCirNo.value == '')
{
alert("Please Enter Circular No.")
document.form1.txtCirNo.focus()
return false
}

if (document.form1.product.value == '')
{
alert("Please Select Product Type")
document.form1.product.focus()
return false
}


if (document.form1.subproduct.value == '')
{
alert("Please Select Sub Product Type")
document.form1.subproduct.focus()
return false
}

if (document.form1.txtSub.value == '')
{
alert("Please Enter Subject")
document.form1.txtSub.focus()
return false
}
if (document.form1.txtCode.value == '')
{
alert("Please Enter Secure Code")
document.form1.txtCode.focus()
return false
}
if (document.form1.upload.value == '')
{
alert("Please Select File")
document.form1.upload.focus()
return false
}
/*
if (document.form1.uploadTXT.value == '')
{
alert("Please Select txt File")
document.form1.uploadTXT.focus()
return false
}
*/
return true
}

</script>
<link rel="stylesheet" href="css/jquery.datetimepicker.css">
<script src="scripts/jquery-1.10.2.js"></script>
<script src="scripts/jquery.datetimepicker.js"></script>
 <script>
$(function() {
	$( "#txtCirDate" ).datetimepicker({
	   format: 'Y-m-d H:i:s',
	   mask:'9999-19-39'
	});
	
});
</script>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Add Archive Cases</h3>
	</div><!-- /.box-header -->
	 <!-- form start -->
	<form role="form" method="post" action="../adddataauth.php" enctype="multipart/form-data"  onSubmit="return ValidateForm()">
		<div class="box-body">
			<div class="form-group">
				<label class="col-sm-3 control-label">Select State</label> 
				<select id="state" name="state" class="form-control" style="width: 25%;">
					<option value="0">Select State</option> 
					<?php

						$table = 'state_master';
						// sending query
						$state=$_GET['state'];
						$result = mysqli_query($GLOBALS['con'],"SELECT state_id,state_name FROM state_master");

						if (!$result) 
						{ 
							die("Query to show fields from table failed");
						}

						while($row = mysqli_fetch_array($result))
						{
							//echo "<option value={$row['state_id']}>{$row['state_name']}</option>";

							if($row['state_id']==@$state)
							{
								echo "<option selected value='$row[state_id]'>$row[state_name]</option>"."<BR>";
							}

							else
							{
								echo "<option value='$row[state_id]'>$row[state_name]</option>";
							}
						}	
						mysqli_free_result($result);
					?>
				</select>
        	</div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Circular Date</label>    	
                    <?php 
						$cir_date = '';

						if(isset($_GET['cir_date']))
						{						
							$cir_date=$_GET['cir_date'];   
						}

					echo "<input type='text' class='form-control' name='txtCirDate' id='txtCirDate' placeholder='Circular Date' value='$cir_date' style='width: 20%' />"
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
                <label class="col-sm-3 control-label">Product Type</label>
                <select class="form-control" id="product" name="product" style="width: 20%;" onchange="reload(this.form);">
            	    <?php
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
					?>
				</select>      
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Sub Product</label> 
				<select class="form-control" id="subproduct" name="subproduct" style="width: 20%;" onchange="reload(this.form);">
					<option value="">Select Sub-Product</option>
					<?php
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
					?>
				</select>
        	</div>

        <?php 
		if(isset($_GET['sub_prod'])  && ($_GET['product']==4 || $_GET['product']==5) ){
		if($_GET['sub_prod']==21 || $_GET['sub_prod']==35) { ?>
        <tr>
        	<th>
            	<label class="col-sm-3 control-label">Notification Type</label>
            </th>
            <td>
	            <select name="sub_subprod_id">
	            	<option value="Tariff">Tariff</option>
	            	<option value="Non-Tariff">Non-Tariff</option>
	            	<?php if($_GET['product']==5) { ?>
            		<option value="Safeguards">Safeguards</option>
            		<option value="Anti Dumping Duty">Anti Dumping Duty</option>
            		<option value="Others">Others</option>
            		<?php  } ?>
	            </select>            
            </td>
        </tr>
		<?php 
		}
		else if($_GET['sub_prod']==22 || $_GET['sub_prod']==36) { ?>
        <tr>
        	<th>
            	<label class="col-sm-3 control-label">Circular Type</label>
            </th>
            <td>
            	<select name="sub_subprod_id">
	            	<option value="Circulars">Circulars</option>
	            	<option value="Instructions">Instructions</option>
	            </select> 

            </td>
        </tr>
		<?php } 
		}
		?>

			<div class="form-group">
				<label class="col-sm-3 control-label">Subject</label> 
				<textarea name="txtSub" id="txtSub" class="form-control" rows="5" placeholder="Subject" style="width: 50%;"></textarea>
			</div>
			<div class="form-group">
      	    	<label class="col-sm-3 control-label">Code</label> 
        		<input type="text" name="txtCode" id="txtCode" placeholder="Code" class="form-control" multiline="true" style="width: 20%;">
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Upload File</label>
                <input name="upload" type="file" placeholder="Upload">                      
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Upload TXT File (For Search)</label>         
	            <input name="uploadTXT" type="file" placeholder="Upload TXT">                  
            </div>  
        </div><!-- /.box-body -->
        <div class="box-footer">
       		<button type="submit" id="Submit" class="btn btn-primary">Add Archive Case</button>                    
    	</div>
	</form>
</div>
</div>
<?php include('footer.php') ?>

