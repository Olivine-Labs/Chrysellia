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
	
		Create: function(name, gender, pin, raceID, strength, dexterity, intelligence, wisdom, vitality, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_CREATE, Data: JSON.stringify({ Name: name, Gender: gender, Pin: pin, RaceId: raceID, Strength: strength, Dexterity: dexterity, Intelligence: intelligence, Wisdom: wisdom, Vitality: vitality }) },
				function(data) { callback(data); }
			);
		},
		
		List: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_LIST, Data: JSON.stringify({}) },
				function(data) { callback(data); }
			);
		},
		
		CheckName: function(name, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_CHECKNAME, Data: JSON.stringify({ Name: name }) },
				function(data) { callback(data); }
			);
		},
		
		Select: function(characterId, pin, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_SELECTCHARACTER, Data: JSON.stringify({ Character: characterId, Pin: pin }) },
				function(data) { callback(data); }
			);
		},
		
		GetCurrentCharacter: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_GETCURRENTCHARACTER, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		},
		
		LevelUp: function(stat, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_LEVELUP, Data: JSON.stringify({ Stat: stat }) },
				function(data) { callback(data, stat); }
			);
		},
		
		PlayerListByLocation: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Character.php",
				{ Action: CharacterService.ACTION_LOADLISTFORCELL, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);