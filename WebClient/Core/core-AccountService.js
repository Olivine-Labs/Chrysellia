/*!
 * V2 Account Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.LOGIN = 0;
	window.REGISTER = 1;
	window.LOGOUT = 2;
	
	var AccountService = function (){};
	
	AccountService = AccountService.prototype = {
		Login: function(username, password, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Account.php",
				cache: false,
				type: "POST",
				data: { Action: LOGIN, Data: JSON.stringify({ UserName: username, Password: password }) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		Register: function(username, password, email, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Account.php",
				cache: false,
				type: "POST",
				data: { Action: REGISTER, Data: JSON.stringify({ UserName: username, Password: password, Email: email}) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		Logout: function(callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Account.php",
				cache: false,
				type: "POST",
				data: { Action: LOGOUT, Data: JSON.stringify({ }) },
				success: function(response){
					callback(response);
			   }
			});
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);