<?php
$dataType = '';
$pageType = 'COISectionListSection';
$pageHead = '';

include('header.php');
$addText = 'All COI Section';
$chapter_id = 0;
if (isset($_GET['chapter_id'])) {
    //show list only of particular chpater.
    $chapter_id = cleanForDB($_GET['chapter_id']);
}
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
                                <a href="COI_Section_ChapterAdd.php">Add Chapter</a>           
                            </div>
                            <div class="box-tools pull-right">
                                <a href="COI_SectionAdd.php">Add Section</a>           
                            </div>
                        </div>
                    </div>
                    <div class="box-body" id="dataresult-container" style="padding-top: 50px;">
                        <table id="dataResult" class="display table table-bordered table-hover table-blue" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="min-width: 5px;">ID</th>
                                    <th style="min-width: 20px;">Seq No (For Ordering)</th>
                                    <th>Section No. (Display)</th>
                                    <th style="min-width: 150px;">Section Name</th>
                                    <th style="min-width: 150px;">Act Type</th>
                                    <th>Chapter No</th>
                                    <th style="min-width: 50px;">Section File</th>
                                    <!--<th>Last Updated on</th>-->
                                    <th class="no-sort" style="min-width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //getting list of all chpaters
                                $sections = listCOISections($chapter_id);
                                if (count($sections) > 0) {
                                    foreach ($sections as $section) {
                                        ?>
                                        <tr>
                                            <td><p><?php echo $section['id']; ?></p></td>
                                            <td><p><?php echo $section['section_seq_no']; ?></p></td>
                                            <td><p><?php echo $section['section_type'] . " " . $section['section_no']; ?></p></td>
                                            <td><p><?php echo $section['section_name']; ?></p></td>
                                            <td><p><?php echo $section['section_act_type']; ?></p></td>
                                            <td><p><?php
                                                    if ($section['section_type'] == 'Section') {
                                                        echo "Chapter " . $section['chapter_no'];
                                                        $SectionNameDisplay = " Section " . $section['section_no'];
                                                    } else {
                                                        echo $section['chapter_no'];
                                                        $SectionNameDisplay =  $section['section_type'];
                                                    }
                                                    ?></p></td>
                                            <td><p>
                                                    <?php
                                                    $encryptyId = base64_encode(base64_encode($section['id']));

                                                    echo "<a  href='../showiframe3?V1Zaa1VsQlJQVDA9=" . $encryptyId . "&showLOAsections' target='_blank' >" . $SectionNameDisplay . "</a><button class='copy-file-link badge bg-navy'>Copy</button>";
                                                    ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p>

                                                    <a href="COI_editHTMLSectionFile.php?V1Zaa1VsQlJQVDA9=<?php echo $encryptyId; ?>&table=coi_sections&primarykey=id&name=<?php echo $section['section_no']; ?>&title=<?php echo $section['section_name']; ?>" data-id="<?php echo $encryptyId ?>" data-table="coi_sections" data-name="<?php echo $section['section_name']; ?>" data-title="COI Section" data-toggle="tooltip" class="btn btn-warning edit-html" title="" data-original-title="Edit HTML" target="_blank">
                                                        <i class="fa fa-file-code-o"></i></a>

                                                    <a href='COI_SectionEdit.php?id=<?php echo $section['id']; ?>' data-id='<?php echo $section['id']; ?>' data-table='coi_sections' data-toggle='tooltip' 
                                                       class='btn btn-success update-data' title='Edit Data'><i class='fa fa-edit'></i>
                                                    </a>  
                                                    <a href='#' data-id='<?php echo $section['id']; ?>' data-table='coi_sections' data-toggle='tooltip' class='btn btn-danger delete-data' 
                                                       title='Delete Data'><i class='fa fa-trash-o'></i>
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td>No Section Found.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
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
                loadPopupModalDeleteAll('coi_section', 'delete');
                copyLinkToClipboard();
//                initHtmlEditPage();
            },
            "initComplete": function() {
                $('[data-toggle="tooltip"]').tooltip();
                loadPopupModalDeleteAll('coi_section', 'delete');
                copyLinkToClipboard();
//                initHtmlEditPage();
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

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  var firebaseConfig = {
    apiKey: "AIzaSyDJ8GOjtJzXn0Osv8--fpf5PGtk7Y3aSSI",
    authDomain: "vilgst.firebaseapp.com",
    projectId: "vilgst",
    storageBucket: "vilgst.appspot.com",
    messagingSenderId: "493343969816",
    appId: "1:493343969816:web:2ea8047fba70f4980d696d",
    measurementId: "G-DQNYHJLPB3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>