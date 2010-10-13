/*!
 * V2 Account Services Library 0.0.1 rev 01
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 * Date: Tue Oct 12 08:34:00 [-0500]
 */
 
(function( window, undefined ) {
	var LOGIN = 0;
	var REGISTER = 1;
	
	V2Core.AccountService = QMSCore.as = QMSCore.AccountService.prototype = {
		Login: function(username, password, callback){
			$.ajax({
				url: "../Server/Account.php",
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
				url: "../Server/Account.php",
				cache: false,
				type: "POST",
				data: { Action: REGISTER, UserName: username, Password: password, Email: email },
				success: function(response){
					callback(response);
			   }
			});
		}
	};
});