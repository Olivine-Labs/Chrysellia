/*!
 * V2 Character Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.ACTION_CREATE = 0;
	window.ACTION_LIST = 1;
	window.ACTION_CHECKNAME = 2;
	window.ACTION_SELECTCHARACTER = 3;
	window.ACTION_GETCURRENTCHARACTER = 4;
	
	var CharacterService = function (){};
	
	CharacterService = CharacterService.prototype = {
		Create: function(name, gender, pin, raceID, strength, dexterity, intelligence, wisdom, vitality, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Character.php",
				{ Action: ACTION_CREATE, Data: JSON.stringify({ Name: name, Gender: gender, Pin: pin, RaceId: raceID, Strength: strength, Dexterity: dexterity, Intelligence: intelligence, Wisdom: wisdom, Vitality: vitality }) },
				function(data) { callback(data); }
			);
		},
		
		List: function(callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Character.php",
				{ Action: ACTION_LIST, Data: JSON.stringify({}) },
				function(data) { callback(data); }
			);
		},
		
		CheckName: function(firstName, middleName, lastName, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Character.php",
				{ Action: ACTION_CHECKNAME, Data: JSON.stringify({ FirstName: firstName, MiddleName: middleName, LastName: lastName }) },
				function(data) { callback(data); }
			);
		},
		
		Select: function(characterId, pin, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Character.php",
				{ Action: ACTION_SELECTCHARACTER, Data: JSON.stringify({ Character: characterId, Pin: pin }) },
				function(data) { callback(data); }
			);
		},
		
		GetCurrentCharacter: function(callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Character.php",
				{ Action: ACTION_GETCURRENTCHARACTER, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);