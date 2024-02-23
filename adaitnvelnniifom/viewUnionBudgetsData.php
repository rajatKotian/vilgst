<?php 
  $dataType = '';
  $pageType = 'viewUnionBudgetsData';
  $pageHead = 'Union Budget ';
  $prod_id = '';
  if($dataType == 'vat') { $pageHead = 'VAT' ; $prod_id = '1' ; }
  else if($dataType == 'st') { $pageHead = 'Service Tax' ;  $prod_id = '2' ; }
  else if($dataType == 'ce') { $pageHead = 'Central Excise' ;  $prod_id = '4' ; }
  else if($dataType == 'cu') { $pageHead = 'Customs' ;  $prod_id = '5' ; }
  else if($dataType == 'dgft') { $pageHead = 'DGFT' ;  $prod_id = '6' ; }
  else if($dataType == 'gst') { $pageHead = 'Goods & Services Tax' ;  $prod_id = '3' ; }

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
      <input type="hidden" id="dataType" value="<?php echo "$prod_id"; ?>" />
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
      <div>  <i class="icon fa fa-check"></i> Data (Union Budget id #<strong></strong>) <span>updated</span> successfully !</div>
    </div>   
    <div class="alert alert-error alert-dismissable alert-error-primary">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
    </div>  
    <!-- Default box -->
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
         <h3 class="box-title">Date Range Filter</h3>
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
                      <h3 class="box-title">Select Budget Date Range</h3>
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
            <a href="addUnionBudgetsData.php">Add <?php echo "$pageHead"; ?></a>           
          </div>
        </div><!-- /.box-header -->
         <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
         <div class="form-group main-filter-filter">
            <select id="prod_select" class="form-control" name="prod_select">
              <option value="">All Sub Category</option>                        
              <?php
                $prod_id='';
                if(isset($_GET['prod_id'])) {
                  $prod_id=$_GET['prod_id'];
                }

                $result = mysqli_query($GLOBALS['con'],"SELECT * FROM product");

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
          <table id="dataResult" class="display table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th style="min-width: 30px;">Linked Case ID</th>
                <th style="min-width: 80px;">Circular Date</th>
                <th>Circular No. Hidden</th>
                <th style="min-width: 180px;">Circular No.</th>
                <th>Summary</th>
                <th style="min-width: 50px;">Category</th>
                <th>Sub-Category Hidden</th>
                <th style="min-width: 70px;">Sub-Category</th>
                <th style="min-width: 80px;">Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Linked Case ID</th>
                <th>Circular Date</th>
                <th>Circular No. Hidden</th>
                <th>Circular No.</th>
                <th>Summary</th>
                <th>Category</th>
                <th>Sub-Category Hidden</th>
                <th>Sub-Category</th>
                <th>Actions</th>
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
  console.log(whereQuery);
  var viewDataTable = $('#dataResult').dataTable({ 
    "bDestroy": true,
    "order": [[ 0, "desc" ]],
    "processing": true, 
    "serverSide": true, 
    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    "ajax": "response/viewUnionBudgetsData.php?data="+$('#dataType').val()+'&'+whereQuery,
    "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
    "columns": [
            { "data": "id" },
            { "data": "linked_case_id" },          
            { "data": "date" },
            { "data": "circular_no" },
            { "data": null, render: function ( data, type, row ) {
                return "<a href='../showiframe?V1Zaa1VsQlJQVDA9="+data.encrypt_id+"&page=unionBudget' target='_blank'>"+data.circular_no+"</a>";
                } 
            },          
            { "data": "summary" },
            { "data": "prod" },
            { "data": "sub_prod" },
            { "data": null, render: function ( data, type, row ) {
                return data.sub_prod+'<em>'+data.sub_subprod+'</em>';
                } 
            },
            { "data": null, render: function ( data, type, row ) {
              var file_extn = data.file_path.replace(/^.*\./, ''),
                    fileLink = (file_extn == 'htm' || file_extn == 'html') ? "#" : data.file_path,
                    htmlClass = (file_extn == 'htm' || file_extn == 'html') ? "edit-html" : "open-pdf",
                    linkTitle = (file_extn == 'htm' || file_extn == 'html') ? "Edit HTML" : "View PDF",
                    linkIcon = (file_extn == 'htm' || file_extn == 'html') ? "code" : "pdf",
                    setTarget = (file_extn == 'htm' || file_extn == 'html') ? "" : "target='_blank'" ;

                    if(file_extn == '') { 
                      linkIcon = 'excel';
                      linkTitle = 'File Not Uploaded';
                      htmlClass = 'not-found';
                    }


                return "<a href='"+fileLink+"' "+setTarget+" data-id='"+data.encrypt_id+"' data-table='budgets_union' data-primarykey='data_id' data-name='circular_no' data-title='Union Budget'  data-toggle='tooltip' class='btn btn-warning "+htmlClass+"' title='"+linkTitle+"'><i class='fa fa-file-"+linkIcon+"-o'></i></a>    <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";
                } 
            } 
      ],
      "columnDefs": [
        {
           "targets": [ 1, 2, 3, 4, 5, 6, 7, 8 ],
            orderable: false
          },
          { "visible": false, "targets": [3, 7] }
      ],
    "drawCallback" : function () {
      $('.read-more-subject').click(function (){
        $(this).parent().next().show();
        $(this).parent().hide();
        
      });
      $('.read-less-subject').click(function (){
        $(this).parent().prev().show();
        $(this).parent().hide();
        
      });
      $('[data-toggle="tooltip"]').tooltip();
      loadPopupModalUpdateDelete('unionBudget','update');
      loadPopupModalUpdateDelete('unionBudget','delete');
      initHtmlEditPage();  
    } ,
    "initComplete": function () {      
      $('#dataresult-container').css('padding-top','');
      loadPopupModalUpdateDelete('unionBudget','update');
      loadPopupModalUpdateDelete('unionBudget','delete');           
    }
  });
};

$(document).ready(function(){

  viewDataTableCustom();

  $('#prod_select').on('change', function() {
      $( "#start_date, #end_date" ).val('');
      viewDataTableCustom('prod_id='+$('#prod_select').val());
  });

  $('#daterange-btn-search').on('click', function(e) { 
    e.preventDefault();
    var sub_prod_id = $('#sub_prod_select').val(),
        start_date = $('#start_date').val(),
        end_date = $('#end_date').val();

    if(sub_prod_id != '0') {
      viewDataTableCustom('sub_prod_id='+sub_prod_id+'&start_date='+start_date+"&end_date="+end_date);
    } else {
      viewDataTableCustom('start_date='+start_date+"&end_date="+end_date);
    }
  });

  $('#clear-search').on('click', function() { 
    var sub_prod_id = $('#sub_prod_select').val();

    if(sub_prod_id != '0') {
      viewDataTableCustom('sub_prod_id='+sub_prod_id);
    } else {
      viewDataTableCustom();
    }
  });

 
});
 
 
</script>