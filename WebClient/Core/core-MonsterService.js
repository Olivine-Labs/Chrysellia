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
			var data = { MonsterId: monsterId, FightType: fightType };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = callback;
			vc.SendSingleRequest(requestId, vc.TYPE_MONSTER, vc.mn.ACTION_FIGHT, data);
		}
	}
	
	V2Core.MonsterService = V2Core.mn = MonsterService;
})(window);