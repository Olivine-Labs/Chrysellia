$(function(){
	$("#playNow").dialog({ modal: true, title: "Register or Log In", width: 600, autoOpen: false });
	
	$("#btnPlayNow, .playNow").click(function(e){
		e.preventDefault();
		if($.cookie("l")=="true"){
			window.location = "./account.php";
		}else{
			$("#playNow").dialog("open");
		}
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
		var username = $("#li_username").val();
		var password = $("#li_password").val();
		
		LogInAccount(username, password);

		return false;
	});
	
	$("#quickLoginForm").submit(function(e){
		e.preventDefault();
		if($("ui-state-error:visible", $("#topLoginForm")).length > 0){
			return false;
		}
		
		var username = $("#quickLogin_un").val();
		var password = $("#quickLogin_pw").val();
		
		LogInAccount(username, password);
		
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
				}, {perms:'read_stream,publish_stream,offline_access,email,create_event,usvc.ER_birthday'});
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
		
		var username = "";
		var password = "";
		var email = "";
							
		FB.getLoginStatus(function(response) {
			if (!response.session) {
				FB.login(function(response) {
					if (response.session) {
						username = response.session.uid;
						password = response.session.access_token;
						
						LogInAccount(username, password);						
					} else {
						// cancelled
					}
				});
			}else{
				username = response.session.uid;
				password = response.session.access_token;
						
				LogInAccount(username, password);
			}
		});
	});

});

function LogInAccount(username, password){
	vc.as.Login(username, $.md5(password), function(r){
		switch(r.Result){
			case vc.ER_SUCCESS:
				$.cookie("l",true)
				window.location = "./account.php";
				break;
			case vc.ER_BADDATA:
			case vc.ER_MALFORMED:
			case vc.ER_DBERROR:
				alert("Please check login information and try again.");
				break;
			case vc.ER_ACCESSDENIED:
				alert("An account with those credentials was not found.");
				break;
			default:
				alert("An error has occured. Try again later.");
				break;
		}
	});
}

function RegisterAccount(username, password, email){
	vc.as.Register(username, $.md5(password), email, function(r){
		switch(r.Result){
			case vc.ER_SUCCESS:
				vc.as.Login(username, $.md5(password), function(r){
					ProcessLogin(r.Result);
				});
				break;
			case vc.ER_BADDATA:
			case vc.ER_MALFORMED:
			case vc.ER_DBERROR:
				alert("Please check username and password requirements and try again.");
				break;
			case vc.ER_ALREADYEXISTS:
				alert("An account with that Facebook login already exists!");
				break;
			default:
				alert("An error has occured. Try again later.");
				break;
		}
	});
}