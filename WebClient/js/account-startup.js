$(function(){
	// <option value="0">Human - Strengths: all-around, flexible character (Bonuses to sword and armor masteries)</option>
	// c_race
	$.each(window.Races, function(index, r) { 
		$("<option value='" + index + "'>" + r.Name + " - Str: " + r.Str + ", Dex: " + r.Dex + ", Vit: " + r.Vit + ", Int: " + r.Int + ", Wis: " + r.Wis + "</option>").appendTo("#c_race");
	});
	
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
});