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
			RegisterAccount(username, password, email);
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
	
	FB.init({appId: '119442588120693', status: true, cookie: true, xfbml: true});

	$("#fbregister").click(function(e){
		e.preventDefault();
		
		var username = "";
		var password = "";
		var email = "";
					
		FB.getLoginStatus(function(response) {
			if (!response.session) {
				FB.login(function(response) {
					
					if (response.session) {
						username = response.session.uid;
						password = response.session.access_token;

						if (response.perms) {
							FB.api('/me', function(response) {
								email = response.email;
								RegisterAccount(username, password, email);
							});
						} else {
						  // user is logged in, but did not grant any permissions
						}
					} else {
						// cancelled
					}
				}, {perms:'read_stream,publish_stream,offline_access,email,create_event,user_birthday'});
			}else{
				username = response.session.uid;
				password = response.session.access_token;
				
				FB.api('/me', function(response) {
					email = response.email;
					RegisterAccount(username, password, email);
				});
			}
		});
	});

	$("#fblogin").click(function(e){
		e.preventDefault();
		
		FB.getLoginStatus(function(response) {
			if (!response.session) {
				FB.login(function(response) {
					if (response.session) {
						username = response.session.uid;
						password = response.session.access_token;
						
						vc.as.Login(username, $.md5(password), function(r){
							ProcessLogin(r.Result);
						});
						
					} else {
						// cancelled
					}
				});
			}else{
				username = response.session.uid;
				password = response.session.access_token;
				
				vc.as.Login(username, $.md5(password), function(r){
					ProcessLogin(r.Result);
				});
			}
		});
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
			alert("Please check login information and try again.");
			break;
		case ER_ACCESSDENIED:
			alert("An account with those credentials was not found.");
			break;
		default:
			alert("An error has occured. Try again later.");
			break;
	}
}

function RegisterAccount(username, password, email){
	vc.as.Register(username, $.md5(password), email, function(r){
		switch(r.Result){
			case ER_SUCCESS:
				vc.as.Login(username, $.md5(password), function(r){
					ProcessLogin(r.Result);
				});
				break;
			case ER_BADDATA:
			case ER_MALFORMED:
			case ER_DBERROR:
				alert("Please check username and password requirements and try again.");
				break;
			case ER_ALREADYEXISTS:
				alert("An account with that Facebook login already exists!");
				break;
			default:
				alert("An error has occured. Try again later.");
				break;
		}
	});
}