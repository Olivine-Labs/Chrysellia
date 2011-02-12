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
			"0":{
				"1": { Type: 0, Name: "General Store" },
				"3": { Type: 2, Name: "Central Bank of TestZone" }
			},
			"4":{
				"2": { Type: 1, Name: "Hospital"}
			},
		}
	}
	
	Maps["MAP_00000000000000000000002"] = { 
		Id: "MAP_00000000000000000000002", 
		Name: "Wilderness", 
		PVP: true,
		DimensionX: 180,
		DimensionY: 100,
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
			
		}
	}
	
	Maps["MAP_00000000001296788648248"] = { 
		Id: "MAP_00000000001296788648248", 
		Name: "Parlaor", 
		PVP: true,
		DimensionX: 32,
		DimensionY: 64,
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
			"28":{
				"25": { Type: 0, Name: "General Store" }
			},
			"1":{
				"25": { Type: 1, Name: "West Parlaor Hospital"}
			},
			"30":{
				"35": { Type: 1, Name: "East Parlaor Hospital" }
			},
			"4":{
				"25": { Type: 2, Name: "West Parlaor Armory"}
			},
			"27":{
				"25": { Type: 2, Name: "East Parlaor Armory" }
			}
		}
	}
	V2Core.Maps = Maps;
})(window);