(function( window, undefined ) {
	var Races = new Array();

	Races["RACE_00000000000000000000001"] = { 
		Id: "RACE_00000000000000000000001", 
		Name: "Aviakan", 
		Str: 22, 
		Dex: 24, 
		Int: 30, 
		Wis: 28, 
		Vit: 21, 
		StrMax: 42, 
		DexMax: 44, 
		IntMax: 50, 
		WisMax: 48, 
		VitMax: 41, 
		Portrait: "aviakan", 
		Align: "good",
		Description: "A flying race with strengths in sword and lightning."
	}
	
	Races["RACE_00000000000000000000002"] = { 
		Id: "RACE_00000000000000000000002", 
		Name: "Drow", 
		Str: 30, 
		Dex: 33, 
		Int: 20, 
		Wis: 25, 
		Vit: 17, 
		StrMax: 50, 
		DexMax: 53, 
		IntMax: 40, 
		WisMax: 45, 
		VitMax: 37, 
		Align: "evil",
		Description: "An evil elf-like race with sword and darkness mastery."
	}
	
	Races["RACE_00000000000000000000003"] = { 
		Id: "RACE_00000000000000000000003", 
		Name: "Dwarf", 
		Str: 33, 
		Dex: 25, 
		Int: 20, 
		Wis: 19, 
		Vit: 28, 
		StrMax: 53, 
		DexMax: 45, 
		IntMax: 40, 
		WisMax: 39, 
		VitMax: 48, 
		Align: "good",
		Description: "A stout race with excellent axe and fire skills."
	}
	
	Races["RACE_00000000000000000000004"] = { 
		Id: "RACE_00000000000000000000004", 
		Name: "Elf", 
		Str: 30, 
		Dex: 25, 
		Int: 30, 
		Wis: 23, 
		Vit: 17, 
		StrMax: 50, 
		DexMax: 45, 
		IntMax: 50, 
		WisMax: 40, 
		VitMax: 37, 
		Align: "good",
		Description: "A lithe and agile race with legendary marksmanship and light magic knowledge."
	}
	
	Races["RACE_00000000000000000000005"] = { 
		Id: "RACE_00000000000000000000005", 
		Name: "Gargoyle", 
		Str: 33, 
		Dex: 18, 
		Int: 27, 
		Wis: 27, 
		Vit: 20, 
		StrMax: 53, 
		DexMax: 33, 
		IntMax: 42, 
		WisMax: 57, 
		VitMax: 40, 
		Align: "evil",
		Description: "A grotesque creature, very powerful in magic- especially lightning."
	}
	
	Races["RACE_00000000000000000000006"] = { 
		Id: "RACE_00000000000000000000006", 
		Name: "Half Elf", 
		Str: 30, 
		Dex: 24, 
		Int: 24, 
		Wis: 25, 
		Vit: 22, 
		StrMax: 50, 
		DexMax: 44, 
		IntMax: 40, 
		WisMax: 45, 
		VitMax: 37, 
		Align: "good",
		Description: "A combination of two races, strong with maces and wind magic."
	}
	
	Races["RACE_00000000000000000000007"] = { 
		Id: "RACE_00000000000000000000007", 
		Name: "Human", 
		Str: 22, 
		Dex: 37, 
		Int: 33, 
		Wis: 13, 
		Vit: 20, 
		StrMax: 42, 
		DexMax: 57, 
		IntMax: 53, 
		WisMax: 33, 
		VitMax: 40, 
		Align: "good",
		Description: "An intelligent and dextrous race with specialization in swords and fire."
	}
	
	Races["RACE_00000000000000000000008"] = { 
		Id: "RACE_00000000000000000000008", 
		Name: "Orc", 
		Str: 30, 
		Dex: 28, 
		Int: 22, 
		Wis: 24, 
		Vit: 21, 
		StrMax: 50, 
		DexMax: 48, 
		IntMax: 42, 
		WisMax: 44, 
		VitMax: 41, 
		Align: "evil",
		Description: "A well-rounded race versed in axes and cold magic."
	}
	
	Races["RACE_00000000000000000000009"] = { 
		Id: "RACE_00000000000000000000009", 
		Name: "Troll", 
		Str:30, 
		Dex: 28, 
		Int: 20, 
		Wis: 22, 
		Vit: 25, 
		StrMax: 50, 
		DexMax: 48, 
		IntMax: 40, 
		WisMax: 44, 
		VitMax: 45, 
		Align: "evil",
		Description: "A strong creature traditionall wielding clubs and using wind magic."
	}
	
	Races["RACE_00000000000000000000010"] = { 
		Id: "RACE_00000000000000000000010", 
		Name: "Goblin", 
		Str: 20, 
		Dex: 19, 
		Int: 33, 
		Wis: 25, 
		Vit: 28, 
		StrMax: 40, 
		DexMax: 39, 
		IntMax: 53, 
		WisMax: 45, 
		VitMax: 48, 
		Align: "evil",
		Description: "A small creature with high intelligence and wisdom, with strengths in hammers and fire."
	}

	V2Core.Races = Races;
})(window);