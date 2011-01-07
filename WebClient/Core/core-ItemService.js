/*!
 * V2 Item Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	
	var ItemService = function (){};
	
	ItemService = ItemService.prototype = {
		ACTION_GETINVENTORY: 0,
		ACTION_EQUIP: 1,
		ACTION_UNEQUIP: 2,
		ACTION_SEND_TRADE: 3,
		ACTION_ACCEPT_TRADE: 4,
		
		ITEM_TYPE_WEAPONS: 0,
		ITEM_TYPE_ARMOR: 1,
		ITEM_TYPE_ACCESSORIES: 2,
		ITEM_TYPE_SPELLS: 3,
		
		TypeMapping: ["Weapon", "Armor", "Accessory", "Spell"],
		
		GetInventory: function(callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Item.php",
				{ Action: ItemService.ACTION_GETINVENTORY, Data: JSON.stringify({ }) },
				function(data) { callback(data); }
			);
		},
	
		Equip: function(itemId, slotType, slot, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Item.php",
				{ Action: ItemService.ACTION_EQUIP, Data: JSON.stringify({ ItemId: itemId, SlotNumber: slot }) },
				function(data) { callback(data, itemId, slotType, slot); }
			);
		},
		
		UnEquip: function(itemId, slotType, slot, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Item.php",
				{ Action: ItemService.ACTION_UNEQUIP, Data: JSON.stringify({ ItemId: itemId }) },
				function(data) { callback(data, itemId, slotType, slot); }
			);
		},
		
		SendTrade: function(itemId, gold, playerName, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Item.php",
				{ Action: ItemService.ACTION_SEND_TRADE, Data: JSON.stringify({ ItemId: itemId, Gold: gold, Player: playerName }) },
				function(data) { callback(data); }
			);
		},
		
		AcceptTrade: function(tradeId, callback){
			$.getJSON(
				V2Core.SERVERCODE_DIRECTORY + "Item.php",
				{ Action: ItemService.ACTION_ACCEPT_TRADE, Data: JSON.stringify({ Trade: tradeId }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.ItemService = V2Core.is = ItemService;
})(window);