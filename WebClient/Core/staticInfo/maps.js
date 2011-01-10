(function( window, undefined ) {
	var Maps = new Array();
	
	Maps["MAP_00000000000000000000001"] = { 
		Id: "MAP_00000000000000000000001", 
		Name: "Test", 
		PVP: true,
		DimensionX: 5,
		DimensionY: 5,
		MinLevel: 0,
		MaxLevel: 99999999,
		MinAlign: -99999999,
		MaxAlign: 99999999,
		Places: 
		[	
			[
				{ Monsters: ["MONS_00000000000000000000001", "MONS_00000000000000000000002", "MONS_00000000000000000000003", "MONS_00000000000000000000004", "MONS_00000000000000000000005"] },
				{ },
				{},
				{},
				{}
			],
			[
				{ Type: 0, Name: "Test General Store" },
				{},
				{},
				{},
				{}
			],[
				{},
				{},
				{},
				{},
				{ Type: 1, Name: "Test Shriners Hospital"}
			],[
				{ Type: 2, Name: "Central Bank of Test" },
				{},
				{},
				{},
				{}
			],[
				{},
				{},
				{},
				{},
				{}
			]
		]
	}	
	V2Core.Maps = Maps;
})(window);