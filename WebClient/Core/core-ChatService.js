/*!
 * V2 Account Services Library 0.0.1 rev 01
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 * Date: Tue Oct 12 08:34:00 [-0500]
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
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Chat.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_SENDMESSAGE, Data: JSON.stringify({ Channel: channel, Message: message }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
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
		}
	}
	
	V2Core.ChatService = V2Core.ch = ChatService;
})(window);