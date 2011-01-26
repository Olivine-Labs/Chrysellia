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
		ACTION_CHANGEMAP: 1,
		
		ACTION_BUY: 0,
		ACTION_SELL: 1,
		ACTION_REVIVE: 2,
		ACTION_WITHDRAW: 3,
		ACTION_DEPOSIT: 4,
		ACTION_TRANSFER: 5,
		
		PLACE_TYPE_STORE: 0,
		PLACE_TYPE_BANK: 1,
		PLACE_TYPE_SHRINE: 2,
	
		Move: function(x, y, callback){
			var data = { X:x, Y:y };
			vc.SendSingleRequest(vc.TYPE_MAP, vc.ms.ACTION_MOVE, data).success( function(data) { callback(data); } );
		},
		
		ChangeMap: function(callback){
			var data = { };
			vc.SendSingleRequest(vc.TYPE_MAP, vc.ms.ACTION_CHANGEMAP, data).success( function(data) { callback(data); } );
		},
		
		Buy: function(itemTemplateId, callback){
			var data = { ItemTemplateId: itemTemplateId };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_BUY, data).success( function(data) { callback(data); } );
		},
		
		Sell: function(itemId, callback){
			var data = { ItemId: itemId };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_SELL, data).success( function(data) { callback(data, itemId); } );
		},
		
		Revive: function(callback){
			var data = { };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_REVIVE, data).success( function(data) { callback(data); } );
		},
		
		Widthdraw: function(gold, callback){
			var data = { Gold: gold };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_WITHDRAW, data).success( function(data) { callback(data, gold, 1); } );
		},
		
		Deposit: function(gold, callback){
			var data = { Gold: gold };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_DEPOSIT, data).success( function(data) { callback(data, gold, 0); } );
		},
		
		Transfer: function(gold, name, callback){
			var data = { Gold: gold };
			vc.SendSingleRequest(vc.TYPE_PLACES, vc.ms.ACTION_TRANSFER, data).success( function(data) { callback(data, gold); } );
		}
	}
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);