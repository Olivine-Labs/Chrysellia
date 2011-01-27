$(function(){
	
	FB.init({appId: '119442588120693', status: true, cookie: true, xfbml: true});
	
	$("#playNow").dialog({ modal: true, title: "Log In / Register a New Account", width: 600, autoOpen: false });
	
	$("#btnPlayNow, .playNow").bind("click", function(e){
		e.preventDefault();
		if($.cookie("l")=="true"){
			window.location = "./account.php";
		}else{
			$("#playNow").dialog("open");
		}
	});
	
	
	$("#registerForm").bind("submit", function(e){
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
	
	$("#loginForm").bind("submit", function(e){
		e.preventDefault();
		
		if($("ui-state-error:visible", $(".logIn")).length > 0){
			return false;
		}
		var username = $("#li_username").val();
		var password = $("#li_password").val();
		
		LogInAccount(username, password);

		return false;
	});
	
	$("#quickLoginForm").bind("submit", function(e){
		e.preventDefault();
		if($("ui-state-error:visible", $("#topLoginForm")).length > 0){
			return false;
		}
		
		var username = $("#quickLogin_un").val();
		var password = $("#quickLogin_pw").val();
		
		LogInAccount(username, password);
		
		return false;
	});

	$("#fbregister").bind("click", function(e){
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

	$("#fblogin").bind("click", function(e){
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
	
	vc.api.Online(ProcessOnline);
	vc.api.GetTops(25, 0, 0, 0, "", ProcessTops);
});

function ProcessOnline(data){
	if(data.Result == vc.ER_SUCCESS){
		$("#onlines").text(data.Data.Count).removeClass("loading");
	}
}


function ProcessTops(data){
	if(data.Result == vc.ER_SUCCESS){
		var character = {};
		var raceName = "";
		for(var c=0; c < data.Data.length; c++){
			character = data.Data[c];
			raceName = vc.Races[character.RaceId].Name;
			$("#topList").append("<li title='#"+c+": "+character.Name+" " + AlignName(character.AlignGood, character.AlignOrder) + " Level "+character.Level+ " " + raceName + "' class='" + raceName + "'></li>");
		}
	}
}

function LogInAccount(username, password){
	vc.as.Login(username, $.md5(password), function(r){
		ProcessLogin(r.Result);
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

function ProcessLogin(result){
	switch(result){
		case vc.ER_SUCCESS:
			$.cookie("l",true);
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
}

AlignName = function(AlignGood, AlignOrder){
	var goodAlign = "";
	var orderAlign = "";
	var totalAlign = "Neutral";
	
	if(AlignGood <= -100){
		totalAlign = "Evil ";
	}else if(AlignGood >= 100){
		totalAlign = "Good";
	}
	
	if(AlignOrder <= -100){
		if(totalAlign != "Neutral"){
			totalAlign += " ";
		}
		
		totalAlign +=  "Chaotic";
	}else if(AlignOrder >= 100){
		if(totalAlign != "Neutral"){
			totalAlign += " ";
		}
		
		totalAlign += "Ordered";
	}
	
	return totalAlign;
}