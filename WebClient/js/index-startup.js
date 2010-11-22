$(function(){
	$("#playNow").dialog({ modal: true, title: "Register or Log In", width: 600, autoOpen: false });
	
	$("#btnPlayNow, .playNow").click(function(e){
		e.preventDefault();
		$("#playNow").dialog("open");
	});
	
	
	$("#registerForm").submit(function(e){
		e.preventDefault();
		var validRegistration = true;
		var username = $("#ca_username").val();
		var password = $("#ca_password").val();
		var email = $("#ca_email").val();
		
		
		if (username.length < 4){
			validRegistration = false;
			$("#ca_username_validator").html("<span class='ui-state-error ui-corner-all'><span class='ui-icon ui-icon-alert'></span>Username too short.</span>");
		}
		
		if (password.length < 4){
			validRegistration = false;
			$("#ca_password_validator").html("<span class='ui-state-error ui-corner-all'><span class='ui-icon ui-icon-alert'></span>Password too short.</span>");
		}
		
		if(validRegistration){
			vc.as.Register(username, $.md5(password), email, function(r){
				switch(r.Result){
					case ER_SUCCESS:
						alert("Your account has been created! You can now log in.");
						$("#li_username").val(username);
						$("input", $(".register")).val('');
						$("#li_password").focus();
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
		}
		
		return false;
	});
	
	$("#loginForm").submit(function(e){
		e.preventDefault();
		
		if($("ui-state-error:visible", $(".logIn")).length > 0){
			return false;
		}
		
		vc.as.Login($("#li_username").val(), $.md5($("#li_password").val()), function(r){
			ProcessLogin(r.Result);
		});
		
		return false;
	});
	
	$("#quickLoginForm").submit(function(e){
		e.preventDefault();
		if($("ui-state-error:visible", $("#topLoginForm")).length > 0){
			return false;
		}
		
		vc.as.Login($("#quickLogin_un").val(), $.md5($("#quickLogin_pw").val()), function(r){
			ProcessLogin(r.Result);
		});
		
		return false;
	});
});

function ProcessLogin(result){
	switch(result){
		case ER_SUCCESS:
			window.location = "./account.php";
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