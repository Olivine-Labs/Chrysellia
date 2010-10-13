/*!
 * V2 Account Services Library 0.0.1 rev 01
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 * Date: Tue Oct 12 08:34:00 [-0500]
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.LOGIN = 0;
	window.REGISTER = 1;
	
	var AccountService = function (){};
	
	AccountService = AccountService.prototype = {
		Login: function(username, password, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Account.php",
				cache: false,
				type: "POST",
				data: { Action: LOGIN, UserName: username, Password: password },
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
				data: { Action: REGISTER, UserName: username, Password: password, Email: email },
				success: function(response){
					callback(response);
			   }
			});
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);