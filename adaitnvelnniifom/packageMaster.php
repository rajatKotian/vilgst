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
      <h1>Package Master<small>it all starts here</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">View Schedules</li>
      </ol>
    </section>

    <!--?php 
      $tbl_name="package_master";   
      $query="SELECT COUNT(*) as num FROM $tbl_name";
    ?-->

    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
         <h3 class="box-title">Package Master</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
          </div>
        </div>            
        <div class="box-body">            
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-6">
                <div class="dataTables_length" id="example1_length">
                  <label>Show
                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    </select> entries
                  </label>
                </div>
              </div>
              <div class="col-sm-6">
                <div id="example1_filter" class="dataTables_filter" style="text-align: right;">
                  <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="example1">
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending" style="width : 80px;">ID</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width : 70px;">Short Code</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width : 200px;">Package Name</th>  
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width : 80px;">Package Amount</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width : 80px;">Addition Amount <br/>(Per Email-ID)</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width : 70px;"></th>                        
                    </tr>
                  </thead>                     
                  <tbody>       
                    <tr role="row" class="odd">
                      <td class="sorting_1"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th rowspan="1" colspan="1">ID</th>
                      <th rowspan="1" colspan="1">Short Code</th>
                      <th rowspan="1" colspan="1">Package Name</th>  
                      <th rowspan="1" colspan="1">Package Amount</th>
                      <th rowspan="1" colspan="1">Addition Amount <br/>(Per Email-ID)</th>
                      <th rowspan="1" colspan="1"></th>                        
                    </tr>
                  </tfoot>

                  <!--?php     
                    $result = mysqli_query($GLOBALS['con'],"SELECT * FROM $tbl_name order by pid");
                     
                    if (!$result) 
                    {    
                      die("Query to show fields from table failed");
                    }   

                    $fields_num = mysqli_num_fields($result);

                    if(mysqli_num_rows($result) == 0)
                    {
                      echo '<tr><td colspan="10"><div class="notification error">Record not found</div></td></tr>';
                    }
                    
                    while($row = mysqli_fetch_array($result))
                    {
                    echo "<tr>";  
                      echo "<td>{$row['pid']}</td>";
                      echo "<td>{$row['pname']}</td>";
                      echo "<td>{$row['pdescription']}</td>";  
                      echo "<td style='text-align:right'>{$row['pamount']}</td>";  
                      echo "<td style='text-align:right'>{$row['addemailamount']}</td>";  
                      echo "<td><a href='editPackage.php?id={$row['pid']}' title='Edit Package Details' style='margin:0px auto; display:block'><img src='images/editIcon.png' /></a></td>";
                    echo "</tr>";
                    } 

                    mysqli_free_result($result);
                  ?-->  

                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5">
                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries
                </div>
              </div>
              <div class="col-sm-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="text-align: right;">
                  <ul class="pagination">
                    <li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li>
                    <li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li>
                    <li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li>
                    <li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li>
                    <li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li>
                    <li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li>
                    <li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li>
                    <li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li>
                  </ul>
                </div>                
              </div>
            </div>
          </div>  
        </div><!-- /.box-body -->
      </div>   
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<php include('copyright.php'); ?>

</div><!-- ./wrapper -->

<?php include('footer.php'); ?>