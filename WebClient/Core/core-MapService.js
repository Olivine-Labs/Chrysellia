/*!
 * V2 Account Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	
	var MapService = function (){};
	
	MapService = MapService.prototype = {
		ACTION_MOVE: 0,
	
		Move: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Map.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);