$(function(){
	// <option value="0">Human - Strengths: all-around, flexible character (Bonuses to sword and armor masteries)</option>
	// c_race
	for(var i in window.Races){
		var r = window.Races[i];
		$("<option value='" + i + "'>" + r.Name + " - Str: " + r.Str + ", Dex: " + r.Dex + ", Vit: " + r.Vit + ", Int: " + r.Int + ", Wis: " + r.Wis + "</option>").appendTo("#c_race");
	}
	
	//a custom format option callback
	var characterInfoFormatting = function(text){
		var newText = text;
		//array of find replaces
		var findreps = [
			{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
			{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
			{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
			{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
			{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
		];
		
		for(var i in findreps){
			newText = newText.replace(findreps[i].find, findreps[i].rep);
		}
		return newText;
	}
	
	$('select#c_race').selectmenu({
		style:'dropdown', 
		menuWidth: 400,
		format: characterInfoFormatting
	});
	
	$("#submitCreateAccount").click(function(){
		var race = window.Races[$("#c_race").val()];
		vc.cs.Create($("#c_fn").val(), $("#c_mn").val(), $("#c_ln").val(), $("#c_gender").val(), $("#c_pin").val(), race.Id, race.Str, race.Dex, race.Int, race.Wis, race.Vit, function(r){
			switch(r.Result){
					case ER_SUCCESS:
						vc.cs.List(LoadCharacterList);
						alert("Your character has been created!");
						break;
					case ER_BADDATA:
					case ER_MALFORMED:
					case ER_DBERROR:
						alert("Please check name length and try again.");
						break;
					case ER_ALREADYEXISTS:
						alert("A character with that name already exists!");
						break;
					default:
						alert("An error has occured. Try again later.");
						break;
				}
		});
	});
	
	vc.cs.List(LoadCharacterList);
	
	/*
	<div class="character">
		<a class="button bigButton" href="#">
			<span class="characterName">Silwar</span>
			<span class="characterStats">Evil level 356 Giant : 4,5 Essence of Malice</span>
		</a>
		<ul class="recentActivity">
			<li>#15 for Gold Banked</li>
			<li>02/04/10: Illusionist Fail achievement earned</li>
			<li>02/03/10: *Ding* Level 350</li>
			<li>02/01/10: *Ding* Level 300</li>
			<li>01/27/10: <strong class="warning">Muted for 3 hours</strong> by Data33 for "spamming and trolling Data33"</li>
			<li><strong>7 unread messages</strong></li>
		</ul>
	</div>
	
	{
		"CharacterId":"CHAR_4cbf2dee01b470.95891328",
		"Pin":null,
		"FirstName":"test",
		"MiddleName":"t",
		"LastName":"test",
		"CreatedOn":"2010-10-20 13:59:10",
		"MapId":null,
		"PositionX":null,
		"PositionY":null,
		"RaceId":"RACE_00000000000000000000001",
		"Gender":null,
		"AlignGood":0,
		"AlignOrder":0,
		"Level":null,
		"FreeLevels":null,
		"Experience":null,
		"Strength":40,
		"Dexterity":40,
		"Intelligence":40,
		"Wisdom":40,
		"Vitality":40,
		"Health":40,
	}
	*/
});

function LoadCharacterList(list){
	$login = $("#logIn");
	$(".character", $login).remove();
	
	$.each(list.Data, function(index, c) {
		var name = c.FirstName;
		
		if(c.MiddleName){
			name += " " + c.MiddleName;
		}
		
		if(c.LastName){
			name += " " + c.LastName;
		}
		
		var level = c.Level || 0;
		var race = window.Races[c.RaceId].Name;
		
		var x = c.PositionX || 0;
		var y = c.PositionY || 0;
		
		var goodAlign = "";
		var orderAlign = "";
		
		if(c.AlignGood <= -100){
			goodAlign = "Evil ";
		}else if(c.AlignGood >= 100){
			goodAlign = "Good ";
		}
		
		if(c.AlignOrder <= -100){
			orderAlign = "Chaotic ";
		}else if(c.AlignOrder >= 100){
			orderAlign = "Ordered ";
		}
		
		$('<div class="character"><a class="button bigButton" href="#"><span class="characterName">' + name + '</span><span class="characterStats">Lvl ' + level + ' ' + orderAlign + goodAlign + race + '</span></a><ul class="recentActivity"><li>Located at ' + x + ', ' + y + ' (todo: zones)</li><li>Created on: ' + c.CreatedOn + '</li></ul></div>').appendTo($login);
	});
}