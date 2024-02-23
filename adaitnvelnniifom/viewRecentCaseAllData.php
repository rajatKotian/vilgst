<?php 
  $dataType = '';
  $pageType = 'viewRecentCasesAll';
  $pageHead = '';
  $prod_id = '';
 
  include('header.php'); 
  $addText = 'All Recent Cases';
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
      <h1><?php echo "$pageHead $addText"; ?> <small>Data related to <?php echo "$pageHead $addText"; ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Data (Case id #<strong></strong>) <span>updated</span> successfully !</div>
    </div>   
    <div class="alert alert-error alert-dismissable alert-error-primary">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
    </div>  
    <!-- Default box -->
      <div class="box box-danger collapsed-box">
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
                      <h3 class="box-title">Select Circular Date Range</h3>
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
            <a href="viewArchiveCaseAllData.php">View All Archive Cases</a>           
          </div>          
        </div><!-- /.box-header -->
         <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
         <div class="form-group main-filter-filter">
              <?php echo getProdDropdown(''); ?>
          </div>
          <table id="dataResult" class="display table table-bordered table-hover table-maroon" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">ID</th>
                <th style="min-width: 70px;">Circular Date</th>
                <th>Circular No. Hidden</th>
                <th style="min-width: 80px;">Circular No.</th>
                <th>Summary</th>
                <th  style="min-width: 100px;">State</th>
                <th style="min-width: 25px;">Cat</th>
                <th>Sub-Category Hidden</th>
                <th style="min-width: 25px;">Sub-Cat</th>
                <th style="min-width: 90px;">Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Circular Date</th>
                <th>Circular No. Hidden</th>
                <th>Circular No.</th>
                <th>Summary</th>
                <th>State</th>
                <th>Cat</th>
                <th>Sub-Category Hidden</th>
                <th>Sub-Cat</th>
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
  var viewDataTable = $('#dataResult').dataTable({ 
    "bDestroy": true,
    "order": [[ 0, "desc" ]],
    "processing": true, 
    "serverSide": true, 
    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    "ajax": "response/viewRecentCaseAllData.php?data="+$('#dataType').val()+'&'+whereQuery,
    "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
    "columns": [
            { "data": "id" },
            { "data": "date" },
            { "data": "circular_no" },
            { "data": null, render: function ( data, type, row ) {
                return "<a  href='../showiframe?V1Zaa1VsQlJQVDA9="+data.encrypt_id+"&page=recent' target='_blank' >"+data.circular_no+"</a><button class='copy-file-link badge bg-navy'>Copy</button>";
                } 
            },          
            { "data": "summary" },
            { "data": "state" },
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


                return "<a href='"+fileLink+"' "+setTarget+" data-id='"+data.encrypt_id+"' data-table='recent_data' data-primarykey='data_id' data-name='circular_no' data-title='Recent Data'  data-toggle='tooltip' class='btn btn-warning "+htmlClass+"' title='"+linkTitle+"'><i class='fa fa-file-"+linkIcon+"-o'></i></a>  <a href='#' data-id='"+data.id+"' data-prodid='"+data.prodid+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='"+data.id+"' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";
                } 
            } 
      ],
      "columnDefs": [
        {
           "targets": [ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
            orderable: false
          },
          { "visible": false, "targets": [2, 7] }
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
      loadPopupModalUpdateDeleteAll('recent','update');
      loadPopupModalUpdateDeleteAll('recent','delete');
      initHtmlEditPage();
      copyLinkToClipboard();        
    } ,
    "initComplete": function () {      
      $('#dataresult-container').css('padding-top','');
      loadPopupModalUpdateDeleteAll('recent','update');
      loadPopupModalUpdateDeleteAll('recent','delete');           
      copyLinkToClipboard();        
    }
  });
};

$(document).ready(function(){

  viewDataTableCustom();

  $('#prod_id').on('change', function() {
      $( "#start_date, #end_date" ).val('');
      viewDataTableCustom('prod_id='+$('#prod_id').val());
  });

  $('#daterange-btn-search').on('click', function(e) { 
    e.preventDefault();
    var sub_prod_id = $('#prod_id').val(),
        start_date = $('#start_date').val(),
        end_date = $('#end_date').val();

    if(prod_id != '') {
      viewDataTableCustom('prod_id='+prod_id+'&start_date='+start_date+"&end_date="+end_date);
    } else {
      viewDataTableCustom('start_date='+start_date+"&end_date="+end_date);
    }
  });

  $('#clear-search').on('click', function() { 
    var prod_id = $('#prod_id').val();

    if(prod_id != '') {
      viewDataTableCustom('prod_id='+prod_id);
    } else {
      viewDataTableCustom();
    }
  });

 
});

 
var loadPopupModalUpdateDeleteAll = function(file, action) {

  var $modal = $('#load-popup-modal'),
      alertSuccess = $('.alert-success'),
      alertError = $('.alert-error'),
      alertErrorModal = $('.alert-error-modal'),
      alertErrorPrimary = $('.alert-error-primary');


 
  $('.'+action+'-data').on('click', function(e){
      e.preventDefault();
      var dataType = $(this).data('prodid');

      if(dataType != null) {
        dataType = 'data='+dataType;
      }

      $modal.load('modals/'+action+'/'+file+'.php?'+'data='+$(this).data('prodid'),{'id': $(this).data('id') },

    function(){
      $modal.modal('show');

      $('#'+action+'-form').on("submit", function(event) {
        event.stopPropagation(); 
        event.preventDefault();

        $.ajax({
          url: 'modals/'+action+'/'+file+'.php?'+action+'=' + $('#'+action+'-id').val()+'&'+dataType,
          type: 'POST',
          data: new FormData(this),
          cache: false,
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function(data, textStatus, jqXHR) {
              
            if($.trim(data) == 'success') {
              $modal.modal('hide');
              alertSuccess.show().find('strong').html($('#'+action+'-id').val());
              alertSuccess.show().find('span').html(''+action+'d');
              window.alert('Data id #'+$('#'+action+'-id').val()+ ' ' + action+'d successfully !');
              setTimeout(function(){ alertSuccess.fadeOut(800); }, 2000);            
              viewDataTableCustom();
            } else if($.trim(data) == 'file_exists') {
              alertErrorModal.show().find('span').html('The file is already exists in the given path.');
              window.alert('The file is already exists in the given path.');
              $('#file_path').addClass('error');          
            } else if($.trim(data) == 'fileuploaderror') {
              alertErrorModal.show().find('span').html('There is an error in uploading the file, Please Refresh page and try again.');
              window.alert('There is an error in uploading the file, Please Refresh page and try again.');
              $('#file_path').addClass('error');          
            } else if($.trim(data) == 'securityerror') {
              alertErrorModal.show().find('span').html('You have entered wrong security. Please enter correct code.');
              window.alert('You have entered wrong security. Please enter correct code.');
              $('#txtCode').addClass('error');        
            } 
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alertErrorPrimary.show().find('span').html(action);
              setTimeout(function(){ alertErrorPrimary.fadeOut(800);  }, 2000);
          }
        });


      });
    });
  });
}; 
</script>
