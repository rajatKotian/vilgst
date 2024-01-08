$(document).ready(function() {
    $('form').find('.alert').hide();
    $("#btnSubmitLogin").click(function() {

        var username = $("#txtuser").val(),
                password = $("#txtpass").val();
        if (!username || !password) {
            $("#txtuser, #txtpass").closest('.form-group').addClass('has-error');
            $("#errorDiv").show().addClass('alert-danger').html("Please enter your credentials");
            return false;
        } else {
            return loginWithCredential('#txtuser', '#txtpass');
        }
    });
    $("#btnSubmitSSL").click(function() {
        var username = $("#txtuserSSL").val(),
                password = $("#txtpassSSL").val();
        return loginWithCredential('#txtuserSSL', '#txtpassSSL');
    });

    $("#btnSubmitResetPass").click(function() {
        var txtCurrPass = $("#txtCurrPass").val(),
                txtNewPass = $("#txtNewPass").val(),
                txtConfNewPass = $("#txtConfNewPass").val();
        if (!txtCurrPass && !txtNewPass && !txtConfNewPass) {

            $(this).closest('form').find('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("Please enter valid details");

            return false;
        } else if (!txtCurrPass) {
            $("#txtCurrPass").closest('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("Please enter Current Password !");
            return false;
        } else if (!txtNewPass) {
            $("#txtNewPass").closest('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("Please enter New Password !");
            return false;
        } else if (!txtConfNewPass) {
            $("#txtConfNewPass").closest('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("Please enter Confirm Password !");
            return false;
        } else if (txtNewPass != txtConfNewPass) {
            $("#txtNewPass, #txtConfNewPass").closest('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("New password and re-enter password mismatch");
            return false;
        } else if (txtNewPass.length < 5) {
            $("#txtNewPass, #txtConfNewPass").closest('.form-group').addClass('has-error')
                    .closest('form').find('.alert').show().addClass('alert-danger').html("Password length should be minimum 6 characters");
            return false;
        } else {
            return resetPassword('#txtCurrPass', '#txtNewPass', '#txtConfNewPass');
        }
    });

    $("input:not(input[type='radio'])").on('focus', function() {
        $(this).closest('.form-group').removeClass('has-error');
        $(this).closest('form').find('.alert:not(".always-show")').slideUp();
    });

    $("#btnSubmitRegistration").click(function() {
        var errorContainer = $('#registerForm ').find('.alert'),
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;


        if (!$("#txtFName").val()) {
            $("#txtFName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your First Name");
            return false;
        } else if (!$("#txtLName").val()) {
            $("#txtLName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your Last Name");
            return false;
        } else if (!$("#txtEmail").val()) {
            $("#txtEmail").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your Email id");
            return false;
        } else if (!re.test($("#txtEmail").val())) {
            $("#txtEmail").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter valid Email Id");
            return false;
        } else if (!$("#txtComapny").val()) {
            $("#txtComapny").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your Company Name");
            return false;
        } else if (!$("#txtMobile").val()) {
            $("#txtMobile").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your Mobile Number");
            return false;
        } else if (!$("#securitycode").val()) {
            $("#securitycode").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Security Code");
            return false;
        } else {
            return SubmitRegistration();
        }
    });

    $("#txtEmail").on('blur', function() {
        var errorContainer = $('#registerForm ').find('.alert'),
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;

        if (!$("#txtEmail").val()) {
            $("#txtEmail").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your Email id");
            return false;
        } else if (!re.test($("#txtEmail").val())) {
            $("#txtEmail").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter valid Email Id");
            return false;
        } else {
            return checkEmailAvailability();
        }

    });

    $("#btnForgotPassword").click(function() {
        var errorContainer = $('#forgotPasswordForm ').find('.alert');

        if (!$("#userName").val()) {
            $("#userName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your registered Email ID");
            return false;
        } else if (!$("#securitycodeForgot").val()) {
            $("#securitycodeForgot").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Security Code");
            return false;
        } else {
            return forgotPassword();
        }
    });

    $("#frmscheduledemoSubmit").click(function() {
        
        var errorContainer = $('#frmscheduledemo').find('.alert'),
        re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
        
        if (!$("#scheduledemoName").val()) {
            $("#scheduledemoName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your name");
            return false;
        } else if (!$("#scheduledemoCompanyName").val()) {
            $("#scheduledemoCompanyName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Company name");
            return false;
        } else if (!$("#scheduledemoContactNo").val()) {
            $("#scheduledemoContactNo").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your feedback");
            return false;
        } else if (!$("#scheduledemoEmailId").val()) {
            $("#scheduledemoEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's Email ID");
            return false;
        } else if (!re.test($("#scheduledemoEmailId").val())) {
            $("#scheduledemoEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's valid Email Id");
            return false;
        } else {
            return scheduleAdemoMeeting();
//            alert("all ok");
            return false;
        }
        
    });

    // Form Caselaw Email Submit //
    
    $("#frmCaselawSubmit").click(function() {
        
        var errorContainer = $('#frmCaselaw').find('.alert'),
        re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
        
        // if (!$("#caselawKeyword").val()) {
        //     $("#caselawKeyword").closest('.form-group').addClass('has-error');
        //     errorContainer.show().addClass('alert-danger').html("Please Enter Keyword/Party Name");
        //     return false;
        // } else if (!$("#caselawCitation").val()) {
        //     $("#caselawCitation").closest('.form-group').addClass('has-error');
        //     errorContainer.show().addClass('alert-danger').html("Please Enter Citation/Case No.:");
        //     return false;
        // } 
        if (!$("#caselawName").val()) {
            $("#caselawName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Your Name");
            return false;
        } else if (!$("#caselawCompanyName").val()) {
            $("#caselawCompanyName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Company Name");
            return false;
        } else if (!$("#caselawContactNo").val()) {
            $("#caselawContactNo").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Your Contact No.");
            return false;
        } else if (!$("#caselawEmailId").val()) {
            $("#caselawEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Recipient's Email ID");
            return false;
        } else if (!re.test($("#caselawEmailId").val())) {
            $("#caselawEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Recipient's Valid Email Id");
            return false;
        } else if (!$("#caselawSecurityCode").val()) {
            $("#caselawSecurityCode").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please Enter Security Code");
            return false;
        } else {
            return CaselawMeeting();
//            alert("all ok");
            return false;
        }
        
    });



    $("#taxVistaFeedbackFormSubmit").click(function() {
//        alert("hi I am here");
//        debugger;
        var errorContainer = $('#taxvistafeedbackForm ').find('.alert'),
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
//                alert("asdasdsad");
        if (!$("#taxvistafeedbackName").val()) {
            $("#taxvistafeedbackName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your name");
            errorContainer.focus();
            return false;
        } else if (!$("#taxvistafeedbackCompanyName").val()) {
            $("#taxvistafeedbackCompanyName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Company name");
            return false;
        } else if (!$("#taxvistafeedbackArea").val()) {
            $("#taxvistafeedbackArea").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your feedback");
            return false;
            
        } else if (!$("#taxvistafeedbackEmailId").val()) {
            $("#taxvistafeedbackEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's Email ID");
            return false;
        } else if (!re.test($("#taxvistafeedbackEmailId").val())) {
            $("#taxvistafeedbackEmailId").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's valid Email Id");
            return false;
        } else {
            return submitFeedbackTaxVista();
        }

    });

    $("#emailThisPageFormSubmit").click(function() {
        var errorContainer = $('#emailThisPageForm ').find('.alert'),
                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;

        if (!$("#emailPageYourName").val()) {
            $("#emailPageYourName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter your name");
            return false;
        } else if (!$("#emailPageCompName").val()) {
            $("#emailPageCompName").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Company name");
            return false;
        } else if (!$("#emailPageRecEmailID").val()) {
            $("#emailPageRecEmailID").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's Email ID");
            return false;
        } else if (!re.test($("#emailPageRecEmailID").val())) {
            $("#emailPageRecEmailID").closest('.form-group').addClass('has-error');
            errorContainer.show().addClass('alert-danger').html("Please enter Recipient's valid Email Id");
            return false;
        } else {
            return emailThisPage();
        }
    });

    $('.readMoreSubject').click(function() {
        $(this).parent().next().show();
        $(this).parent().hide();

    });
});

var loginWithCredential = function(usernameInput, passwordInput) {

    var username = $(usernameInput).val(),
            password = $(passwordInput).val(),
            errorContainer = $(usernameInput).closest('form').find('.alert');

    $.ajax({
        type: "POST",
        url: main_url+"login.php",
        data: "name=" + username + "&pwd=" + password,
        success: function(html) {
            var html = $.trim(html);
            //alert(html);
            if (html == 'active') {
                window.location.href = $("#ReqUrl").val();
            } else if (html == 'expired') {
                errorContainer.show().addClass('alert-warning').html(" Your account has expired. <br />  Please <a href='subscription'><strong>Subscribe</strong></a> to our services to get uninterrupted access to our website alongwith updates in your mailbox");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 5000);

                $('#btnSubmitLogin').val('Continue to website');

            } else if (html == 'fail') {
                $(usernameInput).add(passwordInput).closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html(" Wrong username or password");
            } else if (html == 'invalidip') {
                $(usernameInput).add(passwordInput).closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("Your access has been blocked, Please contact Administrator.");
            }
        },
        //  	beforeSend:function() {
        // errorContainer.show().addClass('alert-info').html("Loading...");
        //  	}
    });
    return false;

}

var resetPassword = function(txtCurrPassInput, txtNewPassInput, txtConfNewPassInput) {
    var txtCurrPass = $(txtCurrPassInput).val(),
            txtNewPass = $(txtNewPassInput).val(),
            txtConfNewPass = $(txtConfNewPassInput).val(),
            errorContainer = $(txtCurrPassInput).closest('form').find('.alert');
    $.ajax({
        type: "POST",
        url: "/resetPassword.php",
        data: "txtCurrPass=" + txtCurrPass + "&txtNewPass=" + txtNewPass + "&txtConfNewPass=" + txtConfNewPass,
        success: function(html) {
            var html = $.trim(html);
            if (html == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Password reset succesfully");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 2000);
            } else if (html == 'wrong') {
                $(txtCurrPass).closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("Current password is wrong");
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

}

var SubmitRegistration = function() {
    var errorContainer = $('#registerForm').find('.alert'),
            txtEmail = $("#txtEmail").val(),
            txtFName = $("#txtFName").val(),
            txtLName = $("#txtLName").val(),
            txtGender = $("input[name='txtGender']").val(),
            txtOcc = $("#txtOcc").val(),
            txtComapny = $("#txtComapny").val(),
            txtDesignation = $("#txtDesignation").val(),
            txtAdd = $("#txtAdd").val(),
            txtLandline = $("#txtLandline").val(),
            txtDirect = $("#txtDirect").val(),
            txtMobile = $("#txtMobile").val()
    securitycode = $("#securitycode").val(),
            dataString = 'txtEmail=' + txtEmail + '&txtFName=' + txtFName + '&txtLName=' + txtLName + '&txtGender=' + txtGender + '&txtOcc=' + txtOcc + '&txtComapny=' + txtComapny + '&txtDesignation=' + txtDesignation + '&txtAdd=' + txtAdd + '&txtLandline=' + txtLandline + '&txtDirect=' + txtDirect + '&txtMobile=' + txtMobile + '&securitycode=' + securitycode;
    $.ajax({
        type: "POST",
        url: "/register.php",
        data: dataString,
        cache: false,
        success: function(result) {
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank you registering with us. Your user-id and password has been mailed to email-id provided in the Registration Form.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 2000);
            } else if (result == 'alreadyexist') {
                $("#txtEmail").closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("You are already registerd with us.");
            } else if (result == 'wrongcode') {
                $("#securitycode").closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("You entered a wrong Code, Refresh for new code ");
            }

        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

}

var forgotPassword = function() {
    var errorContainer = $('#forgotPasswordForm').find('.alert'),
            userName = $("#userName").val(),
            securitycode = $("#securitycodeForgot").val(),
            dataString = 'userName=' + userName + '&securitycode=' + securitycode;

    $.ajax({
        type: "POST",
        url: "/forgotPassword.php",
        data: dataString,
        cache: false,
        success: function(result) {
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Request submitted successfully, you will recieve password at " + userName + " shortly.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 2000);
            } else if (result == 'notfound') {
                $("#userName").closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("Sorry ! We didn't find any registration with this email ID. Please try another if any");
            } else if (result == 'wrongcode') {
                $("#securitycodeForgot").closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("You entered a wrong Code, Refresh for new code ");
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;
}

var checkEmailAvailability = function() {
    var errorContainer = $('#registerForm').find('.alert'),
            txtEmail = $("#txtEmail").val();

    $.ajax({
        type: "POST",
        url: "/checkEmailAvailability.php",
        data: "txtEmail=" + txtEmail,
        success: function(html) {
            var html = $.trim(html);
            if (html == 'available') {
                $('#txtEmail').closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-danger').html("This Email Id is not available ! ");
            }
        }
    });
    return false;

}

var emailThisPage = function() {
    var errorContainer = $('#emailThisPageForm').find('.alert'),
            emailPageYourName = $("#emailPageYourName").val(),
            emailPageCompName = $("#emailPageCompName").val(),
            emailPageRecEmailID = $("#emailPageRecEmailID").val(),
            file_path = encodeURIComponent($("#file_path").val()),
            dataString = 'emailPageYourName=' + emailPageYourName + '&emailPageCompName=' + emailPageCompName + '&emailPageRecEmailID=' + emailPageRecEmailID + '&file_path=' + file_path;

    $.ajax({
        type: "POST",
        url: "/emailThisPage.php",
        data: dataString,
        cache: false,
        success: function(result) {
            result = result.replace(/\s+/g, '');
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank You. The page has been emailed and the recipient has been notified.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            } else if (result == 'error-mail') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("Error ! File not sent ! Please try again.");
            } else if (result == 'error') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("This functionality has been disabled temporarily, Please try again later");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

}


var submitFeedbackTaxVista = function() {
    var errorContainer = $('#taxvistafeedbackForm').find('.alert'),
            emailPageYourName = $("#taxvistafeedbackName").val(),
            emailPageCompName = $("#taxvistafeedbackCompanyName").val(),
            emailPageFeedback = $("#taxvistafeedbackArea").val(),
            emailPageRecEmailID = $("#taxvistafeedbackEmailId").val(),
            emailPageContactNo = $("#taxvistafeedbackContactNo").val(),
            file_path = encodeURIComponent($("#file_path").val()),
            dataString = 'emailPageYourName=' + emailPageYourName + '&emailPageCompName=' + emailPageCompName + '&emailPageRecEmailID=' + emailPageRecEmailID + '&emailPageFeedback=' + emailPageFeedback + "&emailPageContactNo=" + emailPageContactNo;

    $.ajax({
        type: "POST",
        url: "taxvistaFeedback.php",
        data: dataString,
        cache: false,
        success: function(result) {
            result = result.replace(/\s+/g, '');
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank You. The page has been emailed and the recipient has been notified.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            } else if (result == 'error-mail') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("Error ! File not sent ! Please try again.");
            } else if (result == 'error') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("This functionality has been disabled temporarily, Please try again later");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

}



var scheduleAdemoMeeting = function() {
    var errorContainer = $('#frmscheduledemo').find('.alert'),
            emailPageYourName = $("#scheduledemoName").val(),
            emailPageCompName = $("#scheduledemoCompanyName").val(),
            emailPageFeedback = $("#scheduledemoFeedbackArea").val(),
            emailPageRecEmailID = $("#scheduledemoEmailId").val(),
            emailPageContactNo = $("#scheduledemoContactNo").val(),
            file_path = encodeURIComponent($("#file_path").val()),
            dataString = 'emailPageYourName=' + emailPageYourName + '&emailPageCompName=' + emailPageCompName + '&emailPageRecEmailID=' + emailPageRecEmailID + '&emailPageFeedback=' + emailPageFeedback + "&emailPageContactNo=" + emailPageContactNo;

    $.ajax({
        type: "POST",
        url: "scheduledemo.php",
        data: dataString,
        cache: false,
        success: function(result) {
            result = result.replace(/\s+/g, '');
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank You. The page has been emailed and the recipient has been notified.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            } else if (result == 'error-mail') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("Error ! File not sent ! Please try again.");
            } else if (result == 'error') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("This functionality has been disabled temporarily, Please try again later");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

}

// Form Caselaw Email Function //

var CaselawMeeting = function() {
    var errorContainer = $('#frmCaselaw').find('.alert'),
            emailPageKeyword = $("#caselawKeyword").val(),
            emailPageCitation = $("#caselawCitation").val(),
            emailPageYourName = $("#caselawName").val(),
            emailPageCompName = $("#caselawCompanyName").val(),
            emailPageFeedback = $("#caselawFeedbackArea").val(),
            emailPageRecEmailID = $("#caselawEmailId").val(),
            emailPageContactNo = $("#caselawContactNo").val(),
            emailPageSecurityCode = $("#caselawSecurityCode").val(),
            file_path = encodeURIComponent($("#file_path").val()),
            dataString = 'emailPageKeyword=' + emailPageKeyword + '&emailPageCitation=' + emailPageCitation + '&emailPageYourName=' + emailPageYourName + '&emailPageCompName=' + emailPageCompName + '&emailPageRecEmailID=' + emailPageRecEmailID + '&emailPageFeedback=' + emailPageFeedback + "&emailPageContactNo=" + emailPageContactNo + '&emailPageSecurityCode=' + emailPageSecurityCode;

    $.ajax({
        type: "POST",
        url: "emailCaselaw.php",
        data: dataString,
        cache: false,
        success: function(result) {
            result = result.replace(/\s+/g, '');
            if (result == 'success') {
                errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank You. The page has been emailed and the recipient has been notified.");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            } else if (result == 'error-mail') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("Error ! File not sent ! Please try again.");
            } else if (result == 'error') {
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("This functionality has been disabled temporarily, Please try again later");
                setTimeout(function() {
                    window.location.href = $("#ReqUrl").val();
                }, 1500);
            } else if (result == 'wrongcode') {
                $("#caselawSecurityCode").closest('.form-group').addClass('has-error');
                errorContainer.show().addClass('alert-info').addClass('alert-danger').html("You entered a wrong Code, Refresh for new code ");
            }
        },
        beforeSend: function() {
            errorContainer.show().addClass('alert-info').html("Loading...");
        }
    });
    return false;

};