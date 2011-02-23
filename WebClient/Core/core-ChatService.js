/*!
 * V2 Chat Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
;(function( window, undefined ) {
	var StaticRooms = new Array();
	StaticRooms["General"] = "CHAN_00000000000000000000001";
	StaticRooms["Trade"] = "CHAN_00000000000000000000002";
	
	var ChatService = function (){};
	
	ChatService = ChatService.prototype = {
		ACTION_SENDMESSAGE: 0,
		ACTION_GETMESSAGESFROMCHANNEL: 1,
		ACTION_GETMESSAGESFORCHARACTER: 2,
		
		CHAT_TYPE_GENERAL: 0,
		CHAT_TYPE_EMOTE: 1,
		
		//System types
		CHAT_TYPE_SYSTEM: 255,
		CHAT_TYPE_IDPLAYER: 997,
		CHAT_TYPE_OPENPRIVATECHANNEL:998,
		CHAT_TYPE_MOTD: 999,
		
		StaticRooms: StaticRooms,
	
		GetMessagesFromChannel: function(channel, callback){
			var data = { Channel: channel };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHAT, vc.ch.ACTION_GETMESSAGESFROMCHANNEL, data);
		},
		
		GetMessagesForCharacter: function(callback){
			try{
				var data = { };
				var requestId = vc.GenerateRequestId();
				vc.CallbackStack[requestId] = {Method: callback, Data: data};
				vc.SendSingleRequest(requestId, vc.TYPE_CHAT, vc.ch.ACTION_GETMESSAGESFORCHARACTER, data);
			}catch(err){
				sleep(1000);
				callback();
			}
		},
		
		SendMessageToChannel: function(channel, message, callback){
			var chatobj = vc.ch.Utilities.ParseMessage(message);
			
			switch(chatobj.Type){
				case vc.ChatService.CHAT_TYPE_GENERAL:
					var data = { Channel: channel, Message: message };
					var requestId = vc.GenerateRequestId();
					vc.CallbackStack[requestId] = {Method: callback, Data: data};
					vc.SendSingleRequest(requestId, vc.TYPE_CHAT, vc.ch.ACTION_SENDMESSAGE, data);
					break;
				case vc.ChatService.CHAT_TYPE_EMOTE:
					vc.cmd.SendChatCommand(channel, vc.cmd.ACTION_EMOTE, chatobj.Message, callback);
					break;
				default:
					callback({ Result: V2Core.ER_MALFORMED, Data: data });
					break;
			}
		},
		
		JoinChannel: function(channel, callback){
			var data = { Channel: channel };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_COMMANDS, vc.cmd.ACTION_JOINCHANNEL, data);
		},
		
		PartChannel: function(channel, callback){
			var data = { Channel: channel };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_COMMANDS, vc.cmd.ACTION_CHANNEL_PART, data);
		},
		
		CreateChannel: function(name, motd, publicRead, publicWrite, callback){
			var data = { Channel: name, Motd: motd, PublicRead: publicRead, PublicWrite: publicWrite };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_COMMANDS, vc.cmd.ACTION_CHANNEL_CREATE, data);
		},
		
		SetRights: function(channel, characterName, rights, callback){
			var data = { Channel: channel, Character: characterName, Rights: rights };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_COMMANDS, vc.cmd.ACTION_CHANNEL_SETRIGHTS, data);
		},
		
		SetParameters: function(channel, parameter, value, callback){
			var data = { ChannelId: channel, Parameter: parameter, Value: value };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_COMMANDS, vc.cmd.ACTION_CHANNEL_SETPARAMETERS, data);
		},
		
		Utilities: {},
		
		ChatTypes: {}
	}
	
	ChatService.Utilities = ChatService.Utilities.prototype = {
		ParseMessage: function(message){
			var type = ChatService.CHAT_TYPE_GENERAL;
			var nonMessageCommand = false;
			
			if(message.indexOf("/e ") == 0){
				type = ChatService.CHAT_TYPE_EMOTE;
				message = message.substr(3, message.length - 3);
			}else if(message.indexOf("/join") == 0){
				type = vc.CommandService.ACTION_JOINCHANNEL;
				message = message.substr(5, message.length - 5);
				nonMessageCommand = true;
			}else if(message.indexOf("/create") == 0){
				type = vc.CommandService.ACTION_CHANNEL_CREATE;
				message = message.substr(7, message.length - 7);
				nonMessageCommand = true;
			}else if(message.indexOf("/part") == 0){
				type = vc.CommandService.ACTION_CHANNEL_PART;
				message = message.substr(5, message.length - 1);
				nonMessageCommand = true;
			}else if(message.indexOf("/mod") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/admin") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/mute") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/unmute") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/kick") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/invite") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/unadmin") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/unmod") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETRIGHTS;
				nonMessageCommand = true;
			}else if(message.indexOf("/m ") == 0){
				type = vc.ChatService.CHAT_TYPE_OPENPRIVATECHANNEL;
				message = message.substr(3, message.length - 1);
				nonMessageCommand = true;
			}else if(message.indexOf("/id ") == 0){
				type = vc.ChatService.CHAT_TYPE_IDPLAYER;
				message = message.substr(4, message.length - 1);
				nonMessageCommand = true;
			}else if(message.indexOf("/motd") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
				nonMessageCommand = true;
			}else if(message.indexOf("/publicRead") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
				nonMessageCommand = true;
			}else if(message.indexOf("/publicWrite") == 0){
				type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
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
				rights = { Read: 1, Write: 0, Moderate: 0, Administrate: 0, isJoined:1 };
			}else if(message.indexOf("/unmute ") == 0){
				charName  = message.substr(8, message.length - 8);
				rights = { Read: 1, Write: 1, Moderate: 0, Administrate: 0, isJoined:1 };
			}else if(message.indexOf("/invite ") == 0){
				charName  = message.substr(8, message.length - 8);
				rights = { Read: 1, Write: 1, Moderate: 0, Administrate: 0, isJoined:0 };
			}else if(message.indexOf("/kick ") == 0){
				charName  = message.substr(6, message.length - 6);
				rights = { Read: 0, Write: 0, Moderate: 0, Administrate: 0, isJoined:0 };
			}else if(message.indexOf("/unadmin ") == 0){
				charName  = message.substr(9, message.length - 9);
				rights = { Read: 1, Write: 1, Moderate: 1, Administrate: 0, isJoined:0 };
			}else if(message.indexOf("/unmod ") == 0){
				charName  = message.substr(7, message.length - 7);
				rights = { Read: 1, Write: 1, Moderate: 0, Administrate: 0, isJoined:0 };
			}
			
			return { Rights: rights, Character: charName }
		}
	}	
	
	V2Core.ChatService = V2Core.ch = ChatService;
})(window);