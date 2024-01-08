$().ready(function() {

    var cgst_loaded = false;
    var igst_loaded = false;
    var sgst_loaded = false;

    $('.explorer-hide').click(function() {
        $('#GSTExplorerDiv').hide('fast');
        $('#ExplorerPinDiv').show('slow');
    });

    $('#ExplorerPinDiv').click(function() {
        $('#GSTExplorerDiv').show('slow');
        $('#ExplorerPinDiv').hide('fast');
        $('#explorer-block-container-cgst').show();
        $('#explorer-block-container-igst').hide();
        $('#explorer-block-container-sgst').hide();
    });

    $('.explorer-expanding-blocks-header').click(function() {
        if ($(this).find('.expand').html() == '+') {
            $('.explorer-expanding-blocks-header > .expand').html('+');
            $('.explorer-block-container').hide();

            var data_block = $(this).attr('data-target');
            
            if (data_block === 'cgst' && cgst_loaded === false) {
                DisplayProdData(data_block);
                displaysubprod(data_block);
                cgst_loaded=true;
            }

            if (data_block === 'igst' && igst_loaded === false) {
                DisplayProdData(data_block);
                displaysubprod(data_block);
                igst_loaded=true;
            }

            if (data_block === 'sgst' && sgst_loaded === false) {
                DisplayProdData(data_block);
                displaysubprod(data_block);
                sgst_loaded=true;
            }

            $('#explorer-block-container-' + data_block).show();
            $(this).find('.expand').html('-');
        }
        //else {
//            $('.explorer-expanding-blocks-header > .expand').html('+');
//            $('.explorer-block-container').hide();
//        }
    });

    $('.explorer-expanding-blocks').click(function() {
        if ($(this).find('.expand').html() == '+') {
//            $('.expand').html('+');
            $('.explorer-expanding-blocks > .expand').html('+');
            $('.listing-blocks').hide();
            var data_block = $(this).attr('data-block');
            $('#explorer-listing-' + data_block).show();
            $(this).find('.expand').html('-');
        } else {
            $('.explorer-expanding-blocks > .expand').html('+');
            $('.listing-blocks').hide();
        }
    });

    $('.ex-blocks').click(function() {
        if ($(this).find('.expand').html() == '+') {
//            $('.expand').html('+');
            $('.ex-blocks > .expand').html('+');
            $('.listing-blocks').hide();
            var data_block = $(this).attr('data-block');
            $('#expand-listing-' + data_block).show();
            $(this).find('.expand').html('-');
        } else {
            $('.ex-blocks > .expand').html('+');
            $('.listing-blocks').hide();
        }
    });

    $('.explorer-expanding-blocks-header').trigger('change');

});


function DisplayProdData(prodName) {
    var csrf_token_explorer = $('#csrf-token_explorer').html();
    var postdata = {'gst_prod_name': prodName, 'csrf-token_explorer': csrf_token_explorer};

    $.ajax({
        type: "POST",
        url: "explorer_ajax.php",
        data: postdata,
//            cache: true,
        dataType: 'json',
        success: function(res) {
            // alert(res.success);
            if (res.success == true) {
                resdata = res.data;
                updateExplorerDataPan1(resdata, prodName);
            }
        }
    });
}

