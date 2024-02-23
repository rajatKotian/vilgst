<?php 
  $dataType = '';
  $pageType = 'viewArchiveCasesAll';
  $pageHead = '';

  include('header.php'); 
  $addText = 'All Archive Cases';
?>
<style type="text/css">
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
      <input type="hidden" id="dataType" value="<?php echo "$dataType"; ?>" />
      <input type="hidden" id="pageType" value="<?php echo "$pageType"; ?>" />
      <h1><?php echo "$pageHead $addText"; ?> <small>Data related to <?php echo "$pageHead $addText"; ?></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"><?php echo "$pageHead $addText"; ?></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
    

      <div class="box">
        <div class="box-header" style="position: relative;" >
          <div class="row">

      <div class="col-md-4">

        <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
      </div>
      <div class="col-md-4" style="position: relative;">

            <!-- <div id="custom_search_container">
              <div class="form-group">
                <label for="party_radio" class="col-sm-5 control-label">
                  <input type='radio' class="form-control minimal" name='custom_search_radio' id="party_radio" value="party" /> Search by Party Name 
                </label>
                <label for="general_radio" class="col-sm-5 control-label">
                  <input type='radio' class="form-control minimal" name='custom_search_radio' id="general_radio" checked="checked" value="general" /> General Search 
                </label>
              </div>
              <div class="form-group" id="custom_search_input_container">
                  <label>
                    <span>Party Name: </span>
                    <input autocomplete="on" class="form-control input-sm" id="party_name_input" placeholder="" type="text">
                  </label>
                <button class="btn btn-block btn-primary pull-left">Search</button>
              </div>
            </div> -->
    </div>
    <div class="col-md-4">

          <div class="box-tools pull-right">
            <a href="addproduct.php?dataType=Product">Add Product</a>           
          </div>
    </div>
  </div>
        </div><!-- /.box-header -->
         <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
          <!-- <div class="form-group main-filter-filter">
            <?php echo getProdDropdown(''); ?>
          </div>  -->         
          <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">ID</th>
                <th style="min-width: 70px;">Product Name</th>
                <th style="min-width: 80px;">Product Suffix</th>
               <!--  <th>Summary</th>
                <th  style="min-width: 100px;">State</th>
                <th style="min-width: 25px;">Cat</th>
                <th>Sub-Category Hidden</th>
                <th style="min-width: 25px;">Sub-Cat</th> -->
                <th style="min-width: 90px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $prod_query=mysqli_query($GLOBALS['con'],"SELECT * FROM `product`");
                $count=1;
                while($prod_data=mysqli_fetch_array($prod_query))
                {
              ?>
                <tr>
                  <td><?php echo $count++;?></td>
                  <td><?php echo $prod_data['prod_name'];?></td>
                  <td><?php echo $prod_data['dbsuffix'];?></td>
                  <td><a href="#" data-id="<?php echo $prod_data['prod_id'];?>" data-table="product" data-toggle="tooltip" class="btn btn-success update-data" title="" data-original-title="Edit Data"><i class="fa fa-edit"></i></a>
                    <a href="#" data-id="<?php echo $prod_data['prod_id'];?>" data-table="product" data-toggle="tooltip" class="btn btn-danger delete-data" title="" data-original-title="Delete Data"><i class="fa fa-trash-o"></i></a></td>
                </tr>
              <?php
                }
              ?>  
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product Suffix</th>
                <!-- <th>Summary</th>
                <th>State</th>
                <th>Cat</th>
                <th>Sub-Category Hidden</th>
                <th>Sub-Cat</th> -->
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

// var viewDataTableCustom = function(whereQuery) {

//   var viewDataTable = $('#dataResult').dataTable({ 
//     "bDestroy": true,
//     "order": [[ 0, "desc" ]],
//     "processing": true, 
//     "serverSide": true, 
//     "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
//     "ajax": "response/viewArchiveCaseAllData.php?"+whereQuery,
//     "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
//     "columns": [
//             { "data": "id" },
//             { "data": "date" },
//             { "data": "circular_no" },
//             { "data": null, render: function ( data, type, row ) {
//                 return "<a  href='../showiframe?V1Zaa1VsQlJQVDA9="+data.encrypt_id+"&datatable="+data.prodtype+"' target='_blank' >"+data.circular_no+"</a><button class='copy-file-link badge bg-navy'>Copy</button>";
//                 } 
//             },          
//             { "data": "summary" },
//             { "data": "state" },
//             { "data": "prod" },
//             { "data": "sub_prod" },
//             { "data": null, render: function ( data, type, row ) {
//                 return data.sub_prod+'<em>'+data.sub_subprod+'</em>';
//                 } 
//             },
//             { "data": null, render: function ( data, type, row ) {
//               var file_extn = data.file_path.replace(/^.*\./, ''),
//                     fileLink = (file_extn == 'htm' || file_extn == 'html') ? "#" : data.file_path,
//                     htmlClass = (file_extn == 'htm' || file_extn == 'html') ? "edit-html" : "open-pdf",
//                     linkTitle = (file_extn == 'htm' || file_extn == 'html') ? "Edit HTML" : "View PDF",
//                     linkIcon = (file_extn == 'htm' || file_extn == 'html') ? "code" : "pdf",
//                     setTarget = (file_extn == 'htm' || file_extn == 'html') ? "" : "target='_blank'" ;

