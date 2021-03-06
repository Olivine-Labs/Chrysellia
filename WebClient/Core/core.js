/*!
 * V2 Core Library 0.0.1 rev 01
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 * Date: Tue Oct 12 08:22:00 [-0500]
 *
 * Dependencies: jQuery Core
 */

 
 ;(function( window, undefined ) {

	var V2Core = function (){};
	var ShortQueue = function(){};
	var LongQueue = function(){};
	
	var V2Result = {};
	V2Result = V2Result.prototype = {
		Result: 0,
		Data: {}
	};
	
	V2Core = V2Core.prototype = {
		//enums!
		ER_SUCCESS: 0, //when Murphy is not around everything works.
		ER_SERVERERROR: 248, //when the server returns something that's not a 400
		ER_NOTONLINE: 249, //when the target is not online
		ER_NOTLOGGEDIN: 250, //when the session fails
		ER_BADDATA: 251, //when the data is bad
		ER_ALREADYEXISTS: 252, //when the data already exists in the database
		ER_MALFORMED: 253, //when a post/get is malformed for the function requested
		ER_DBERROR: 254, //when the database fails
		ER_ACCESSDENIED: 255, //when they just don't have access.
		SERVERCODE_DIRECTORY: "./Server/",
		STATICINFO_DIRECTORY: "./Core/staticInfo/",
		API_URI: "./Server/API.php",
		
		TYPE_ACCOUNT: 0, 
		TYPE_CHARACTER: 1, 
		TYPE_CHAT: 2, 
		TYPE_COMMANDS: 3, 
		TYPE_ITEM: 4, 
		TYPE_MAP: 5, 
		TYPE_MONSTER: 6, 
		TYPE_PLACES: 7, 
		TYPE_API: 8,
		
		COMPRESSION_MODE_NONE: 0,
		COMPRESSION_MODE_jSEND: 1,
		
		//config options!
		Version: "0.0.1",
		CurrentLanguage: "en",
		DebugMode: false,
		RequestDurationTotal: 0,
		Requests: 0,
		
		//Ajax Errors
		GlobalErrorCount: 0,
		
		CompressionMode: this.COMPRESSION_MODE_NONE,
		
		//Private! Leave me alone.
		__requestId: 0,
		
		Temp: [],
		
		CallbackStack: [],
		
		QueueDefaults: { AutoSubmit: true, Timeout: 1000 },
		
		GenerateRequestId: function(){
			vc.__requestId++;
			return vc.__requestId + "m";
		},
		
		DisconnectionNotice: function(data){
			alert("There is a problem connecting to the server.\nPlease check your internet connection.");
		},
		
		ProcessCallbacks: function(data, textStatus, XMLHttpRequest){
			for(var x in data){
				if(vc.isInteger(x*1)){
					var method = vc.CallbackStack[data[x].Id];
					if (method !== undefined && typeof method.Method == "function"){
						var response = {};
						if(method.Data !== undefined){
							response = method.Data;
						}
						method.Method(data[x], response);
					}
					vc.CallbackStack.splice(data[x], 1);
				}
			}
		},
		
		SendSingleRequest: function(requestId, type, action, data){
			var dataObject = { Id: requestId, Type: type, Action: action, Data: data };
			var dataArray = [];
			dataArray[0] = dataObject;
			
			var dataToSend = JSON.stringify(dataArray);
			if(vc.CompressionMode == vc.COMPRESSION_MODE_jSEND){
        dataToSend = $.jSEND(dataToSend);
			}
			
			$.ajax({
				data: { Data: dataToSend } ,
				success: function(data, textStatus, XMLHttpRequest){
					vc.GlobalErrorCount = 0;
					vc.ProcessCallbacks(data, textStatus, XMLHttpRequest);
				},
				error: function(data, textStatus, XMLHttpRequest){
					if(textStatus == "timeout"){
						if(vc.GlobalErrorCount < 3){
							vc.SendSingleRequest(dataObject.Id, dataObject.Type, dataObject.Action, dataObject.Data);
							vc.GlobalErrorCount++;
						}else{
							vc.DisconnectionNotice(dataObject);
						}
					}else{
						vc.ProcessCallbacks({"0": { Result:vc.ER_SERVERERROR, Id: dataObject.Id, Data: {} }}, textStatus, XMLHttpRequest);
					}
				}
			});
		},
		
		SendQueue: function(queue){
			var dataToSend = JSON.stringify(queue.Items);
			if(vc.CompressionMode == vc.COMPRESSION_MODE_jSEND){
        dataToSend = $.jSEND(dataToSend);
			}
			
			$.ajax({
				data: {Data: dataToSend} ,
				success: function(data, textStatus, XMLHttpRequest){
					for(var x in queue){
            if(queue.hasOwnProperty(x)){
              vc.ProcessCallbacks(queue.Items[x], textStatus, XMLHttpRequest);
            }
					}
					
					queue.Items = [];
				}
			});
		},
		
		CheckVersion: function(callback){
			$.ajax({
				async: false,
				url: V2Core.STATICINFO_DIRECTORY + "version.txt",
				cache: false,
				success: function(responseText){
					callback(responseText);
			   }
			});
		},
		
		CalculateLevelRequiredExp: function(level){
			return Math.round(Math.pow(level+38.19, Math.log((level+38.19)*5)/Math.log(17-(level/150)))-829.53);
		},
		
		AlignName: function(character){
			var goodAlign = "";
			var orderAlign = "";
			if(character.AlignGood <= -100){
				goodAlign = "Evil ";
			}else if(character.AlignGood >= 100){
				goodAlign = "Good";
			}
			
			if(character.AlignOrder <= -100){
				orderAlign = "Chaotic";
			}else if(character.AlignOrder >= 100){
				orderAlign = "Ordered";
			}
			
			var totalAlign = "Neutral";

			if(goodAlign !== "" || orderAlign !== ""){
				var spacing = "";
				if(goodAlign !== ""){
					spacing = " ";
				}
				totalAlign = goodAlign + spacing + orderAlign;
			}
			
			return totalAlign;
		},
		
		isInteger: function(s) {
		  return (s.toString().search(/^-?[0-9]+$/) === 0);
		}
	};
	
	// in progress
	var Queue = function(options) {};
	Queue = Queue.prototype = function(options){
		this.Timeout = vc.QueueDefaults.Timeout;
		this.AutoSubmit = vc.QueueDefaults.AutoSubmit;
		
		if(options.Timeout !== undefined){
			this.Timeout = options.Timeout;
		}
		
		if(options.AutoSubmit !== undefined){
			this.AutoSubmit = options.AutoSubmit;
		}
		
		this.Items = [];
		
		this.AddItem = function(type, action, data, callback){
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			
			this.Items.push({ Id: requestId, Type: type, Action: action, Data: data });
		};
	};
	
	Queue.constructor = Queue;
	
	var Character = function() {};
	
	Character = Character.prototype = function(){ 
		this.CharacterId = "";
		this.HasPin = false;
		this.Name = "";
		this.CreatedOn = "";
		this.MapId = "";
		this.PositionX = 0;
		this.PositionY = 0;
		this.RaceId = 0;
		this.Gender = 0;
		this.AlignGood = 0;
		this.AlignOrder = 0;
		this.Level = 0;
		this.FreeLevels = 0;
		this.Experience = 0;
		this.Strength = 0;
		this.Dexterity = 0;
		this.Intelligence = 0;
		this.Wisdom = 0;
		this.Vitality = 0;
		this.Health = 0;
		this.Gold = 0;
		this.Bank = 0;
		this.CurrentChannel = "CHAN_00000000000000000000001";
		this.Channels = [];
		this.Inventories = [];
		this.Inventories["Personal"] = [];
		this.Equipment = [];
		
		this.CurrentMap = {};
		
		this.RaceName = function(){
			return V2Core.Races[this.RaceId].Name;
		};
		
		this.GenderName = function(){
			if(this.Gender === 0){
				return "Male";
			}else{
				return "Female";
			}
		};
		
		this.NextLevelAt = function(){
			return vc.CalculateLevelRequiredExp(this.Level+this.FreeLevels);
		};
		
		this.AlignName = function(){
			return vc.AlignName(this);
		};
		
		this.Construct = function(data){
			this.CharacterId = data.CharacterId;
			this.Bank = data.Bank;
			this.HasPin = data.HasPin;
			this.Name = data.Name;
			this.CreatedOn = data.CreatedOn;
			this.MapId = data.MapId;
			this.PositionX = data.PositionX;
			this.PositionY = data.PositionY;
			this.RaceId = data.RaceId;
			this.Gender = data.Gender;
			this.AlignGood = data.AlignGood;
			this.AlignOrder = data.AlignOrder;
			this.Level = data.Level;
			this.FreeLevels = data.FreeLevels;
			this.Experience = data.Experience;
			this.Strength = data.Strength;
			this.Dexterity = data.Dexterity;
			this.Intelligence = data.Intelligence;
			this.Wisdom = data.Wisdom;
			this.Vitality = data.Vitality;
			this.Health = data.Health;
			this.Gold = data.Gold;
			this.Channels = data.Channels;
			this.CurrentMap = V2Core.Maps[data.MapId];
			this.Equipment = data.Equipment;
			this.RacialVitality = data.RacialVitality;
			this.RacialStrength = data.RacialStrength;
			this.RacialDexterity = data.RacialDexterity;
			this.RacialWisdom = data.RacialWisdom;
			this.RacialIntelligence = data.RacialIntelligence;
		};
	};
	
	Character.prototype.constructor = Character;
	
	window.V2Core = window.vc = V2Core;
	window.Character = Character;
	window.Queue = Queue;
	
})(window);
