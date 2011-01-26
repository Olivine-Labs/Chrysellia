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
			var data = { };
			vc.SendQueuedRequest(vc.TYPE_ITEM, vc.is.ACTION_GETINVENTORY, data).success( function(data) { callback(data); } );
		},
	
		Equip: function(itemId, slotType, slot, callback){
			var data = { ItemId: itemId, SlotNumber: slot };
			vc.SendQueuedRequest(vc.TYPE_ITEM, vc.is.ACTION_EQUIP, data).success( function(data) { callback(data, itemId, slotType, slot); } );
		},
		
		UnEquip: function(itemId, slotType, slot, callback){
			var data = { ItemId: itemId };
			vc.SendQueuedRequest(vc.TYPE_ITEM, vc.is.ACTION_UNEQUIP, data).success( function(data) { callback(data, itemId, slotType, slot); } );
		},
		
		SendTrade: function(itemId, gold, playerName, callback){
			var data = { ItemId: itemId, Gold: gold, Player: playerName };
			vc.SendQueuedRequest(vc.TYPE_ITEM, vc.is.ACTION_SEND_TRADE, data).success( function(data) { callback(data); } );
		},
		
		AcceptTrade: function(tradeId, callback){
			var data = { Trade: tradeId };
			vc.SendQueuedRequest(vc.TYPE_ITEM, vc.is.ACTION_ACCEPT_TRADE, data).success( function(data) { callback(data); } );
		}
	}
	
	V2Core.ItemService = V2Core.is = ItemService;
})(window);