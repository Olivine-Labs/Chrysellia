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
	window.CHAT_TYPE_EMOTE = 0;
	
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
		
		SendMessageToChannel: function(channel, message, callback){
			var chatobj = vc.ch.Utilities.ParseMessage(message);
			
			if(chatobj.Type == 0){
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
				if(chatobj.Type == 1){
					vc.cmd.SendChatCommand(channel, ACTION_EMOTE, chatobj.Message, callback);
				}else{
					callback({ Result: ER_MALFORMED, Data: {} });
				}
			}
		},
		
		JoinChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Command.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_JOINCHANNEL, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		PartChannel: function(channel, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Command.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_PART, Data: JSON.stringify({ Channel: channel }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		CreateChannel: function(name, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Command.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_CREATE, Data: JSON.stringify({ Channel: name }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		SetRights: function(channel, characterId, rights, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Command.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHANNEL_SETRIGHTS, Data: JSON.stringify({ Channel: channel, Character: characterId, Rights: rights }) },
				success: function(response){
					callback(JSON.parse(response));
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
				NonMessageCommand = true;
			}else if(message.indexOf("/create") == 0){
				type = ACTION_CHANNEL_CREATE;
				message = message.substr(7, message.length - 7);
				NonMessageCommand = true;
			}else if(message.indexOf("/leave") == 0){
				type = ACTION_CHANNEL_PART;
				message = message.substr(1, message.length - 1);
				NonMessageCommand = true;
			}else if(message.indexOf("/mod") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				message = message.substr(1, message.length - 1);
				NonMessageCommand = true;
			}else if(message.indexOf("/admin") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				message = message.substr(1, message.length - 1);
				NonMessageCommand = true;
			}else if(message.indexOf("/mute") == 0){
				type = ACTION_CHANNEL_SETRIGHTS;
				message = message.substr(1, message.length - 1);
				NonMessageCommand = true;
			}
			
			return { Type: type, Message: message, NonMessageCommand: nonMessageCommand };
		},
		
		ParseRights: function(message){
			if(message.indexOf("mod ") == 0){
				Rights = { Read: 1, Write: 1, Moderate: 1 };
				player  = message.substr(4, message.length - 4);
			}else if(message.indexOf("admin ") == 0){
				Rights = { Read: 1, Write: 1, Moderate: 1, Administrate: 1 };
				player  = message.substr(6, message.length - 6);
			}
			else if(message.indexOf("mute ") == 0){
				player  = message.substr(4, message.length - 4);
				Rights = { Read: 1, Write: 0, Moderate: 0, Administrate: 0 }
			}
			
			return { Rights: rights, Player: player }
		}
	}	
	
	V2Core.ChatService = V2Core.ch = ChatService;
})(window);