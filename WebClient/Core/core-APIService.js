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
				{Data: $.jSEND(JSON.stringify({ Action: APIService.ACTION_TOP, Data: { Num: limit, Position: index, Sort: sort, ListType: listType, Race: race } }))},
				function(data) { callback(data[0]); }
			);
		},
		
		Count: function(callback){
			$.getJSON(
				vc.API_URI,
				{Data: $.jSEND(JSON.stringify({ Action: APIService.ACTION_COUNT, Data: {  } }))},
				function(data) { callback(data[0]); }
			);
		},
		
		Online: function(callback){
			$.getJSON(
				vc.API_URI,
				{Data: $.jSEND(JSON.stringify({ Action: APIService.ACTION_ONLINE, Data: {  } }))},
				function(data) { callback(data[0]); }
			);
		}
	}
	
	V2Core.APIService = V2Core.api = APIService;
})(window);