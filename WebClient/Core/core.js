/*!
 * V2 Core Library 0.0.1 rev 01
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 * Date: Tue Oct 12 08:22:00 [-0500]
 *
 * Dependencies: jQuery Core
 */
 
 (function( window, undefined ) {
	window.ER_SUCCESS = 0; //when Murphy is not around everything works.
	window.ER_BADDATA = 251; //when the data is bad
	window.ER_ALREADYEXISTS = 252; //when the data already exists in the database
	window.ER_MALFORMED = 253; //when a post/get is malformed for the function requested
	window.ER_DBERROR = 254; //when the database fails
	window.ER_ACCESSDENIED = 255; //when they just don't have access.
	window.SERVERCODE_DIRECTORY = "./Server/";
	window.STATICINFO_DIRECTORY = "./Core/StaticInfo/";

	var V2Core = function (){};
	
	V2Result = {};
	V2Result = V2Result.prototype = {
		Result: 0,
		Data: {}
	};
	
	V2Core = V2Core.prototype = {
		Version: "0.0.1",
		CurrentLanguage: "en",
		
		CheckVersion: function(callback){
			$.ajax({
				async: false,
				url: STATICINFO_DIRECTORY + "version.txt",
				cache: false,
				success: function(responseText){
					callback(responseText);
			   }
			});
		}
	};
	
	window.V2Core = window.vc = V2Core;
	
})(window);