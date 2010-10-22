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
	window.ACTION_CREATE = 0;
	window.ACTION_LIST = 1;
	window.ACTION_CHECKNAME = 2;
	window.ACTION_SELECTCHARACTER = 3;
	
	var CharacterService = function (){};
	
	CharacterService = CharacterService.prototype = {
		Create: function(firstName, middleName, lastName, gender, pin, raceID, strength, dexterity, intelligence, wisdom, vitality, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Character.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CREATE, Data: JSON.stringify({ FirstName: firstName, MiddleName: middleName, LastName: lastName, Gender: gender, Pin: pin, RaceId: raceID, Strength: strength, Dexterity: dexterity, Intelligence: intelligence, Wisdom: wisdom, Vitality: vitality }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		List: function(callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Character.php",
				cache: true,
				type: "POST",
				data: { Action: ACTION_LIST, Data: JSON.stringify({}) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		CheckName: function(firstName, middleName, lastName, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Character.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_CHECKNAME, Data: JSON.stringify({ FirstName: firstName, MiddleName: middleName, LastName: lastName }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		},
		
		Select: function(characterId, pin, callback){
			$.ajax({
				url: SERVERCODE_DIRECTORY + "Character.php",
				cache: false,
				type: "POST",
				data: { Action: ACTION_SELECTCHARACTER, Data: JSON.stringify({ Character: characterId, Pin: pin }) },
				success: function(response){
					callback(JSON.parse(response));
			   }
			});
		}
	}
	
	V2Core.CharacterService = V2Core.cs = CharacterService;
})(window);