function updateExplorerDataPan1(responseData, prodName) {
    var sections = responseData.sections;
    var rules = responseData.rules;
    var notifications = responseData.notifications;
    var circulars = responseData.circulars;
    var emptyListItem = "<li>No Records Found</li>";

    $('#explorer-listing-sections-' + prodName).html('');

    $.each(sections, function(k, v) {
        var listidsec = v.data_id;
        var listItem = "<li><a class='sect' id=" + v.data_id + ">" + v.display + "</a></li>";

        $('#explorer-listing-sections-' + prodName).append(listItem);

        $('a.sect').click(function() {
            var id = $(this).attr('id');
            //console.log(id);
            $('#navigation-left').show('slow');
            displaysubprod(id, prodName);
        });
        // $(".sect").attr("id", listidsec).click(function() {
        //     $('#navigation-left').show('slow');
        //     displaysubprod(listidsec, prodName);
        // });

    });

    $('#explorer-listing-rules-' + prodName).html('');

    $.each(rules, function(k, v) {
        var listidrule = v.data_id;
        var listItem = "<li><a class='rule' id=" + v.data_id + ">" + v.display + "</a></li>";

        $('#explorer-listing-rules-' + prodName).append(listItem);

        $('a.rule').click(function() {
            var id = $(this).attr('id');
            //console.log(id);
            $('#navigation-left').show('slow');
            displaysubprod(id, prodName);
        });
        // $(".rule").attr("id", listidrule).click(function() {
        //     $('#navigation-left').show('slow');
        //     displaysubprod(listidrule, prodName);
        // });

    });

    $('#explorer-listing-notifications' + prodName).html('');

    $.each(notifications, function(k, v) {
        var listidnoti = v.data_id;
        var listItem = "<li><a class='noti' id=" + v.data_id + ">" + v.display + "</a></li>";

        $('#explorer-listing-notifications-' + prodName).append(listItem);

        $('a.noti').click(function() {
            var id = $(this).attr('id');
            //console.log(id);
            $('#navigation-left').show('slow');
            displaysubprod(id, prodName);
        });
        // $(".noti").attr("id", listidnoti).click(function() {
        //     $('#navigation-left').show('slow');
        //     displaysubprod(listidnoti, prodName);
        // });

    });

    $('#explorer-listing-circulars' + prodName).html('');

    $.each(circulars, function(k, v) {
        var listidcir = v.data_id;
        var listItem = "<li><a class='cir' id=" + v.data_id + ">" + v.display + "</a></li>";

        $('#explorer-listing-circulars-' + prodName).append(listItem);

        $('a.cir').click(function() {
            var id = $(this).attr('id');
            //console.log(id);
            $('#navigation-left').show('slow');
            displaysubprod(id, prodName);
        });
        // $(".cir").attr("id", listidcir).click(function() {
        //     $('#navigation-left').show('slow');
        //     displaysubprod(listidcir, prodName);
        // });

    });
}

function displaysubprod(sub_prod_id5, prodName){
    var csrf_token_explorer = $('#csrf-token_explorer').html();
    var postdata = 
        {'sub_prod_id5': sub_prod_id5, 'gst_prod_name': prodName, 'csrf-token_explorer': csrf_token_explorer};
    $.ajax({
        type: "POST",
        url: "explorer_ajax.php",
        data: postdata,
//            cache: true,
        dataType: 'json',
        success: function(res) {
 //            alert(res.success);
                console.log(res);
            if (res.success == true) {
                resdata = res.data;
                updateExplorerDataPan2(resdata, sub_prod_id5, prodName);
            }
        }
    });
}