//                     if(file_extn == '') { 
//                       linkIcon = 'excel';
//                       linkTitle = 'File Not Uploaded';
//                       htmlClass = 'not-found';
//                     }


//                 return "<a href='"+fileLink+"' "+setTarget+" data-id='"+data.encrypt_id+"' data-table='casedata_"+data.prodtype+"' data-primarykey='data_id' data-name='circular_no' data-title='"+data.prodtitle+" Case Data'  data-toggle='tooltip' class='btn btn-warning "+htmlClass+"' title='"+linkTitle+"'><i class='fa fa-file-"+linkIcon+"-o'></i></a>  <a href='#' data-id='"+data.id+"' data-table='"+data.prodtype+"' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='"+data.id+"' data-table='"+data.prodtype+"' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";
//                 } 
//             } 
//       ],
//       "columnDefs": [
//         {
//            "targets": [ 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
//             orderable: false
//           },
//           { "visible": false, "targets": [2, 7] }
//       ],
//     "drawCallback" : function () {
//       $('.read-more-subject').click(function (){
//         $(this).parent().next().show();
//         $(this).parent().hide();
        
//       });
//       $('.read-less-subject').click(function (){
//         $(this).parent().prev().show();
//         $(this).parent().hide();
        
//       });
//       $('[data-toggle="tooltip"]').tooltip();
//       loadPopupModalUpdateDeleteAll('archive','update');
//       loadPopupModalUpdateDeleteAll('archive','delete');
//       initHtmlEditPage();
//       copyLinkToClipboard();        
//     } ,
//     "initComplete": function () {      
//       $('#dataresult-container').css('padding-top','');
//       loadPopupModalUpdateDeleteAll('archive','update');
//       loadPopupModalUpdateDeleteAll('archive','delete');           
//       copyLinkToClipboard();        
//     }
//   });
// };
  $(".update-data").click(function(){
    //$('[data-toggle="tooltip"]').tooltip();
      loadPopupModalUpdateDeleteAll('product','update');
      //loadPopupModalUpdateDeleteAll('product','delete');        
    });
    $(".delete-data").click(function(){
    //$('[data-toggle="tooltip"]').tooltip();
      //loadPopupModalUpdateDeleteAll('product','update');
      loadPopupModalUpdateDeleteAll('product','delete');        
    }); 
$(document).ready(function(){

  viewDataTableCustom();

  $('#prod_id').on('change', function() {
      $( "#start_date, #end_date, #party_name_input" ).val('');
      viewDataTableCustom('prod_id='+$('#prod_id').val());
  });

  $('#daterange-btn-search').on('click', function(e) { 
    e.preventDefault();
    var prod_id = $('#prod_id').val(),
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

  $('#custom_search_container button').on('click', function() {
      var prod_id = $('#prod_id').val(),
          searchKeywordPartyName = $('#party_name_input').val();
      if(prod_id != '') {
        viewDataTableCustom("prod_id="+prod_id+"&cir_subject="+searchKeywordPartyName);
      } else {
        viewDataTableCustom("cir_subject="+searchKeywordPartyName);
      }
  });



  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
  });

  $('#custom_search_container .control-label input').on('ifChecked',  function(event){
    //console.log('p', $(this).val());
    if( $(this).val() == "party" ){
      $("#custom_search_input_container").show();
      $("#party_name_input").val('');
    } else {
      $("#custom_search_input_container").hide();
      viewDataTableCustom(); 
      $("#prod_id").val('');
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

      var dataType = $(this).data('table');
      alert('modals/'+action+'/'+file+'.php?'+'data='+$(this).data('table'),{'id': $(this).data('id')});

      if(dataType != null) {
        dataType = 'data='+dataType;
      }


      $modal.load('modals/'+action+'/'+file+'.php?'+'data='+$(this).data('table'),{'id': $(this).data('id') },

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
