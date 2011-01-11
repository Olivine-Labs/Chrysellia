(function( window, undefined ) {
	var ItemTypes = new Array(
		[], // 0?
		[], // 2?
		[	// Equippables
			[	//SlotType: Weapons
				{ 
					ItemId: "ITEM_00000000000000000000001",
					Name: "Dagger",
					Description: "A small dagger",
					BuyPrice: 50,
					SellPrice: 25,
					ItemClass: 0,
					Type: 2,
					MasteryType: 1,
					ItemClass: 0,
					Sockets: 1
				}
			],
			[	//SlotType: Armors
				{ 
					ItemId: "ITEM_00000000000000000000002",
					Name: "Clothes",
					Description: "Simple clothing",
					BuyPrice: 50,
					SellPrice: 25,
					ItemClass: 0,
					Type: 2,
					MasteryType: 0,
					ItemClass: 0,
					Sockets: 1
				}
			],
			[	//SlotType: Spells
				{ 
					ItemId: "ITEM_00000000000000000000003",
					Name: "Faerie Fire",
					Description: "A spell that burns with the power of faeries",
					BuyPrice: 50,
					SellPrice: 25,
					ItemClass: 0,
					Type: 2,
					MasteryType: 0,
					ItemClass: 0,
					Sockets: 1
				}
			]
		]
	);
	
	V2Core.ItemTypes = ItemTypes;
})(window);