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
	
	$('#c_race').selectmenu({
		style:'dropdown', 
		menuWidth: 400,
		format: characterInfoFormatting
	});
	
	$("#submitCreateAccount").click(function(){
		var race = window.Races[$("#c_race").val()];
		var fn = $("#c_fn").val();
		var mn = $("#c_mn").val();
		var ln = $("#c_ln").val();
		
		if(fn == "First Name") { alert("Please enter a firt name."); return; }
		if(mn == "Middle Name") { mn = ""; }
		if(ln == "Last Name") { ln = ""; }
		
		vc.cs.Create(fn, mn, ln, $("#c_gender").val(), $("#c_pin").val(), race.Id, 5, 5, 5, 5, 5, function(r){
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
	
	$(".bigButton").live("click", function(e){
		e.preventDefault();
		
		var cId = $(this).parent().children(".c_id").val();
		var hasPin = $(this).parent().children(".c_haspin").val();
		var pin = 0;
		
		if(hasPin == "true"){
			pin = prompt("What is the character's PIN?", "");
		}
		
		vc.cs.Select(cId, pin, SelectCharacter);
	});
});

function LoadCharacterList(list){
	$login = $("#logIn");
	$(".character", $login).remove();
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, charData) {
			var c = new Character();
			c.Construct(charData);
			
			var level = c.Level || 0;
			
			var x = c.PositionX || 0;
			var y = c.PositionY || 0;
			
			$('<div class="character"><input type="hidden" value="' + c.CharacterId + '" class="c_id" /><input type="hidden" value="' + c.HasPin + '" class="c_haspin" /><a class="button bigButton" href="#"><span class="characterName">' + c.Name() + '</span><span class="characterStats">Lvl ' + level + ' ' + c.AlignName() + c.RaceName() + '</span></a><ul class="recentActivity"><li>Located at ' + x + ', ' + y + ' (todo: zones)</li><li>Created on: ' + c.CreatedOn + '</li></ul></div>').appendTo($login);
		});
	}else{
		alert("Please login again.");
		window.location = "./index.html";
	}
}

function SelectCharacter(chardata){
	switch(chardata.Result){
		case ER_SUCCESS:
			window.location = "./game.html";
			break;
		case ER_BADDATA:
		case ER_MALFORMED:
		case ER_DBERROR:
			alert("Please check name length and try again.");
			break;
		case ER_ACCESSDENIED:
			alert("Incorrect PIN Number.");
		default:
			alert("An error has occured. Try again later.");
			break;
	}
}