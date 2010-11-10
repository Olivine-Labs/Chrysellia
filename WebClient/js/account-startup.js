$(function(){
	$(".button.plus").button({ icons: { primary: "ui-icon-circle-plus" }, text: false });
	$(".button.minus").button({ icons: { primary: "ui-icon-circle-minus" }, text: false });
	
	for(var i in window.Races){
		var r = window.Races[i];
		var $race = $('<li class="character raceList"><a class="button bigButton" href="#"><input type="hidden" value="' + i + '" class="r_id" /><span class="characterPortrait ' + r.Name.replace(/ /g,'') + '"></span><span class="characterName">' + r.Name + '</span><span class="raceStats"><span class="icon str" title="Strength"></span><span>' + r.Str + '</span><br /><span class="icon dex" title="Dexterity"></span><span>' + r.Dex + '</span><br /><span class="icon int" title="Intelligence"></span><span>' + r.Int + '</span><br /><span class="icon wis" title="Wisdom"></span><span>' + r.Wis + '</span><br /><span class="icon vit" title="Vitality"></span><span>' + r.Vit + '</span><br /></span><span class="description">' + r.Description + '</span></a></li>');
		
		if(r.Align == "good"){
			$race.appendTo($("#goodRaces ul"));
		}else{
			$race.appendTo($("#evilRaces ul"));
		}
	}
	
	$("#statSelection").dialog({ 
		modal: true, 
		title: "Select Stats", 
		width: 400, 
		height: 420, 
		autoOpen: false, 
		buttons: { 
			"Create Character": function() { 
				$(this).dialog("close"); 
				$("#createCharacterForm").submit();
			}, 
			
			Cancel: function() { 
				$(this).dialog("close"); 
			} 
		} 
	});
	
	$(".raceList a").click(function(e){
		e.preventDefault();
		var $this = $(this);
		var id = $this.children(".r_id").val();
		
		$("#startingStr").val(0);
		$("#startingDex").val(0);
		$("#startingInt").val(0);
		$("#startingWis").val(0);
		$("#startingVit").val(0);
		
		$("#c_race").val(id).change();
		$("#startingStr").change();
		$("#statSelection").dialog("open");
	});
	
	$("#submitCreateAccount").click(function(e){
		e.preventDefault();
		
		var name = $("#c_fn").val();
		if(name != "" && name != "Character Name"){
			$("#accountSelection").fadeOut(500, function(){ $("#raceSelection").fadeIn(500); });
		}
	});
	
	$("#createCharacterForm").submit(function(e){
		e.preventDefault();

		var name = $("#c_fn").val();
		var race = window.Races[$("#c_race").val()];
		var gender = $("#c_gender").val();
		var str = $("#startingStr").val() * 1;
		var dex = $("#startingDex").val() * 1;
		var intel = $("#startingInt").val() * 1;
		var wis = $("#startingWis").val() * 1;
		var vit = $("#startingVit").val() * 1;
		var pin = $("#c_pin").val();
		
		if(name == "Character Name") { 
			alert("Please enter a name."); 
			return; 
		}
		
		if((str + dex + intel + wis + vit) != 25){
			$(".selectStats > em").addClass("ui-state-error");
			alert("Please use all 25 stat points.");
			return;
		}
		
		vc.cs.Create(name, gender, pin, race.Id, str, dex, intel, wis, vit, function(r){
			switch(r.Result){
				case ER_SUCCESS:
					vc.cs.List(LoadCharacterList);
					alert("Your character has been created!");
					$(".statChooser").val(0);
					$("#raceSelection").fadeOut(500, function(){ $("#accountSelection").fadeIn(500); });
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
	
	$("#accountSelection .bigButton").live("click", function(e){
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
	
	$(".raceSelection").css({ display: "none" });
	
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
	});
	
	$(".selectStats .formInput input").change(function(e){
		UpdateCreateCharacterStats($(this), e);
	});
	
	$(".selectStats .formInput button").click(function(e){
		e.preventDefault();
		UpdateCreateCharacterStats($(this), e);
	});
	
	$("#quickLoginForm .button").click(function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	vc.cs.List(LoadCharacterList);
});

function Logout(data){
	window.location = "./index.php";
}

function UpdateCreateCharacterStats(ui, e){
	var $remPoints = $("#remPoints");
	var currentBalance = CurrentStatBalance();
	var currentStatValue = 0;
	var currentStatMax = 0;
	var raceBaseStat = 0;
	
	if(ui.hasClass("minus")){
		currentStatValue = ui.siblings(".statChooser").val() *1;
		
		if(currentStatValue-1 >= 0){
			ui.siblings("input").val(currentStatValue-1);
		}
	}else if(ui.hasClass("plus")){
		currentStatValue = ui.siblings(".statChooser").val() *1;
		currentStatMax = ui.siblings("em").children("span").text() * 1;
		raceBaseStat = ui.siblings(".raceBaseStat").text() * 1;
		
		if(currentStatValue + raceBaseStat + 1 <= currentStatMax && currentBalance > 0){
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
			
			var level = c.Level || 1;
			
			var x = c.PositionX || 0;
			var y = c.PositionY || 0;
			
			$('<div class="character"><input type="hidden" value="' + c.CharacterId + '" class="c_id" /><input type="hidden" value="' + c.HasPin + '" class="c_haspin" /><a class="button bigButton" href="#"><span class="characterPortrait ' + c.RaceName().replace(/ /g,'') + '"></span><span class="characterName">' + c.Name + '</span> <span class="characterStats">Lvl ' + level + ' ' + c.AlignName() + c.RaceName() + '</span><ul class="recentActivity"><li class="ra_gold"><span class="icon gold"></span><span>' + c.Gold + '</span></li><li class="ra_location">Located at ' + x + ', ' + y + ' ' + c.CurrentMap.Name + '</li><li class="ra_created">Created: ' + c.CreatedOn + '</li></ul></a></div>').appendTo($login);
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