<?php
$dataType = '';
$pageType = 'ListMappingCaseNotifications';
$pageHead = '';

include('header.php');
$addText = 'Mapping Case Notifications';

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
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div>  <i class="icon fa fa-check"></i> Data (Case id #<strong></strong>) <span>updated</span> successfully !</div>
            </div>   
            <div class="alert alert-error alert-dismissable alert-error-primary">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <div>  <i class="icon fa fa-check"></i> Unable to <span>update</span> data, please try again later. </div>
            </div>  
            <!-- Default box -->
            <div class="box">
                <div class="box-header" style="position: relative;" >
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="box-title"><?php echo "$pageHead"; ?> Data</h3>
                        </div>
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <div class="box-tools pull-right" style="margin-left:10px;">
                                <a href="add_mapping_case_notifications.php">Add Mapping Case Notifications</a>     
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
                    <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Case ID</th>
                                <th>Case Type</th>
                                <th>Notification ID</th>
                                <th>Notification Type</th>
                                <th class="no-sort">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $mapping_case_notifications = MappingCaseNotificationlist();
                            //getting list of all Mapping
                            if (count($mapping_case_notifications) > 0) {
                                foreach ($mapping_case_notifications as $notifications) {
                                    ?>
                                    <tr>
                                        <td><p><?php echo $notifications['id']; ?></p></td>
                                        <td><p><?php echo $notifications['case_id']; ?></p></td>
                                        <td><p><?php echo $notifications['case_type']; ?></p></td>
                                        <td><p><?php echo $notifications['notification_id']; ?></p></td>
                                        <td><p><?php echo $notifications['notification_type']; ?></p></td>
                                        <td>
                                            <p>
                                                <a href='edit_mapping_case_notifications.php?id=<?php echo $notifications['id']; ?>' data-id='' data-table='' data-toggle='tooltip' 
                                                   class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i>
                                                </a>  
                                                <a href='#' data-id='<?php echo $notifications['id']; ?>' data-table='mapping' data-toggle='tooltip' class='btn btn-danger delete-data' 
                                                   title='Delete Data'><i class='fa fa-trash-o'></i>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table> 
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include('copyright.php'); ?>
</div><!-- ./wrapper -->

<?php include('footer.php'); ?>


<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
//        viewDataTableCustom();
        $('#dataResult').dataTable({
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            "dom": '<"row"<"col-md-4"f><"col-md-4"><"col-md-4"i>>rt<"row"<"col-md-6"l><"col-md-6"p>><"clear">',
            "drawCallback": function() {
                $('[data-toggle="tooltip"]').tooltip();
                loadPopupModalDeleteAll('mapping_case_notifications', 'delete');
            },
            "initComplete": function() {
                loadPopupModalDeleteAll('mapping_case_notifications', 'delete');
            }
        });
    });

    var loadPopupModalDeleteAll = function(file, action) {

        var $modal = $('#load-popup-modal'),
                alertSuccess = $('.alert-success'),
                alertError = $('.alert-error'),
                alertErrorModal = $('.alert-error-modal'),
                alertErrorPrimary = $('.alert-error-primary');


        $('.' + action + '-data').on('click', function(e) {
            e.preventDefault();

            var dataType = $(this).data('table');

            if (dataType != null) {
                dataType = 'data=' + dataType;
            }


            $modal.load('modals/' + action + '/' + file + '.php?' + 'data=' + $(this).data('table'), {'id': $(this).data('id')},
            function() {
                $modal.modal('show');

                $('#' + action + '-form').on("submit", function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    $.ajax({
                        url: 'modals/' + action + '/' + file + '.php?' + action + '=' + $('#' + action + '-id').val() + '&' + dataType,
                        type: 'POST',
                        data: new FormData(this),
                        cache: false,
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(data, textStatus, jqXHR) {

                            if ($.trim(data) == 'success') {
                                $modal.modal('hide');
                                alertSuccess.show().find('strong').html($('#' + action + '-id').val());
                                alertSuccess.show().find('span').html('' + action + 'd');
                                window.alert('Data id #' + $('#' + action + '-id').val() + ' ' + action + 'd successfully !');
                                setTimeout(function() {
                                    alertSuccess.fadeOut(800);
                                    //refresh this page.
                                    location.reload();
                                }, 2000);
                                //viewDataTableCustom();
                            } else if ($.trim(data) == 'securityerror') {
                                alertErrorModal.show().find('span').html('You have entered wrong security. Please enter correct code.');
                                window.alert('You have entered wrong security. Please enter correct code.');
                                $('#txtCode').addClass('error');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertErrorPrimary.show().find('span').html(action);
                            setTimeout(function() {
                                alertErrorPrimary.fadeOut(800);
                            }, 2000);
                        }
                    });


                });
            });
        });
    };


</script>