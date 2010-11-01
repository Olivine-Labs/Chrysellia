$(function(){
	$(".button.plus").button({ icons: { primary: "ui-icon-circle-plus" }, text: false });
	$(".button.minus").button({ icons: { primary: "ui-icon-circle-minus" }, text: false });
	
	for(var i in window.Races){
		var r = window.Races[i];
		
		var $option = $("<option value='" + i + "' class='race " + r.Name.replace(/ /g,'') + "'>" + r.Name + " - Str: " + r.Str + ", Dex: " + r.Dex + ", Vit: " + r.Vit + ", Int: " + r.Int + ", Wis: " + r.Wis + "</option>");
		
		if(r.Align == "good"){
			$option.appendTo($("#c_race"));
		}else{
			$option.appendTo($("#c_race"));
		}
	}
	
	$("#c_race").change(function(){
		var race = window.Races[$(this).val()];
		$("#baseStr").text(race.Str);
		$("#baseDex").text(race.Dex);
		$("#baseInt").text(race.Int);
		$("#baseWis").text(race.Wis);
		$("#baseVit").text(race.Vit);
		
		$("#raceStrMax").text(race.StrMax);
		$("#raceDexMax").text(race.DexMax);
		$("#raceIntMax").text(race.IntMax);
		$("#raceWisMax").text(race.WisMax);
		$("#raceVitMax").text(race.VitMax);
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
	
	$("#createCharacterForm").submit(function(e){
		e.preventDefault();
		
		var name = $("#c_fn").val();
		var race = window.Races[$("#c_race").val()];
		var gender = $("#c_gender").val();
		var str = $("#startingStr").val();
		var dex = $("#startingDex").val();
		var intel = $("#startingInt").val();
		var wis = $("#startingWis").val();
		var vit = $("#startingVit").val();
		var pin = $("#c_pin").val();
		
		if(name == "Character Name") { alert("Please enter a name."); return; }
		
		vc.cs.Create(name, gender, pin, race.Id, str, dex, intel, wis, vit, function(r){
			switch(r.Result){
				case ER_SUCCESS:
					vc.cs.List(LoadCharacterList);
					alert("Your character has been created!");
					$(".statChooser").val(0);
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
	
	$(".selectStats .formInput input").change(function(e){
		UpdateCreateCharacterStats($(this), e);
	});
	
	$(".selectStats .formInput button").click(function(e){
		e.preventDefault();
		UpdateCreateCharacterStats($(this), e);
		return false;
	});
	
	$("#quickLoginForm .button").click(function(e){
		e.preventDefault();
		//vc.as.Logout(logout);
		Logout();
	});
	
	vc.cs.List(LoadCharacterList);
});

function Logout(){
	window.location = "./index.php";
}

function UpdateCreateCharacterStats(ui, e){
	var $remPoints = $("#remPoints");
	var currentBalance = CurrentStatBalance();
	var currentStatValue = 0;
	var currentStatMax = 0;
	
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
		$remPoints.text(currentBalance).parent().addClass("ui-state-highlight");
	}else{
		$remPoints.text(currentBalance).parent().removeClass("ui-state-highlight");
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
			
			$('<div class="character"><input type="hidden" value="' + c.CharacterId + '" class="c_id" /><input type="hidden" value="' + c.HasPin + '" class="c_haspin" /><a class="button bigButton" href="#"><span class="characterName">' + c.Name + '</span> <span class="characterStats">Lvl ' + level + ' ' + c.AlignName() + c.RaceName() + '</span></a><ul class="recentActivity"><li>Str: ' + c.Strength + '</li><li>Dex: ' + c.Dexterity + '</li><li>Int: ' + c.Intelligence + '</li><li>Wis: ' + c.Wisdom + '</li><li>Health: ' + c.Health + ' / ' + c.Vitality + '</li><li>Gold: ' + c.Gold + '</li><li>Located at ' + x + ', ' + y + ' (todo: zones)</li><li>Created on: ' + c.CreatedOn + '</li></ul></div>').appendTo($login);
		});
	}else{
		alert("Please login again.");
		window.location = "./index.php";
	}
}

function SelectCharacter(chardata){
	switch(chardata.Result){
		case ER_SUCCESS:
			window.location = "./game.php";
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