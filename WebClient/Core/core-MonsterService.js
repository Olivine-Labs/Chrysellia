/*!
 * V2 Monster Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	
	var MonsterService = function (){};
	
	MonsterService = MonsterService.prototype = {
		ACTION_FIGHT: 0,
		
		Fight: function(monsterId, fightType, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Monster.php",
				{ Action: MonsterService.ACTION_FIGHT, Data: JSON.stringify({ MonsterId: monsterId, FightType: fightType }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.MonsterService = V2Core.mn = MonsterService;
})(window);