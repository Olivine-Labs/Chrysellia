(function( window, undefined ) {
	var Maps = new Array();
	
	Maps["MAP_00000000000000000000001"] = { 
		Id: "MAP_00000000000000000000001", 
		Name: "TestZone", 
		PVP: true,
		DimensionX: 5,
		DimensionY: 5,
		MinLevel: 0,
		MaxLevel: 99999999,
		MinAlign: -99999999,
		MaxAlign: 99999999,
		Monsters: {
			"Default": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
			"0": [],
			"1": [],
			"2": []
		},
		SpecialPlaces: {
			"1":{
				"0": { Type: 0, Name: "General Store" }
			},
			"2":{
				"4": { Type: 1, Name: "Hospital"}
			},
			"3":{
				"0": { Type: 2, Name: "Central Bank of TestZone" }
			}
		}
	}
	V2Core.Maps = Maps;
})(window);