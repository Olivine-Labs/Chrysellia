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
			
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_CREATE, data).success( function(data) { callback(data); } );
		},
		
		List: function(callback){
			var data = { };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_LIST, data).success( function(data) { callback(data); } );
		},
		
		CheckName: function(name, callback){
			var data = { Name: name };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_CHECKNAME, data).success( function(data) { callback(data); } );
		},
		
		Select: function(characterId, pin, callback){
			var data = { Character: characterId, Pin: pin };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_SELECTCHARACTER, data).success( function(data) { callback(data); } );
		},
		
		GetCurrentCharacter: function(callback){
			var data = { };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_GETCURRENTCHARACTER, data).success( function(data) { callback(data); } );
		},
		
		LevelUp: function(stat, callback){
			var data = { Stat: stat };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_LEVELUP, data).success( function(data) { callback(data, stat); } );
		},
		
		PlayerListByLocation: function(callback){
			var data = { };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_LOADLISTFORCELL, data).success( function(data) { callback(data); } );
		},
		
		Fight: function(enemyId, fightType, callback){
			var data = { CharacterId: enemyId, FightType: fightType };
			vc.SendQueuedRequest(vc.TYPE_CHARACTER, vc.cs.ACTION_FIGHT, data).success( function(data) { callback(data); } );
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);