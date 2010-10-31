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
 
 (function( window, undefined ) {
	window.ER_SUCCESS = 0; //when Murphy is not around everything works.
	window.ER_BADDATA = 251; //when the data is bad
	window.ER_ALREADYEXISTS = 252; //when the data already exists in the database
	window.ER_MALFORMED = 253; //when a post/get is malformed for the function requested
	window.ER_DBERROR = 254; //when the database fails
	window.ER_ACCESSDENIED = 255; //when they just don't have access.
	window.SERVERCODE_DIRECTORY = "./Server/";
	window.STATICINFO_DIRECTORY = "./Core/StaticInfo/";

	var V2Core = function (){};
	
	var V2Result = {};
	V2Result = V2Result.prototype = {
		Result: 0,
		Data: {}
	};
	
	V2Core = V2Core.prototype = {
		Version: "0.0.1",
		CurrentLanguage: "en",
		
		CheckVersion: function(callback){
			$.ajax({
				async: false,
				url: STATICINFO_DIRECTORY + "version.txt",
				cache: false,
				success: function(responseText){
					callback(responseText);
			   }
			});
		}
	};
	
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
		this.CurrentChannel = "CHAN_00000000000000000000001";
		
		this.Channels = new Array();
		this.Channels["CHAN_00000000000000000000001"] = "General";
		this.Channels["CHAN_00000000000000000000002"] = "Trade";
		
		this.RaceName = function(){
			return window.Races[this.RaceId].Name;
		}
		
		this.ZoneName = function(){
			
		}
		
		this.GenderName = function(){
			if(this.Gender == 0){
				return "Male";
			}else{
				return "Female";
			}
		}
		
		this.AlignName = function(){
			var goodAlign = "";
			var orderAlign = "";
			if(this.AlignGood <= -100){
				goodAlign = "Evi ";
			}else if(this.AlignGood >= 100){
				goodAlign = "Good";
			}
			
			if(this.AlignOrder <= -100){
				orderAlign = "Chaotic";
			}else if(this.AlignOrder >= 100){
				orderAlign = "Ordered";
			}
			
			var spacing = "";
			if(goodAlign != ""){
				spacing = " ";
			}
			return goodAlign + spacing + orderAlign;
		}
		
		this.Construct = function(data){
			this.CharacterId = data.CharacterId;
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
		}
	}
	
	Character.prototype.constructor = Character;
	
	window.V2Core = window.vc = V2Core;
	window.Character = Character;
	
})(window);