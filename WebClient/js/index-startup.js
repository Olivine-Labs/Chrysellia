$(function(){
	if($("body").hasClass("home")){
		$("#loginForm").dialog({ modal: true, title: "Log in to your account", width: 600, height: 200, autoOpen: false });
		$("#createAccountForm").dialog({ modal: true, title: "Log in to your account", width: 600, height: 400, autoOpen: false });
		
		$("#screenshots ul").css({display: "block"});
		
		$("#screenshots").jCarouselLite({
			auto: 5000,
			speed: 1000,
			easing: "easeOutQuad",
			circular: true
		});
		
		$("#openLogin").click(function(){
			$("#loginForm").dialog("open");
			return false;
		});
		
		$("#openCreateAccount").click(function(){
			$("#createAccountForm").dialog("open");
			return false;
		});
		
		$("#submitCreateAccount").click(function(){
			if($("ui-state-error:visible", $("#createAccountForm")).length > 0){
				return;
			}
			
			vc.as.Register($("#ca_username").val(), $.md5($("#ca_password").val()), $("#ca_email").val(), function(r){
				switch(r.Result){
					case ER_SUCCESS:
						alert("Your account has been created! You can now log in.");
						$("input", $("#createAccountForm")).val('');
						break;
					case ER_BADDATA:
					case ER_MALFORMED:
					case ER_DBERROR:
						alert("Please check username and password requirements and try again.");
						break;
					case ER_ALREADYEXISTS:
						alert("An account with that username or email already exists!");
						break;
					default:
						alert("An error has occured. Try again later.");
						break;
				}
			});
		});
		
		$("#submitLogIn").click(function(){
			if($("ui-state-error:visible", $("#loginForm")).length > 0){
				return;
			}
			
			vc.as.Login($("#li_username").val(), $.md5($("#li_password").val()), function(r){
				ProcessLogin(r.Result);
			});
		});
		
		$("#submitQuickLogin").click(function(){
			if($("ui-state-error:visible", $("#topLoginForm")).length > 0){
				return;
			}
			
			vc.as.Login($("#ql_username").val(), $.md5($("#ql_password").val()), function(r){
				ProcessLogin(r.Result);
			});
		});
		
		$("#ca_username").parent().focusout(function(){
			$("#ca_username_validator").html("");
			
			if ($("#ca_username").val().length < 5){
				$("#ca_username_validator").html("<span class='ui-state-error ui-corner-all'><span class='ui-icon ui-icon-alert'></span>Username too short.</span>");
			}else{
				// check username
			}
		});
		
		$("#ca_password").parent().focusout(function(){
			$("#ca_password_validator").html("");
			
			if ($("#ca_password").val().length < 5){
				$("#ca_password_validator").html("<span class='ui-state-error ui-corner-all'><span class='ui-icon ui-icon-alert'></span>Password too short.</span>");
			}
		});
	}
});

function ProcessLogin(result){
	switch(result){
		case ER_SUCCESS:
			window.location = "./account.html";
			break;
		case ER_BADDATA:
		case ER_MALFORMED:
		case ER_DBERROR:
			alert("Please check username and password and try again.");
			break;
		case ER_ACCESSDENIED:
			alert("Username or password not found.");
			break;
		default:
			alert("An error has occured. Try again later.");
			break;
	}
}