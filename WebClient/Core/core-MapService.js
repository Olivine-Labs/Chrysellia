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
		
		PLACE_TYPE_STORE: 0,
		PLACE_TYPE_BANK: 1,
		PLACE_TYPE_SHRINE: 2,
	
		Move: function(x, y, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Map.php",
				{ Action: MapService.ACTION_MOVE, Data: JSON.stringify({ X:x, Y:y }) },
				function(data) { callback(data); }
			);
		},
		
		Buy: function(itemTemplateId, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_BUY, Data: JSON.stringify({ ItemTemplateId: itemTemplateId }) },
				function(data) { callback(data); }
			);
		},
		
		Sell: function(itemId, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_SELL, Data: JSON.stringify({ ItemId: itemId }) },
				function(data) { callback(data); }
			);
		},
		
		Revive: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Places.php",
				{ Action: MapService.ACTION_REVIVE, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);