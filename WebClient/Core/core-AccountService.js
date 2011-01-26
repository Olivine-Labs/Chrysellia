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
			var data = { UserName: username, Password: password };
			vc.SendQueuedRequest(vc.TYPE_ACCOUNT, vc.as.ACTION_LOGIN, data).success( function(data) { callback(data); } );
		},
		
		Register: function(username, password, email, callback){
			var data = { UserName: username, Password: password, Email: email};
			vc.SendQueuedRequest(vc.TYPE_ACCOUNT, vc.as.ACTION_REGISTER, data).success( function(data) { callback(data); } );
		},
		
		Logout: function(callback){
			var data = { };
			vc.SendQueuedRequest(vc.TYPE_ACCOUNT, vc.as.ACTION_LOGOUT, data).success( function(data) { callback(data); } );
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);