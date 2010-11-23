/*!
 * V2 Item Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	window.EQUIP = 0;
	window.UNEQUIP = 1;
	window.SENDTRADE = 2;
	window.ACCEPTTRADE = 3;
	
	var ItemService = function (){};
	
	ItemService = ItemService.prototype = {
		Equip: function(itemId, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Items.php",
				{ Action: EQUIP, Data: JSON.stringify({ Item: itemId }) },
				function(data) { callback(data); }
			);
		},
		
		UnEquip: function(itemId, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Items.php",
				{ Action: UNEQUIP, Data: JSON.stringify({ Item: itemId }) },
				function(data) { callback(data); }
			);
		},
		
		SendTrade: function(tradeId, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Items.php",
				{ Action: SENDTRADE, Data: JSON.stringify({ Trade: tradeId }) },
				function(data) { callback(data); }
			);
		},
		
		AcceptTrade: function(tradeId, callback){
			$.getJSON(
				SERVERCODE_DIRECTORY + "Items.php",
				{ Action: ACCEPTTRADE, Data: JSON.stringify({ Trade: tradeId }) },
				function(data) { callback(data); }
			);
		},
	}
	
	V2Core.ItemService = V2Core.is = ItemService;
})(window);