function updateExplorerDataPan2(responseData, sub_prod_id5, prodName) {
    var sections = responseData.sections;
    var rules = responseData.rules;
    var notifications = responseData.notifications;
    var circulars = responseData.circulars;
    var judgements = responseData.judgements;
    var citeIn_Case = responseData.citeIn_Case;
    var citeIn_Notification = responseData.citeIn_Notification;
    var citeIn_Circular = responseData.citeIn_Circular;
    var citeIn_Section = responseData.citeIn_Section;
    var citeIn_Rule = responseData.citeIn_Rule;

    var sections1 = responseData.sections1;
    var rules1 = responseData.rules1;
    var notifications1 = responseData.notifications1;
    var circulars1 = responseData.circulars1;
    var judgements1 = responseData.judgements1;
    var citeIn_Case1 = responseData.citeIn_Case1;
    var citeIn_Notification1 = responseData.citeIn_Notification1;
    var citeIn_Circular1 = responseData.citeIn_Circular1;
    var citeIn_Section1 = responseData.citeIn_Section1;
    var citeIn_Rule1 = responseData.citeIn_Rule1;
    var emptyListItem = "<li>No Records Found</li>";

//          View Related Records 
//  1.
        $('#expand-listing-rsect-' + prodName).html('');

        if (sections1 > 0) {
            //$('#expand-listing-rsect-' + prodName).parent('.ex-blocks').append(sections1);
            $.each(sections, function(k, v) {
                var listItem = 
                "<li class='sect'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";
                    
                    $('#expand-listing-rsect-' + prodName).append(listItem);
            });
        }else{
            $('#expand-listing-rsect-' + prodName).parent('.ex-blocks').hide();
        }

//  2.
        $('#expand-listing-rrul-' + prodName).html('');

        if (rules1 > 0) {
            $.each(rules, function(k, v) {
                var listItem = 
                "<li class='rule'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-rrul-' + prodName).append(listItem);
            });
        }else{
            $('#expand-listing-rrul-' + prodName).parent('.ex-blocks').hide();
        }

//  3.
        $('#expand-listing-rnoti' + prodName).html('');
        
        if (notifications1 > 0) {
            $.each(notifications, function(k, v) {

                var listItem = 
                "<li class='noti'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-rnoti-' + prodName).append(listItem);
            });
        }else{
            $('#expand-listing-rnoti-' + prodName).parent('.ex-blocks').hide();
        }

//  4.
        $('#expand-listing-rcir' + prodName).html('');

        if (circulars1 > 0) {
            $.each(circulars, function(k, v) {

                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-rcir-' + prodName).append(listItem);
            });
        }else{
            $('#expand-listing-rcir-' + prodName).parent('.ex-blocks').hide();
        }

//  5.
        $('#expand-listing-rjud' + prodName).html('');

        if (judgements1 > 0) {
            $.each(judgements, function(k, v) {

                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-rjud-' + prodName).append(listItem);
            });
        }else {
            $('#expand-listing-rjud-' + prodName).parent('.ex-blocks').hide();
        }


//              CiteIn Records
//  1.
        $('#expand-listing-cCase' + prodName).html('');

        if (citeIn_Case1 > 0) {
            $.each(citeIn_Case, function(k, v) {
                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-cCase-' + prodName).append(listItem);
            });
        } else {
            $('#expand-listing-cCase-' + prodName).parent('.ex-blocks').hide();
        }

//  2.
        $('#expand-listing-cNotification' + prodName).html('');

        if (citeIn_Notification1 > 0) {
            $.each(citeIn_Notification, function(k, v) {
                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                $('#expand-listing-cNotification-' + prodName).append(listItem);
            });
        } else {
            $('#expand-listing-cNotification-' + prodName).parent('.ex-blocks').hide();
        }

//  3.
        $('#expand-listing-cCircular' + prodName).html('');

        if (citeIn_Circular1 > 0) {
            $.each(citeIn_Circular, function(k, v) {
                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-cCircular-' + prodName).append(listItem);
            });
        } else {
            $('#expand-listing-cCircular-' + prodName).parent('.ex-blocks').hide();
        }

//  4.
        $('#expand-listing-cSection' + prodName).html('');

        if (citeIn_Section1 > 0) {
            $.each(citeIn_Section, function(k, v) {
                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-cSection-' + prodName).append(listItem);
            });
        } else {
            $('#expand-listing-cSection-' + prodName).parent('.ex-blocks').hide();
        }

//  5.
        $('#expand-listing-cRule' + prodName).html('');

        if (citeIn_Rule1 > 0) {
            $.each(citeIn_Rule, function(k, v) {
                var listItem = 
                "<li class='cir'><a href="+ v.data_id +" target='_blank' id=" + v.data_id + ">" + v.display + "<span style='padding-left: 15px;'>[" + v.prod_name + "]</span></a></li>";

                    $('#expand-listing-cRule-' + prodName).append(listItem);
            });
        } else {
            $('#expand-listing-cRule-' + prodName).parent('.ex-blocks').hide();
        }
};