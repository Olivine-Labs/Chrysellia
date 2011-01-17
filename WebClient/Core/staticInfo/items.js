(function( window, undefined ) {
	var ItemTypes = new Array(
		[], // 0?
		[], // 2?
		[	// Equippables
			[	//SlotType: Weapons
				 { ItemId: "ITEM_00000000000000000000000", Name: "Dagger", Description: "A small dagger, a class 0 sword", BuyPrice: 50, SellPrice: 25, ItemClass: 0, Type: 2, MasteryType: 1, ItemClass: 0, Sockets: 1}
				,{ ItemId: "ITEM_00000000000000000000001", Name: "Short Sword", Description: "Sword IC 1", BuyPrice: 85, SellPrice: 43, ItemClass: 1, Type: 2, MasteryType: 1, ItemClass: 0, Sockets: 1}
				,{ ItemId: "ITEM_00000000000000000000002", Name: "Demon's Nail", Description: "Sword IC 2", BuyPrice: 144, SellPrice: 72, ItemClass: 2, Type: 2, MasteryType: 1, ItemClass: 0, Sockets: 1}
				,{ ItemId: "ITEM_00000000000000000000003", Name: "Scimitar", Description: "Sword IC 3", BuyPrice: 246, SellPrice: 123, ItemClass: 3, Type: 2, MasteryType: 1, ItemClass: 0, Sockets: 1}
				,{ ItemId: "ITEM_00000000000000000000004", Name: "Lamprey", Description: "Sword IC 4", BuyPrice: 418, SellPrice: 209, ItemClass: 0, Type: 2, MasteryType: 1, ItemClass: 4, Sockets: 1}
				,{ ItemId: "ITEM_00000000000000000000005", Type: 2, MasteryType: 1, ItemClass: 5, Sockets: 1, Name: "Sabre", Description: "Sword IC 5", BuyPrice: 710, SellPrice: 355 }
				,{ ItemId: "ITEM_00000000000000000000006", Type: 2, MasteryType: 1, ItemClass: 6, Sockets: 1, Name: "Falchion", Description: "Sword IC 6", BuyPrice: 1207, SellPrice: 604 }
				,{ ItemId: "ITEM_00000000000000000000007", Type: 2, MasteryType: 1, ItemClass: 7, Sockets: 1, Name: "Long Sword", Description: "Sword IC 7", BuyPrice: 2052, SellPrice: 1026 }
				,{ ItemId: "ITEM_00000000000000000000008", Type: 2, MasteryType: 1, ItemClass: 8, Sockets: 1, Name: "Gladius", Description: "Sword IC 8", BuyPrice: 3488, SellPrice: 1744 }
				,{ ItemId: "ITEM_00000000000000000000009", Type: 2, MasteryType: 1, ItemClass: 9, Sockets: 1, Name: "Cutlass", Description: "Sword IC 9", BuyPrice: 5929, SellPrice: 2965 }
				,{ ItemId: "ITEM_00000000000000000000010", Type: 2, MasteryType: 1, ItemClass: 10, Sockets: 1, Name: "Battle Sword", Description: "Sword IC 10", BuyPrice: 10080, SellPrice: 5040 }
				,{ ItemId: "ITEM_00000000000000000000011", Type: 2, MasteryType: 1, ItemClass: 11, Sockets: 1, Name: "War Sword", Description: "Sword IC 11", BuyPrice: 17136, SellPrice: 8568 }
				,{ ItemId: "ITEM_00000000000000000000012", Type: 2, MasteryType: 1, ItemClass: 12, Sockets: 1, Name: "Broad Sword", Description: "Sword IC 12", BuyPrice: 29131, SellPrice: 14566 }
				,{ ItemId: "ITEM_00000000000000000000013", Type: 2, MasteryType: 1, ItemClass: 13, Sockets: 1, Name: "Crystal Sword", Description: "Sword IC 13", BuyPrice: 49523, SellPrice: 24762 }
				,{ ItemId: "ITEM_00000000000000000000014", Type: 2, MasteryType: 1, ItemClass: 14, Sockets: 1, Name: "Rune Sword", Description: "Sword IC 14", BuyPrice: 84189, SellPrice: 42095 }
				,{ ItemId: "ITEM_00000000000000000000015", Type: 2, MasteryType: 1, ItemClass: 15, Sockets: 1, Name: "Tusk Sword", Description: "Sword IC 15", BuyPrice: 143121, SellPrice: 71561 }
				,{ ItemId: "ITEM_00000000000000000000016", Type: 2, MasteryType: 1, ItemClass: 16, Sockets: 1, Name: "Jataghan", Description: "Sword IC 16", BuyPrice: 243306, SellPrice: 121653 }
				,{ ItemId: "ITEM_00000000000000000000017", Type: 2, MasteryType: 1, ItemClass: 17, Sockets: 1, Name: "Claymore", Description: "Sword IC 17", BuyPrice: 413620, SellPrice: 206810 }
				,{ ItemId: "ITEM_00000000000000000000018", Type: 2, MasteryType: 1, ItemClass: 18, Sockets: 1, Name: "Dragonslayer", Description: "Sword IC 18", BuyPrice: 703154, SellPrice: 351577 }
				
			],
			[	//SlotType: Armors
				 { ItemId: "ITEM_00000000000000000000022", Name: "Clothes", Description: "Simple clothing", BuyPrice: 50, SellPrice: 25, ItemClass: 0, Type: 2, MasteryType: 0, ItemClass: 0, Sockets: 1 }
				,{ ItemId: "ITEM_00000000000000000000023", Type: 2, MasteryType: 0, ItemClass: 1, Sockets: 1, Name: "Wool Cloak", Description: "Armor IC 1", BuyPrice: 85, SellPrice: 43 }
				,{ ItemId: "ITEM_00000000000000000000024", Type: 2, MasteryType: 0, ItemClass: 2, Sockets: 1, Name: "Leather Armor", Description: "Armor IC 2", BuyPrice: 144, SellPrice: 72 }
				,{ ItemId: "ITEM_00000000000000000000025", Type: 2, MasteryType: 0, ItemClass: 3, Sockets: 1, Name: "Padded Leather Armor", Description: "Armor IC 3", BuyPrice: 246, SellPrice: 123 }
				,{ ItemId: "ITEM_00000000000000000000026", Type: 2, MasteryType: 0, ItemClass: 4, Sockets: 1, Name: "Studded Leather Armor", Description: "Armor IC 4", BuyPrice: 418, SellPrice: 209 }
				,{ ItemId: "ITEM_00000000000000000000027", Type: 2, MasteryType: 0, ItemClass: 5, Sockets: 1, Name: "Chainmail Armor", Description: "Armor IC 5", BuyPrice: 710, SellPrice: 355 }
				,{ ItemId: "ITEM_00000000000000000000028", Type: 2, MasteryType: 0, ItemClass: 6, Sockets: 1, Name: "Linked Armor", Description: "Armor IC 6", BuyPrice: 1207, SellPrice: 604 }
				,{ ItemId: "ITEM_00000000000000000000029", Type: 2, MasteryType: 0, ItemClass: 7, Sockets: 1, Name: "Ringmail Armor", Description: "Armor IC 7", BuyPrice: 2052, SellPrice: 1026 }
				,{ ItemId: "ITEM_00000000000000000000030", Type: 2, MasteryType: 0, ItemClass: 8, Sockets: 1, Name: "Elven Chain", Description: "Armor IC 8", BuyPrice: 3488, SellPrice: 1744 }
				,{ ItemId: "ITEM_00000000000000000000031", Type: 2, MasteryType: 0, ItemClass: 9, Sockets: 1, Name: "Combat Plate", Description: "Armor IC 9", BuyPrice: 5929, SellPrice: 2965 }
				,{ ItemId: "ITEM_00000000000000000000032", Type: 2, MasteryType: 0, ItemClass: 10, Sockets: 1, Name: "Mage Plate", Description: "Armor IC 10", BuyPrice: 10080, SellPrice: 5040 }
				,{ ItemId: "ITEM_00000000000000000000033", Type: 2, MasteryType: 0, ItemClass: 11, Sockets: 1, Name: "Heavy Plate", Description: "Armor IC 11", BuyPrice: 17136, SellPrice: 8568 }
				,{ ItemId: "ITEM_00000000000000000000034", Type: 2, MasteryType: 0, ItemClass: 12, Sockets: 1, Name: "Lamurian Skin Armor", Description: "Armor IC 12", BuyPrice: 29131, SellPrice: 14566 }
				,{ ItemId: "ITEM_00000000000000000000035", Type: 2, MasteryType: 0, ItemClass: 13, Sockets: 1, Name: "Moloch Armor", Description: "Armor IC 13", BuyPrice: 49523, SellPrice: 24762 }
				,{ ItemId: "ITEM_00000000000000000000036", Type: 2, MasteryType: 0, ItemClass: 14, Sockets: 1, Name: "Angel Skin Armor", Description: "Armor IC 14", BuyPrice: 84189, SellPrice: 42095 }
				,{ ItemId: "ITEM_00000000000000000000037", Type: 2, MasteryType: 0, ItemClass: 15, Sockets: 1, Name: "Ancient Breastplate", Description: "Armor IC 15", BuyPrice: 143121, SellPrice: 71561 }
				,{ ItemId: "ITEM_00000000000000000000038", Type: 2, MasteryType: 0, ItemClass: 16, Sockets: 1, Name: "Mythril Ringmail", Description: "Armor IC 16", BuyPrice: 243306, SellPrice: 121653 }
				,{ ItemId: "ITEM_00000000000000000000039", Type: 2, MasteryType: 0, ItemClass: 17, Sockets: 1, Name: "Adamantium Plate", Description: "Armor IC 17", BuyPrice: 413620, SellPrice: 206810 }
				,{ ItemId: "ITEM_00000000000000000000040", Type: 2, MasteryType: 0, ItemClass: 18, Sockets: 1, Name: "Morkal Armor", Description: "Armor IC 18", BuyPrice: 703154, SellPrice: 351577 }
			],
			[	//SlotType: Spells
				 { ItemId: "ITEM_00000000000000000000044", Name: "Faerie Fire", Description: "Fire with the power of faeries", BuyPrice: 50, SellPrice: 25, ItemClass: 0, Type: 2, MasteryType: 0, ItemClass: 0, Sockets: 1 }
				,{ ItemId: "ITEM_00000000000000000000045", Type: 2, MasteryType: 0, ItemClass: 1, Sockets: 1, Name: "Minor Ignite", Description: "Spell IC 1", BuyPrice: 85, SellPrice: 43 }
				,{ ItemId: "ITEM_00000000000000000000046", Type: 2, MasteryType: 0, ItemClass: 2, Sockets: 1, Name: "Burning Hands", Description: "Spell IC 2", BuyPrice: 144, SellPrice: 72 }
				,{ ItemId: "ITEM_00000000000000000000047", Type: 2, MasteryType: 0, ItemClass: 3, Sockets: 1, Name: "Firebolt", Description: "Spell IC 3", BuyPrice: 246, SellPrice: 123 }
				,{ ItemId: "ITEM_00000000000000000000048", Type: 2, MasteryType: 0, ItemClass: 4, Sockets: 1, Name: "Flame Blast", Description: "Spell IC 4", BuyPrice: 418, SellPrice: 209 }
				,{ ItemId: "ITEM_00000000000000000000049", Type: 2, MasteryType: 0, ItemClass: 5, Sockets: 1, Name: "Flame Strike", Description: "Spell IC 5", BuyPrice: 710, SellPrice: 355 }
				,{ ItemId: "ITEM_00000000000000000000050", Type: 2, MasteryType: 0, ItemClass: 6, Sockets: 1, Name: "Burning Blood", Description: "Spell IC 6", BuyPrice: 1207, SellPrice: 604 }
				,{ ItemId: "ITEM_00000000000000000000051", Type: 2, MasteryType: 0, ItemClass: 7, Sockets: 1, Name: "Fire Fury", Description: "Spell IC 7", BuyPrice: 2052, SellPrice: 1026 }
				,{ ItemId: "ITEM_00000000000000000000052", Type: 2, MasteryType: 0, ItemClass: 8, Sockets: 1, Name: "Fireball", Description: "Spell IC 8", BuyPrice: 3488, SellPrice: 1744 }
				,{ ItemId: "ITEM_00000000000000000000053", Type: 2, MasteryType: 0, ItemClass: 9, Sockets: 1, Name: "Incinirating Ray", Description: "Spell IC 9", BuyPrice: 5929, SellPrice: 2965 }
				,{ ItemId: "ITEM_00000000000000000000054", Type: 2, MasteryType: 0, ItemClass: 10, Sockets: 1, Name: "Hell's Legion", Description: "Spell IC 10", BuyPrice: 10080, SellPrice: 5040 }
				,{ ItemId: "ITEM_00000000000000000000055", Type: 2, MasteryType: 0, ItemClass: 11, Sockets: 1, Name: "Flame Gusts", Description: "Spell IC 11", BuyPrice: 17136, SellPrice: 8568 }
				,{ ItemId: "ITEM_00000000000000000000056", Type: 2, MasteryType: 0, ItemClass: 12, Sockets: 1, Name: "Deadly Destruction", Description: "Spell IC 12", BuyPrice: 29131, SellPrice: 14566 }
				,{ ItemId: "ITEM_00000000000000000000057", Type: 2, MasteryType: 0, ItemClass: 13, Sockets: 1, Name: "Gaze Of The Phoenix", Description: "Spell IC 13", BuyPrice: 49523, SellPrice: 24762 }
				,{ ItemId: "ITEM_00000000000000000000058", Type: 2, MasteryType: 0, ItemClass: 14, Sockets: 1, Name: "Searing Orb", Description: "Spell IC 14", BuyPrice: 84189, SellPrice: 42095 }
				,{ ItemId: "ITEM_00000000000000000000059", Type: 2, MasteryType: 0, ItemClass: 15, Sockets: 1, Name: "Incendiary Strike", Description: "Spell IC 15", BuyPrice: 143121, SellPrice: 71561 }
				,{ ItemId: "ITEM_00000000000000000000060", Type: 2, MasteryType: 0, ItemClass: 16, Sockets: 1, Name: "Demon Bane", Description: "Spell IC 16", BuyPrice: 243306, SellPrice: 121653 }
				,{ ItemId: "ITEM_00000000000000000000061", Type: 2, MasteryType: 0, ItemClass: 17, Sockets: 1, Name: "Aura of Seraph", Description: "Spell IC 17", BuyPrice: 413620, SellPrice: 206810 }
				,{ ItemId: "ITEM_00000000000000000000061", Type: 2, MasteryType: 0, ItemClass: 18, Sockets: 1, Name: "Major Ignite", Description: "Spell IC 18", BuyPrice: 413620, SellPrice: 206810 }
			]
		]
	);
	
	V2Core.ItemTypes = ItemTypes;
})(window);