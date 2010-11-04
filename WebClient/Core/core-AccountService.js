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
			$.getJSON(
				SERVERCODE_DIRECTORY + "Account.php?jsonCallback=?",
				{ Action: LOGIN, Data: JSON.stringify({ UserName: username, Password: password }) },
				function(data) { callback(data); }
			);
		},
		
		Register: function(username, password, email, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Account.php?jsonCallback=?",
				{ Action: REGISTER, Data: JSON.stringify({ UserName: username, Password: password, Email: email}) },
				function(data) { callback(data); }
			);
		},
		
		Logout: function(callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Account.php?jsonCallback=?",
				{ Action: LOGOUT, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);