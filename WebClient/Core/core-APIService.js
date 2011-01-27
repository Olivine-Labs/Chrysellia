/*!
 * V2 API Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
(function( window, undefined ) {
	
	var APIService = function (){};
	
	APIService = APIService.prototype = {
		ACTION_TOP: 0,
		ACTION_COUNT: 1,
		ACTION_ONLINE: 2,
	
		GetTops: function(limit, index, sort, listType, race, callback){
			var data = { Action: APIService.ACTION_TOP, Data: { Num: limit, Position: index, Sort: sort, ListType: listType, Race: race }};
			var dataToSend = JSON.stringify(data);
			switch(vc.CompressionMode){
				case vc.COMPRESSION_MODE_jSEND:
					dataToSend = $.jSEND(datatoSend);
					break;
			}
			
			$.getJSON(
				vc.API_URI,
				{Data: dataToSend},
				function(data) { callback(data[0]); }
			);
		},
		
		Count: function(callback){
			var data = { Action: vc.api.ACTION_TOP };
			var dataToSend = JSON.stringify(data);
			switch(vc.CompressionMode){
				case vc.COMPRESSION_MODE_jSEND:
					dataToSend = $.jSEND(datatoSend);
					break;
			}
			
			$.getJSON(
				vc.API_URI,
				{ Data: dataToSend },
				function(data) { callback(data[0]); }
			);
		},
		
		Online: function(callback){
			var data = { Action: vc.api.ACTION_ONLINE };
			var dataToSend = JSON.stringify(data);
			switch(vc.CompressionMode){
				case vc.COMPRESSION_MODE_jSEND:
					dataToSend = $.jSEND(datatoSend);
					break;
			}
			
			$.getJSON(
				vc.API_URI,
				{Data: dataToSend },
				function(data) { callback(data[0]); }
			);
		}
	}
	
	V2Core.APIService = V2Core.api = APIService;
})(window);