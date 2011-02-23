/*!
 * V2 Character Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
;(function( window, undefined ) {
	
	var CharacterService = function (){};
	
	CharacterService = CharacterService.prototype = {
		ACTION_CREATE: 0,
		ACTION_LIST: 1,
		ACTION_CHECKNAME: 2,
		ACTION_SELECTCHARACTER: 3,
		ACTION_GETCURRENTCHARACTER: 4,
		ACTION_LEVELUP: 5,
		ACTION_LOADLISTFORCELL: 6,
		ACTION_FIGHT: 7,
	
		Create: function(name, gender, pin, raceID, strength, dexterity, intelligence, wisdom, vitality, callback){
			var data = { 
				Name: name, 
				Gender: gender, 
				Pin: pin, 
				RaceId: raceID, 
				Strength: strength, 
				Dexterity: dexterity, 
				Intelligence: intelligence, 
				Wisdom: wisdom, 
				Vitality: vitality 
			};
			
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_CREATE, data);
		},
		
		List: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_LIST, data);
		},
		
		CheckName: function(name, callback){
			var data = { Name: name };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_CHECKNAME, data);
		},
		
		Select: function(characterId, pin, callback){
			var data = { Character: characterId, Pin: pin };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_SELECTCHARACTER, data);
		},
		
		GetCurrentCharacter: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_GETCURRENTCHARACTER, data);
		},
		
		LevelUp: function(stat, callback){
			var data = { Stat: stat };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_LEVELUP, data);
		},
		
		PlayerListByLocation: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_LOADLISTFORCELL, data);
		},
		
		Fight: function(enemyId, fightType, callback){
			var data = { CharacterId: enemyId, FightType: fightType };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_FIGHT, data);
		},
		
		
		CalculateAlignColor: function(AlignGood, AlignOrder){
			
			var red = [214, 192, 192, 107, 0]; //good, evil, ordered, chaotic, neutral
			var green = [214, 0, 192, 36, 170];
			var blue = [51, 0, 192, 178, 238];
				
			var ResultRed = red[4].toString(16);
			var ResultGreen = green[4].toString(16);
			var ResultBlue = blue[4].toString(16)
			
			if(AlignGood > 99 || AlignGood < -99 || AlignOrder > 99 || AlignOrder < -99 ) {
				var Color1Red = red[4];
				var Color1Green = green[4];
				var Color1Blue = blue[4];
				
				var Color2Red = red[4];
				var Color2Green = green[4];
				var Color2Blue = blue[4];
			
				if(AlignGood > 99 ) {
					Color1Red = red[0];
					Color1Green = green[0];
					Color1Blue = blue[0];
				} else if(AlignGood < -99 ) {
					Color1Red = red[1];
					Color1Green = green[1];
					Color1Blue = blue[1];
				}
				
				if(AlignOrder > 99 ) {
					Color2Red = red[2];
					Color2Green = green[2];
					Color2Blue = blue[2];
				} else if(AlignOrder < -99 ) {
					Color2Red = red[3];
					Color2Green = green[3];
					Color2Blue = blue[3];
				}else {
					Color2Red = Color1Red;
					Color2Green = Color1Green;
					Color2Blue = Color1Blue;
				}
			
				
				var RatioGoodOrder = Math.abs(AlignGood) / (Math.abs(AlignOrder) + Math.abs(AlignGood));
				var RatioOrderGood = Math.abs(AlignOrder) / (Math.abs(AlignOrder) + Math.abs(AlignGood));
				
				ResultRed = ((Color2Red * RatioOrderGood) + (Color1Red * RatioGoodOrder)) >> 1 << 1;
				ResultGreen = ((Color2Green * RatioOrderGood) + (Color1Green * RatioGoodOrder)) >> 1 << 1;
				ResultBlue = ((Color2Blue * RatioOrderGood) + (Color1Blue * RatioGoodOrder)) >> 1 << 1;
				
				ResultRed = ResultRed.toString(16);
				ResultGreen = ResultGreen.toString(16);
				ResultBlue = ResultBlue.toString(16);
			}
			
			if(ResultRed == 0){
				ResultRed = "00";
			}
			
			if(ResultGreen == 0){
				ResultGreen = "00";
			}
			
			if(ResultBlue == 0){
				ResultBlue = "00";
			}
			
			return ResultRed + "" + ResultGreen + "" + ResultBlue;
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);