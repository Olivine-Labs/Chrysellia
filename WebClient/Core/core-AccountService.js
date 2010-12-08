/*!
 * V2 Account Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	var AccountService = function (){};
	
	AccountService = AccountService.prototype = {
		ACTION_LOGIN: 0,
		ACTION_REGISTER: 1,
		ACTION_LOGOUT: 2,
		
		Login: function(username, password, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Account.php",
				{ Action: AccountService.ACTION_LOGIN, Data: JSON.stringify({ UserName: username, Password: password }) },
				function(data) { callback(data); }
			);
		},
		
		Register: function(username, password, email, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Account.php",
				{ Action: AccountService.ACTION_REGISTER, Data: JSON.stringify({ UserName: username, Password: password, Email: email}) },
				function(data) { callback(data); }
			);
		},
		
		Logout: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Account.php",
				{ Action: AccountService.ACTION_LOGOUT, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);