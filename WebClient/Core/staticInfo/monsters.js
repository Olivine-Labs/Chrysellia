(function( window, undefined ) {
	var MonsterSpecialTypes = new Array();
	MonsterSpecialTypes[0] = "Normal";
	MonsterSpecialTypes[1] = "Merchant";
	MonsterSpecialTypes[2] = "Defender";
	MonsterSpecialTypes[3] = "Assassin";
	MonsterSpecialTypes[4] = "Leader";
	MonsterSpecialTypes[5] = "Elder";
	MonsterSpecialTypes[6] = "Veteran";
	MonsterSpecialTypes[7] = "Fanatic";
	MonsterSpecialTypes[8] = "Enigma";
	MonsterSpecialTypes[9] = "Saint";
	MonsterSpecialTypes[10] = "Demon";
	MonsterSpecialTypes[11] = "Judge";
	MonsterSpecialTypes[12] = "Anarchist";
	MonsterSpecialTypes[13] = "Fool";
	MonsterSpecialTypes[14] = "Illusionist";
	V2Core.MonsterSpecialTypes = MonsterSpecialTypes;
	
	var Monsters = new Array();
	
	Monsters["MONS_00000000000000000000001"] = { 
		Id: "MONS_00000000000000000000001", 
		Name: "Drunk Beggar",
		Level: 1
	},
	
	Monsters["MONS_00000000000000000000002"] = { 
		Id: "MONS_00000000000000000000002", 
		Name: "Street Urchin",
		Level: 2
	},
	
	Monsters["MONS_00000000000000000000003"] = { 
		Id: "MONS_00000000000000000000003", 
		Name: "Sly Peddler",
		Level: 3
	},
	
	Monsters["MONS_00000000000000000000004"] = { 
		Id: "MONS_00000000000000000000004", 
		Name: "Stray Dog",
		Level: 4
	},
	
	Monsters["MONS_00000000000000000000005"] = { 
		Id: "MONS_00000000000000000000005", 
		Name: "Cultist Initiate",
		Level: 5
	},
	
	Monsters["MONS_00000000000000000000006"] = { 
		Id: "MONS_00000000000000000000006", 
		Name: "Militia Volunteer",
		Level: 6
	},
	
	Monsters["MONS_00000000000000000000007"] = { 
		Id: "MONS_00000000000000000000007", 
		Name: "Murderous Cultist",
		Level: 7
	},
	
	Monsters["MONS_00000000000000000000008"] = { 
		Id: "MONS_00000000000000000000008", 
		Name: "Street Performer",
		Level: 8
	},
	
	Monsters["MONS_00000000000000000000009"] = { 
		Id: "MONS_00000000000000000000009", 
		Name: "Enticing Ladies",
		Level: 9
	},
	
	Monsters["MONS_00000000000000000000010"] = { 
		Id: "MONS_00000000000000000000010", 
		Name: "Novice Assassin",
		Level: 10
	},
	
	Monsters["MONS_00000000000000000000011"] = { 
		Id: "MONS_00000000000000000000011", 
		Name: "Street Brawler",
		Level: 11
	},
	
	Monsters["MONS_00000000000000000000012"] = { 
		Id: "MONS_00000000000000000000012", 
		Name: "Hired Thug",
		Level: 12
	}
	
	V2Core.Monsters = Monsters;
})(window);