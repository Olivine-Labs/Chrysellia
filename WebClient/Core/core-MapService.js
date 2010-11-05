/*!
 * V2 Account Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.ACTION_MOVE = 0;
	
	var MapService = function (){};
	
	MapService = MapService.prototype = {
		Move: function(x, y, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Map.php",
				{ Action: ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);