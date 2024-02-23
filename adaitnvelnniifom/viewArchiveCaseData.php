<?php
$dataType = $_GET['dataType'];
$pageType = 'viewArchiveCases' . $dataType;

include('header.php');
$addText = ' - Archive Cases';

$getDbRecord = getDbRecord('product', 'dbsuffix', $dataType);
$pageHead = $getDbRecord[0]['prod_name'];
$prod_id = $getDbRecord[0]['prod_id'];
?>
<style type="text/css">
  #custom_search_container {
    background: #FFF;
    left: 0;
    padding-top: 5px;
    position: absolute;
    width: 500px;
    z-index: 100;
    top: 0;
  }

  #custom_search_container label {
    font-weight: normal;
  }

  #custom_search_container .form-group {
    overflow: hidden;
    margin-bottom: 0
  }


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
      <input type="hidden" id="dataType" value="<?php echo $dataType; ?>" />
      <input type="hidden" id="pageType" value="<?php echo $pageType; ?>" />
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
        <div> <i class="icon fa fa-check"></i> Data (Case id #<strong></strong>) <span>updated</span> successfully !</div>
      </div>
      <div class="alert alert-error alert-dismissable alert-error-primary">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div> <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
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
                  <h3 class="box-title">Select Circular Date Range</h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                  <form class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="control-label">Start Date</label>
                        <input type="text" name="start_date" id="start_date" placeholder="Start Date" class="form-control" value="" />
                      </div>
                      <div class="col-md-4">
                        <label class="control-label">End Date</label>
                        <input type="text" name="end_date" id="end_date" placeholder="End Date" class="form-control" value="" />
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
        <div class="box-header" style="position: relative;">
          <div class="row">

            <div class="col-md-4">

              <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
            </div>
            <div class="col-md-4" style="position: relative;">

              <div id="custom_search_container">
                <div class="form-group">
                  <label for="party_radio" class="col-sm-5 control-label">
                    <input type='radio' class="form-control minimal" name='custom_search_radio' checked="checked" id="party_radio" value="party" /> Search by Party Name
                  </label>
                  <label for="general_radio" class="col-sm-5 control-label">
                    <input type='radio' class="form-control minimal" name='custom_search_radio' id="general_radio" value="general" /> General Search
                  </label>
                </div>
                <div class="form-group" id="custom_search_input_container">
                  <label>
                    <span>Party Name: </span>
                    <input autocomplete="on" class="form-control input-sm" id="party_name_input" placeholder="" type="text">
                  </label>
                  <button class="btn btn-block btn-primary pull-left">Search</button>
                </div>
              </div>
            </div>
            <div class="col-md-4">

              <div class="box-tools pull-right">
                <a href="addArchiveCaseData.php?dataType=<?php echo "$dataType"; ?>">Add <?php echo "$pageHead"; ?> Data</a>
              </div>
            </div>
          </div>

        </div><!-- /.box-header -->
        <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
          <div class="form-group main-filter-filter">
            <select id="sub_prod_select" class="form-control" name="sub_prod_select">
              <option value="0">All Sub Category</option>
              <?php
              $sub_prod_id = '';
              if (isset($_GET['sub_prod_id'])) {
                $sub_prod_id = $_GET['sub_prod_id'];
              }

              $result = mysqli_query($GLOBALS['con'],"SELECT * FROM sub_product where prod_id = '" . $prod_id . "' order by sub_prod_name");

              while ($row = mysqli_fetch_array($result)) {
                if ($row['sub_prod_id'] == @$sub_prod_id) {
                  echo "<option selected value='$row[sub_prod_id]'>$row[sub_prod_name]</option>" . "<BR>";
                } else {
                  echo "<option value='$row[sub_prod_id]'>$row[sub_prod_name]</option>";
                }
              }
              //mysqli_free_result($result);
              ?>
            </select>
          </div>

          <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="min-width: 10px;">ID</th>
                <th style="min-width: 70px;">Circular Date</th>
                <th>Circular No. Hidden</th>
                <th style="min-width: 80px;">Circular No.</th>
                <th>Party Name</th>
                <th>Subject</th>
                <th>Summary</th>
                <!--<th>File Data</th>-->
                <th>State</th>
                <th style="min-width: 10px;">Sub-Category Hidden</th>
                <th style="min-width: 25px;">Sub-Cat</th>
                <th style="min-width: 25px;">S/H Flag</th>
                <th style="min-width: 90px;">Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Circular Date</th>
                <th>Circular No. Hidden</th>
                <th>Circular No.</th>
                <th>Party Name</th>
                <th>Subject</th>
                <th>Summary</th>
                <!--<th>File Data</th>-->
                <th>State</th>
                <th style="min-width: 10px;">Sub-Category Hidden</th>
                <th>Sub-Cat</th>
                <th>S/H Flag</th>
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
    //alert("data="+$('#dataType').val()+'&'+whereQuery);

    var viewDataTable = $('#dataResult').dataTable({
      "bDestroy": true,
      "order": [
        [0, "desc"]
      ],
      "processing": true,
      "serverSide": true,
      "lengthMenu": [
        [25, 50, 100, 1000, -1],
        [25, 50, 100, 1000, "All"]
      ],
      "ajax": "response/viewArchiveCaseData.php?data=" + $('#dataType').val() + '&' + whereQuery,
      "dom": '<"row"<"col-md-4"><"col-md-4"f><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
      "columns": [{
          "data": "id"
        },
        {
          "data": "date"
        },
        {
          "data": "circular_no"
        },
        {
          "data": null,
          render: function(data, type, row) {
            return "<a  href='../showiframe?V1Zaa1VsQlJQVDA9=" + data.encrypt_id + "&datatable=" + $('#dataType').val() + "' target='_blank' >" + data.circular_no + "</a><button class='copy-file-link badge bg-navy'>Copy</button>";
          }
        },
        {
          "data": "party_name"
        },
        {
          "data": "search_subject"
        },
        {
          "data": "summary"
        },
        // { "data": "file_data" },
        {
          "data": "state"
        },
        {
          "data": "sub_prod"
        },
        {
          "data": null,
          render: function(data, type, row) {
            return data.sub_prod + '<em>' + data.sub_subprod + '</em>';
          }
        },
        {
          "data": "show_hide_flag"
        },
        {
          "data": null,
          render: function(data, type, row) {
            var isTmiRef = data.tmi_reference;
            var file_extn = data.file_path.replace(/^.*\./, ''),
              fileLink = (file_extn == 'htm' || file_extn == 'html') ? "#" : data.file_path,
              htmlClass = (file_extn == 'htm' || file_extn == 'html') ? "edit-html" : "open-pdf",
              linkTitle = (file_extn == 'htm' || file_extn == 'html') ? "Edit HTML" : "View PDF",
              linkIcon = (file_extn == 'htm' || file_extn == 'html') ? "code" : "pdf",
              setTarget = (file_extn == 'htm' || file_extn == 'html') ? "" : "target='_blank'";

            if (file_extn == '') {
              linkIcon = 'excel';
              linkTitle = 'File Not Uploaded';
              htmlClass = 'not-found';
            }
            if (isTmiRef != '') {
              htmlClass += ' EditHTML2';
            }

            return "<a href='" + fileLink + "' " + setTarget + " data-id='" + data.encrypt_id + "' data-table='casedata_<?php echo $dataType; ?>' data-primarykey='data_id' data-name='circular_no' data-title='<?php echo $pageHead; ?> Case Data'  data-toggle='tooltip' class='btn btn-warning " + htmlClass + "' title='" + linkTitle + "'><i class='fa fa-file-" + linkIcon + "-o'></i></a>  <a href='#' data-id='" + data.id + "' data-toggle='tooltip' class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i></a>     <a href='#' data-id='" + data.id + "' data-toggle='tooltip' class='btn btn-danger delete-data' title='Delete Data'><i class='fa fa-trash-o'></i></a>";
          }
        }
      ],
      "columnDefs": [{
          "targets": [1, 2, 3, 4, 5, 6, 7, 8],
          orderable: false
        },
        {
          "visible": false,
          "targets": [2, 7]
        }
      ],
      "drawCallback": function() {
        $('.read-more-subject').click(function() {
          $(this).parent().next().show();
          $(this).parent().hide();

        });
        $('.read-less-subject').click(function() {
          $(this).parent().prev().show();
          $(this).parent().hide();

        });
        $('[data-toggle="tooltip"]').tooltip();
        loadPopupModalUpdateDelete('archive', 'update', $('#dataType').val());
        loadPopupModalUpdateDelete('archive', 'delete', $('#dataType').val());
        initHtmlEditPage();
        copyLinkToClipboard();
      },
      "initComplete": function() {
        $('#dataresult-container').css('padding-top', '');
        loadPopupModalUpdateDelete('archive', 'update', $('#dataType').val());
        loadPopupModalUpdateDelete('archive', 'delete', $('#dataType').val());
        copyLinkToClipboard();
      }
    });
  };

  $(document).ready(function() {
    $("#custom_search_input_container").show();
    $("#party_name_input").val('');

    viewDataTableCustom();

    $('#sub_prod_select').on('change', function() {
      $("#start_date, #end_date, #party_name_input").val('');
      viewDataTableCustom('sub_prod_id=' + $('#sub_prod_select').val());
    });

    $('#daterange-btn-search').on('click', function(e) {
      e.preventDefault();
      var sub_prod_id = $('#sub_prod_select').val(),
        start_date = $('#start_date').val(),
        end_date = $('#end_date').val();

      if (sub_prod_id != '0') {
        viewDataTableCustom('sub_prod_id=' + sub_prod_id + '&start_date=' + start_date + "&end_date=" + end_date);
      } else {
        viewDataTableCustom('start_date=' + start_date + "&end_date=" + end_date);
      }
    });

    $('#clear-search').on('click', function() {
      var sub_prod_id = $('#sub_prod_select').val();

      if (sub_prod_id != '0') {
        viewDataTableCustom('sub_prod_id=' + sub_prod_id);
      } else {
        viewDataTableCustom();
      }
    });

    $('#custom_search_container button').on('click', function() {
      var sub_prod_select = $('#sub_prod_select').val(),
        searchKeywordPartyName = $('#party_name_input').val();
      if (sub_prod_select != '0') {
        viewDataTableCustom("sub_prod_id=" + sub_prod_select + "&party_name=" + searchKeywordPartyName);
      } else {
        viewDataTableCustom("party_name=" + searchKeywordPartyName);
      }
    });



    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });

    $('#custom_search_container .control-label input').on('ifChecked', function(event) {
      //console.log('p', $(this).val());
      if ($(this).val() == "party") {
        $("#custom_search_input_container").show();
        $("#party_name_input").val('');
      } else {
        $("#custom_search_input_container").hide();
        viewDataTableCustom();
        $("#sub_prod_select").val(0);
      }
    });

  });
</script>