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
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = callback;
			vc.SendSingleRequest(requestId, type, action, data);
		},
		
		Register: function(username, password, email, callback){
			var data = { UserName: username, Password: password, Email: email};
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = callback;
			vc.SendSingleRequest(requestId, vc.TYPE_ACCOUNT, vc.as.ACTION_REGISTER, data);
		},
		
		Logout: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = callback;
			vc.SendSingleRequest(requestId, type, action, data);
		}
	}
	
	V2Core.AccountService = V2Core.as = AccountService;
})(window);