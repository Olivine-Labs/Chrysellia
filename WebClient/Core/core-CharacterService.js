/*!
 * V2 Character Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	
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
			
			vc.SendSingleRequest(requestId, requestId, vc.TYPE_CHARACTER, vc.cs.ACTION_CREATE, data);
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
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);