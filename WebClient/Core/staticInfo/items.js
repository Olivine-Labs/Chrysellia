(function( window, undefined ) {
	var ItemTypes = new Array(
		[], // 0?
		[], // 2?
		[	// Equippables
			[	//SlotType: Weapons
				{ 
					Id: "ITEM_00000000000000000000001",
					Name: "Dagger",
					Description: "A small dagger",
					BuyPrice: 50,
					SellPrice: 25,
					ItemClass: 0
				}
			],
			[	//SlotType: Armors
				{ 
					Id: "ITEM_00000000000000000000002",
					Name: "Clothes",
					Description: "Simple clothing",
					BuyPrice: 50,
					SellPrice: 25,
					ItemClass: 0
				}
			]
		]
	);
	
	V2Core.ItemTypes = ItemTypes;
})(window);