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
		ACTION_BUY: 0,
		ACTION_SELL: 1,
		ACTION_REVIVE: 2,
	
		Move: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Map.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		},
		
		Buy: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		},
		
		Sell: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		},
		
		Revive: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);