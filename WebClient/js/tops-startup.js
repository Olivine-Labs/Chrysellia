;$(function(){
	$("#playNow").dialog({ modal: true, title: "Log In / Register a New Account", width: 600, autoOpen: false });
	
	$(".playNow").bind("click", function(e){
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
	
	$("#topsOptions button").button({icons: { primary: "ui-icon-search" }});
	
	$("#topsOptions").bind("submit", function(e){
		e.preventDefault();
		$("#topsOptions button").button("option", "disabled", true);
		var sortType = $("#sortOptions").val();
		var sortDir = $("#sortDirection").val();
		vc.api.GetTops(25, 0, sortDir, sortType, "", ProcessTops);
	});
	
	vc.api.GetTops(25, 0, 0, 0, "", ProcessTops);
});


function ProcessTops(data){
	$("#topsOptions button").button("option", "disabled", false);
	if(data.Result == vc.ER_SUCCESS){
		var character = {};
		var raceName = "";
		var li = {};
		var topList = $("#topList");
		var characters = data.Data;
		
		if(topList.children().length > 0){
			$("#topList").animate({ opacity:0 }, 250, function(){
				topList.empty().css({opacity: 1});
				$("#topstmpl").tmpl({ character:characters }).appendTo(topList);
			});
		}else{
			$("#topstmpl").tmpl({ character:characters }).appendTo(topList);
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
