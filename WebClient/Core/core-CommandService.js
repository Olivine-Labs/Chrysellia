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

		SendChatCommand: function(channel, command, message, callback){
			switch(command){
				case CommandService.ACTION_EMOTE:
					responseData = { Action: CommandService.ACTION_EMOTE, Data: JSON.stringify({ Channel: channel, Message: message }) }
					break;
				default:
					callback({ Result: V2Core.ER_MALFORMED, Data: {} });
					return;
					break;
			}
			
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Commands.php",
				responseData,
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.CommandService = V2Core.cmd = CommandService;
})(window);