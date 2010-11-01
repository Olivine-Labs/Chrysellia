$(function(){
	$(".button.plus").button({ icons: { primary: "ui-icon-circle-plus" }, text: false });
	$(".button.minus").button({ icons: { primary: "ui-icon-circle-minus" }, text: false });
	
	var $goodOptGroup = $("<optgroup class='good' label='Good Alligned' />");
	var $evilOptGroup = $("<optgroup class='good' label='Evil Alligned' />");
	
	for(var i in window.Races){
		var r = window.Races[i];
		var $option = $("<option value='" + i + "' class='race " + r.Name.replace(/ /,'') + "'>" + r.Name + " - Str: " + r.Str + ", Dex: " + r.Dex + ", Vit: " + r.Vit + ", Int: " + r.Int + ", Wis: " + r.Wis + "</option>");
		if(r.Align == "good"){
			$option.appendTo($goodOptGroup);
		}else{
			$option.appendTo($evilOptGroup);
			
		};
	}
		
	$goodOptGroup.appendTo("#c_race")
	$evilOptGroup.appendTo("#c_race")
	
	$("#c_race").change(function(){
		var race = window.Races[$(this).val()];
		$("#baseStr").text(race.Str);
		$("#baseDex").text(race.Dex);
		$("#baseInt").text(race.Int);
		$("#baseWis").text(race.Wis);
		$("#baseVit").text(race.Vit);
	}).change();
	
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
	
	$("#createCharacter").submit(function(){
		var name = $("#c_fn").val();
		var race = window.Races[$("#c_race").val()];
		var gender = $("#c_gender").val();
		var str = $("#startingStr");
		var dex = $("#startingDex");
		var intel = $("#startingInt");
		var wis = $("#startingWis");
		var vit = $("#startingVit");
		var pin = $("#c_pin").val();
		
		if(n == "Character Name") { alert("Please enter a name."); return; }
		
		vc.cs.Create(name, gender, pin, race.Id, str, dex, intel, wis, vit, function(r){
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
		$parent = $(this).parent();
		
		var cId = $parent.children(".c_id").val();
		var hasPin = $parent.children(".c_haspin").val();
		var pin = 0;
		
		if(hasPin == "true"){
			pin = prompt("What is the character's PIN?", "");
		}
		
		vc.cs.Select(cId, pin, SelectCharacter);
	});
	
	$("#createCharacter .formInput input").change(function(e){
		e.preventDefault();
		UpdateCreateCharacterStats($(this), e);
	});
	
	$("#createCharacter .formInput button").click(function(e){
		e.preventDefault();
		UpdateCreateCharacterStats($(this), e);
	});
});

function UpdateCreateCharacterStats(ui, e){
	var $remPoints = $("#remPoints");
	var currentBalance = CurrentStatBalance();
	var currentStatValue = 0;
	
	if(ui.hasClass("minus")){
		currentStatValue = ui.siblings(".statChooser").val() *1;
		
		if(currentStatValue-1 >= 0){
			ui.siblings("input").val(currentStatValue-1);
		}
	}else if(ui.hasClass("plus")){
		currentStatValue = ui.siblings(".statChooser").val() *1;
		
		if(currentStatValue-1 >= 0){
			ui.siblings("input").val(currentStatValue+1);
		}
	}
	
	currentBalance = CurrentStatBalance();
	if(currentBalance > 25 || currentBalance < 0){
		$remPoints.addClass("ui-state-highlight").text(currentBalance);
	}else{
		$remPoints.removeClass("ui-state-highlight").text(currentBalance);
	}
}

function CurrentStatBalance(){
	var used = 0;
	
	$(".statChooser").each(function(){
		used += ($(this).val() *1);
	});
	
	return 25 - used;
}

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
			
			$('<div class="character"><input type="hidden" value="' + c.CharacterId + '" class="c_id" /><input type="hidden" value="' + c.HasPin + '" class="c_haspin" /><a class="button bigButton" href="#"><span class="characterName">' + c.Name + '</span> <span class="characterStats">Lvl ' + level + ' ' + c.AlignName() + c.RaceName() + '</span></a><ul class="recentActivity"><li>Located at ' + x + ', ' + y + ' (todo: zones)</li><li>Created on: ' + c.CreatedOn + '</li></ul></div>').appendTo($login);
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