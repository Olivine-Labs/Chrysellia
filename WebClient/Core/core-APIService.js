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
			$.getJSON(
				vc.API_URI,
				//{ Action: APIService.ACTION_TOP, Data: JSON.stringify({ Num: limit, Position: index, Sort: sort }) },
				{ Action: APIService.ACTION_TOP, Data: JSON.stringify({ Num: limit, Position: index, Sort: sort, ListType: listType, Race: race }) },
				function(data) { callback(data); }
			);
		},
		
		Count: function(callback){
			$.getJSON(
				vc.API_URI,
				{ Action: APIService.ACTION_COUNT, Data: JSON.stringify({  }) },
				function(data) { callback(data); }
			);
		},
		
		Online: function(callback){
			$.getJSON(
				vc.API_URI,
				{ Action: APIService.ACTION_ONLINE, Data: JSON.stringify({  }) },
				function(data) { callback(data); }
			);
		}
	}
	
	V2Core.APIService = V2Core.api = APIService;
})(window);