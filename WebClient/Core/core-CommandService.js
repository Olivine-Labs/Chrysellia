/*!
 * V2 Command Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	// Commands
	window.ACTION_EMOTE = 0;
	window.ACTION_JOINCHANNEL = 1;
	window.ACTION_CHANNEL_CREATE = 2;
	window.ACTION_CHANNEL_PART = 3;
	window.ACTION_CHANNEL_SETRIGHTS = 4;
	
	var CommandService = function (){};
	
	CommandService = CommandService.prototype = {
		SendChatCommand: function(channel, command, message, callback){
			switch(command){
				case ACTION_EMOTE:
					responseData = { Action: ACTION_EMOTE, Data: JSON.stringify({ Channel: channel, Message: message }) }
					break;
				default:
					callback({ Result: ER_MALFORMED, Data: {} });
					return;
					break;
			}
			
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Commands.php",
				cache: false,
				type: "POST",
				data: responseData,
				success: function(response){
					callback(response);
			   }
			});
		}
	}
	
	V2Core.CommandService = V2Core.cmd = CommandService;
})(window);