/*!
 * V2 Chat Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.ACTION_SENDMESSAGE = 0;
	window.ACTION_GETMESSAGESFROMCHANNEL = 1;
	window.ACTION_GETMESSAGESFORCHARACTER = 2;
	window.ACTION_JOINCHANNEL = 3;
	
	var ChatService = function (){};
	
	ChatService = ChatService.prototype = {
		GetMessagesFromChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Chat.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_GETMESSAGESFROMCHANNEL, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		SendMessageToChannel: function(channel, message, callback){
			if(message.indexOf("/") != 0){
				$.ajax({
					url: SERVERCODE_DIRECTORY + "Chat.php",
					cache: false,
					type: "POST",
					data: { Action: ACTION_SENDMESSAGE, Data: JSON.stringify({ Channel: channel, Message: message }) },
					success: function(response){
						callback(JSON.parse(response));
				   }
				});
			}else{
				if(message.indexOf("/e ") == 0){
					vc.cmd.SendChatCommand(channel, ACTION_EMOTE, message.substr(3, message.length - 3), callback);
				}else{
					callback({ Result: ER_MALFORMED, Data: {} });
				}
			}
		},
		
		JoinChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Chat.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_JOINCHANNEL, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		GetMessagesForCharacter: function(callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Chat.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_GETMESSAGESFORCHARACTER, Data: JSON.stringify({ }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		Utilities: {}
	}
	
	ChatService.Utilities = ChatService.Utilities.prototype = {
		ParseMessage: function(message){
			var type = 0;

			if(message.indexOf("/e ") == 0){
				type = 1;
				message = message.substr(3, message.length - 3);
			}
			
			return {Type: type, Message: message};
		}
	}
	
	V2Core.ChatService = V2Core.ch = ChatService;
})(window);