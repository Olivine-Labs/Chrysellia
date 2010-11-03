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
	
	window.CHAT_TYPE_GENERAL = 0;
	window.CHAT_TYPE_EMOTE = 1;
	
	var ChatService = function (){};
	
	ChatService = ChatService.prototype = {
		GetMessagesFromChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Chat.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_GETMESSAGESFROMCHANNEL, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(response);
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
					callback(response);
			   }
			});
		},
		
		SendMessageToChannel: function(channel, message, callback){
			var chatobj = vc.ch.Utilities.ParseMessage(message);
			
			if(chatobj.Type == 0){
				$.ajax({
					url: SERVERCODE_DIRECTORY + "Chat.php",
					cache: false,
					type: "POST",
					data: { Action: ACTION_SENDMESSAGE, Data: JSON.stringify({ Channel: channel, Message: message }) },
					success: function(response){
						callback(response);
				   }
				});
			}else{
				if(chatobj.Type == 1){
					vc.cmd.SendChatCommand(channel, ACTION_EMOTE, chatobj.Message, callback);
				}else{
					callback({ Result: ER_MALFORMED, Data: {} });
				}
			}
		},
		
		JoinChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Commands.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_JOINCHANNEL, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		PartChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Commands.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_PART, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		CreateChannel: function(name, motd, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Commands.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_CREATE, Data: JSON.stringify({ Channel: name, Motd: motd }) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		SetRights: function(channel, characterName, rights, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Commands.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_SETRIGHTS, Data: JSON.stringify({ Channel: channel, Character: characterName, Rights: rights }) },
				success: function(response){
					callback(response);
			   }
			});
		},
		
		Utilities: {},
		
		ChatTypes: {}
	}
	
	ChatService.Utilities = ChatService.Utilities.prototype = {
		ParseMessage: function(message){
			var type = CHAT_TYPE_GENERAL;
			var nonMessageCommand = false;
			
			if(message.indexOf("/e ") == 0){
				type = CHAT_TYPE_EMOTE;
				message = message.substr(3, message.length - 3);
			}else if(message.indexOf("/join") == 0){
				type = ACTION_JOINCHANNEL;
				message = message.substr(5, message.length - 5);
				nonMessageCommand = true;
			}else if(message.indexOf("/create") == 0){
				type = ACTION_CHANNEL_CREATE;
				message = message.substr(7, message.length - 7);
				nonMessageCommand = true;
			}else if(message.indexOf("/leave") == 0){
				type = ACTION_CHANNEL_PART;
				message = message.substr(1, message.length - 1);
				nonMessageCommand = true;
			}else if(message.indexOf("/mod") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/admin") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/mute") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/invite") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}
			
			return { Type: type, Message: message, NonMessageCommand: nonMessageCommand };
		},
		
		ParseRights: function(message){
			if(message.indexOf("/mod ") == 0){
				rights = { Read: 1, Write: 1, Moderate: 1, isJoined:1 };
				charName  = message.substr(5, message.length - 5);
			}else if(message.indexOf("/admin ") == 0){
				rights = { Read: 1, Write: 1, Moderate: 1, Administrate: 1, isJoined:1 };
				charName  = message.substr(7, message.length - 7);
			}else if(message.indexOf("/mute ") == 0){
				charName  = message.substr(6, message.length - 6);
				rights = { Read: 1, Write: 0, Moderate: 0, Administrate: 0, isJoined:1 }
			}else if(message.indexOf("/invite ") == 0){
				charName  = message.substr(8, message.length - 8);
				rights = { Read: 1, Write: 1, Moderate: 0, Administrate: 0, isJoined:1 }
			}
			
			return { Rights: rights, Character: charName }
		}
	}	
	
	V2Core.ChatService = V2Core.ch = ChatService;
})(window);