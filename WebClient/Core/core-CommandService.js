/*!
 * V2 Command Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	var CommandService = function (){};
	
	CommandService = CommandService.prototype = {
		ACTION_EMOTE: 0,
		ACTION_JOINCHANNEL: 1,
		ACTION_CHANNEL_CREATE: 2,
		ACTION_CHANNEL_PART: 3,
		ACTION_CHANNEL_SETRIGHTS: 4,
		ACTION_CHANNEL_SETPARAMETERS: 5,
		ACTION_ID: 6,

		SendChatCommand: function(channel, command, message, callback){
			switch(command){
				case vc.CommandService.ACTION_EMOTE:
					var data = { Channel: channel, Message: message };
					var requestId = vc.GenerateRequestId();
					vc.CallbackStack[requestId] = callback;
					vc.SendSingleRequest(requestId, vc.TYPE_CHAT, command, data);
					break;
				case vc.CommandService.ACTION_ID:
					var data = { Character: message };
					var requestId = vc.GenerateRequestId();
					vc.CallbackStack[requestId] = callback;
					vc.SendSingleRequest(requestId, vc.TYPE_CHAT, command, data);
					break;
				default:
					callback({ Result: V2Core.ER_MALFORMED, Data: {} });
					return;
					break;
			}
		}
	}
	
	V2Core.CommandService = V2Core.cmd = CommandService;
})(window);