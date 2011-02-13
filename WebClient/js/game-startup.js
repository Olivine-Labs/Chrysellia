$(function(){
	vc.DebugMode = true;
	
	LoadICache();
	
	if($.cookie("theme") == "dark"){
		$("body").addClass("dark");
		_("themeSelect").children("options").eq(1).attr("selected", "selected");
	}
	
	_("themeSelect").bind("change", function(e){ 
		$this = $(this);
		if($this[0].value   == 0){
			$("body").removeClass("dark");
			$.cookie("theme", "light")
		}else{
			$("body").addClass("dark");
			$.cookie("theme", "dark")
		}
	});
	
	window.chatTabIndex = 0;
	
	ICache["myCharacter_ExperienceBar"].progressbar();
	ICache["myCharacter_HealthBar"].progressbar();
	
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	_("chatForm").bind("submit", function(e){
		e.preventDefault();
		var chatbox = _("chatInput")[0];
		var message= chatbox.value;
		if(message.length > 500){
			message = message.substr(0,500);
		}
		
		SubmitMessage(message);
		chatbox.value = '';
	});
	
	window.$tabs = $('#chatChannels').tabs({
		tabTemplate: '<li><a href="#{href}" class="chatChannelLabel">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
		add: function(event, ui) {
			$(ui.panel).append('<div />');
			$tabs.tabs('select', '#' + ui.panel.id);
		},
		select: function(event, ui){
			window.MyCharacter.CurrentChannel = $(".channelId")[0].value;
			$(ui.tab).parent().removeClass("newMessage");
		}
	});

	$('#chatChannels span.ui-icon-close').live('click', function() {
		var channelId = $(".channelId", $($(this).siblings("a")[0].getAttribute("href")))[0].value ;
		if(channelId != vc.ch.StaticRooms["General"] && channelId !=  vc.ch.StaticRooms["Trade"]){
			LeaveChannel(channelId);
		}
	});
	
	_("createChannelForm").dialog({ autoOpen: false, title:"Create Chat Channel", width: 400 });
	_("joinChannelForm").dialog({ autoOpen: false, title:"Join Chat Channel", width: 400 });
	
	$("#createChannelForm form").bind("submit", function(e){
		e.preventDefault();
		
		var channelName = _("cc_channelName")[0].value ;
		var channelMotd = _("cc_channelMOTD")[0].value ;
		var publicRead = _("cc_publicRead")[0].checked;
		var publicWrite = _("cc_publicWrite")[0].checked;
		
		if(publicRead){
			publicRead = 1;
		}else{
			publicRead = 0;
		}
		
		if(publicWrite){
			publicWrite = 1;
		}else{
			publicWrite = 0;
		}
		
		vc.ch.CreateChannel(channelName, channelMotd, publicRead, publicWrite, CreateChannel);
	});
	
	$("#joinChannelForm form").bind("submit", function(e){
		e.preventDefault();
		var channelName = _("jc_channelName")[0].value ;
		vc.ch.JoinChannel(channelName, JoinChannel);
	});
	
	$("#quickLoginForm .button").bind("click", function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	_("createChannelLink").bind("click", function(){ _("createChannelForm").dialog("open"); });
	_("joinChannelLink").bind("click", function(){ _("joinChannelForm").dialog("open"); });
	
	_("moveNW").button({ icons: { primary: "ui-icon-arrowthick-1-nw" }, text: false });
	_("moveN").button({ icons: { primary: "ui-icon-arrowthick-1-n" }, text: false });
	_("moveNE").button({ icons: { primary: "ui-icon-arrowthick-1-ne" }, text: false });
	_("moveW").button({ icons: { primary: "ui-icon-arrowthick-1-w" }, text: false });
	_("moveE").button({ icons: { primary: "ui-icon-arrowthick-1-e" }, text: false });
	_("moveSW").button({ icons: { primary: "ui-icon-arrowthick-1-sw" }, text: false });
	_("moveS").button({ icons: { primary: "ui-icon-arrowthick-1-s" }, text: false });
	_("moveSE").button({ icons: { primary: "ui-icon-arrowthick-1-se" }, text: false });
	
	$("#movementform button").bind("click", function(e){
		e.preventDefault();
		SetEnableMovement(false);
		$this = $(this);
		
		var dirx = $this.siblings(".x")[0].value   *1;
		var diry = $this.siblings(".y")[0].value   *1;
		
		Move(dirx, diry);
	});
	
	_("statsWindow").dialog({ title: "Character Stats", autoOpen: false });
	_("itemsWindow").dialog({ title: "Inventory", autoOpen: false});
	
	$(".accountActions .logOut").bind("click", function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	_("statsWindowButton").bind("click", function(e){
		e.preventDefault();
		_("statsWindow").dialog("open");
	});
	
	$(".chooseStats").live("click", function(e){
		e.preventDefault();
		_("statsWindow").dialog("open");
	});
	
	_("itemsWindowButton").bind("click", function(e){
		e.preventDefault();
		_("itemsWindow").dialog("open");
	});
	
	$(".chatMessage.system a.joinChannel").live("click", function(e){
		e.preventDefault();
		$this = $(this);
		var channelName = $this.siblings(".channelName").children("input:eq(0)")[0].value ;
		vc.ch.JoinChannel(channelName, JoinChannel);
		$this.parentsUntil(".ui-dialog").parent().dialog("destroy").remove();
	});
	
	$("#itemsWindow select").live("change", function(e){
		$this = $(this);
		var itemType = $this[0].className.split(' ')[0];
		$('#itemsWindow select').attr("disabled", "disabled");
		
		var slotType = $this[0].className.split(' ')[1].replace(/itemType_/,'')*1;
		var slotIndex = $('#itemsWindow select.'+itemType).index($this);
		if($this[0].value   == 0){
			vc.is.UnEquip(window.MyCharacter.Equipment[slotType][slotIndex].ItemId, slotType, slotIndex, UnEquipItem);
		}else{
			if(MyCharacter.Equipment[slotType][slotIndex] !== {}){
				vc.is.UnEquip(window.MyCharacter.Equipment[slotType][slotIndex].ItemId, slotType, slotIndex, function(response, data){vc.is.Equip($this[0].value , slotType, slotIndex, EquipItem)} );
			}else{
				vc.is.Equip($this[0].value , slotType, slotIndex, EquipItem)
			}
		}
	});
	
	$(window).resize(function(){
		ResizeChat();
	});
	
	$("#statsWindow button").bind("click", function(e){
		e.preventDefault();
		$(".chooseStats").remove();
		
		switch($(this).parent()[0].className){
			case "stat str":
				vc.cs.LevelUp(1, LevelUpResponse);
				break;
			
			case "stat dex":
				vc.cs.LevelUp(2, LevelUpResponse);
				break;
			
			case "stat vit":
				vc.cs.LevelUp(3, LevelUpResponse);
				break;
			
			case "stat int":
				vc.cs.LevelUp(4, LevelUpResponse);
				break;
			
			case "stat wis":
				vc.cs.LevelUp(5, LevelUpResponse);
				break;
			
			case "stat all":
				vc.cs.LevelUp(0, LevelUpResponse);
				break;
			
		}
	});
	
	$(document).keydown(function(e) {
        if(e.which == 192){
			OpenDebugWindow();
		}
    });
});

function Move(RelativeX, RelativeY){
	SetEnableMovement(false);
		
	var x = RelativeX + MyCharacter.PositionX *1;
	var y = RelativeY + MyCharacter.PositionY *1;
	
	if(x > (MyCharacter.CurrentMap.DimensionX -1) || MyCharacter.PositionX < 0){
		x = MyCharacter.PositionX ;
	}
	
	if(y > (MyCharacter.CurrentMap.DimensionY -1) || y < 0){
		y = MyCharacter.PositionY ;
	}
	
	vc.ms.Move(x, y, RefreshMap);
	
	if(RelativeX+RelativeY == 1 || RelativeX + RelativeY == -1){
		window.setTimeout(function(){SetEnableMovement(true)}, 200);
	}else{
		window.setTimeout(function(){SetEnableMovement(true)}, 282);
	}
}

function ExamineLocation(response, data){
	_("moveLook").button("option", "disabled", false);
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		$("optgroup[label='Other Players']").remove();
		var playersOptGroup = $("<optgroup label='Other Players' />");
		
		var name = "";
		var level = "";
		var pid = "";
		for(c in response.Data){
			if(c != "remove"){
				pid = response.Data[c].CharacterId;
				name = response.Data[c].Name;
				level = response.Data[c].Level;
				option = $("<option value='" + pid + "'>" + name + " (" + level + ")</option>").appendTo(playersOptGroup);
			}
		}
		playersOptGroup.appendTo(_("monsterList"));
	}
	
	Log("ExamineLocation: " + JSON.stringify(data));
}

function LevelUpResponse(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	var stat = data.Stat;
	if(response.Result == vc.ER_SUCCESS){ 
		switch(stat){
			case 0:
				MyCharacter.Strength += 12;
				MyCharacter.Dexterity += 12;
				MyCharacter.Vitality += 12;
				MyCharacter.Intelligence += 12;
				MyCharacter.Wisdom += 12;
				break;
			case 1:
				MyCharacter.Strength += 50;
				break;
			case 2:
				MyCharacter.Dexterity += 50;
				break;
			case 3:
				MyCharacter.Vitality += 50;
				break;
			case 4:
				MyCharacter.Intelligence += 50;
				break;
			case 5:
				MyCharacter.Wisdom += 50;
				break;
		}
		
		MyCharacter.Strength += MyCharacter.RacialStrength;
		MyCharacter.Dexterity += MyCharacter.RacialDexterity;
		MyCharacter.Vitality += MyCharacter.RacialVitality;
		MyCharacter.Intelligence += MyCharacter.RacialIntelligence;
		MyCharacter.Wisdom += MyCharacter.RacialWisdom;
		MyCharacter.Level++;

		MyCharacter.FreeLevels--;
		if(MyCharacter.FreeLevels < 1){
			$("#statsWindow button, #statsWindow .all").hide();
		}
		MyCharacter.Health = MyCharacter.Vitality;
		
		UpdateStats();
	}
	
	Log("Level Up: " + JSON.stringify(data));
}

function ResizeChat(){
	$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
}

function EquipItem(response, data){
	var slotType = data.SlotType;
	var slotIndex = data.SlotNumber;
	var itemId = data.ItemId;
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	
	if(response.Result == vc.ER_SUCCESS){ 

		var item = {};
		var typeMapping = vc.is.TypeMapping;
		
		for(var i in window.MyCharacter.Inventories["Personal"]){
			if(i != "remove"){
				if(window.MyCharacter.Inventories["Personal"][i].ItemId == itemId){
					window.MyCharacter.Equipment[slotType][slotIndex] = window.MyCharacter.Inventories["Personal"][i];
					window.MyCharacter.Inventories["Personal"].remove(i);
				}
			}
		}
		
		var item = window.MyCharacter.Equipment[slotType][slotIndex];
		$("option[value='" + item.ItemId + "']").remove();
		$("<option value='" + item.ItemId + "' selected='selected'>" + item.Name + "</option>").appendTo($("select." + typeMapping[item.SlotType]).eq(slotIndex));
	}
	
	Log("Equip Item: " + JSON.stringify(data));
	
	$('#itemsWindow select').removeAttr('disabled');
}

function UnEquipItem(response, data){
	var slotType = data.SlotType;
	var slotIndex = data.SlotNumber;
	var itemId = data.ItemId;
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 

		var item = window.MyCharacter.Equipment[slotType][slotIndex];
		var typeMapping = vc.is.TypeMapping;
		
		$("option[value='" + item.ItemId + "']").remove();
		$("<option value='" + item.ItemId + "'>" + item.Name + "</option>").appendTo($("select." + typeMapping[item.SlotType]));
		window.MyCharacter.Inventories["Personal"][window.MyCharacter.Inventories["Personal"].length] = item;
		window.MyCharacter.Equipment[slotType][slotIndex] = {};
	}
	
	$('#itemsWindow select').removeAttr('disabled');
	
	var myPlace = {};
	if(myPlace = vc.Maps["MAP_00000000000000000000001"].SpecialPlaces[0][1]){
		if(myPlace.Type == 0){
			BuildGameWindow()
		}
	}
}

function RefreshMap(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		MyCharacter.PositionX = response.Data.X;
		MyCharacter.PositionY = response.Data.Y;
		BuildMap();
	}
	
	Log("Refresh Map: " + JSON.stringify(data));
}

function SetEnableMovement(enabled){
	$("#movementform button").button("option", "disabled", !enabled).removeClass("ui-state-hover");
}

function SetEnableAttack(enabled){
	$("#fightForm button").button("option", "disabled", !enabled).removeClass("ui-state-hover");
}

function CreateChannel(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 

		_("cc_channelName").add(_("#cc_channelMOTD"))[0].value   = '';
		_("createChannelForm").dialog("close");
		AddTab(response.Data.Name, response.Data.ChannelId, response.Data.Motd);
		
		window.MyCharacter.Channels[response.Data.ChannelId] = { Motd: response.Data.Motd, Name: response.Data.Name, Permissions: { Read: 1, Write: 1, Moderate: 1, Administrate: 1, isJoined: 1 } }
	}else if(response.Result == vc.ER_ALREADYEXISTS){
		alert("Channel name already exists!");
	}else{
		alert("An error has occured.");
	}
	
	Log("Create Channel: " + JSON.stringify(data));
}

function JoinChannel(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
if(response.Result == vc.ER_SUCCESS){ 

		$("#jc_channelName, #cc_channelMOTD")[0].value   = '';
		_("joinChannelForm").dialog("close");
		AddTab(response.Data.Name, response.Data.ChannelId, response.Data.Motd);
		response.Data.Permissions.isJoined = 1;
		window.MyCharacter.Channels[response.Data.ChannelId] = { Motd: response.Data.Motd, Name: response.Data.Name, Permissions: response.Data.Permissions }
		$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
	}else{
		alert("An error has occured.");
	}
	
	Log("Join Channel: " + JSON.stringify(data));
}

function LeaveChannel(channelId){
	var $chatWindow = $("#chatChannels input[value='" + channelId + "']").parent();
	var $chatTab = $("a[href='#" + $chatWindow[0].id + "']").parent();
	var chatToCloseIndex =  $('li',$tabs).index($chatTab); 
	vc.ch.PartChannel(channelId, function(){ $tabs.tabs('remove', chatToCloseIndex); });
	delete window.MyCharacter.Channels[channelId];
}

function AddTab(title, channelId, motd) {
	if(title.indexOf("!!PM") == 0){
		title = "PM:" + title.split("!!")[1].substr(2, title.length-2);
	}
	
	$tabs.tabs('add', '#channelTabs-'+chatTabIndex, title.replace(/</g, "&lt;").replace(/>/g, "&gt;"));
	$("<input type='hidden' value='" + channelId + "' class='channelId' />").appendTo($('#channelTabs-'+chatTabIndex));
	InsertChat([{ "Type": 999, "FromName": "", "Message": motd }], channelId);
	chatTabIndex++;
	window.MyCharacter.CurrentChannel = channelId;
	ResizeChat();
}

function FillChat(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		for(var i in response.Data){
			if(i!=0){
				InsertChat(response.Data[i], i);
			}else if(typeof response.Data[0] == "object" && response.Data[0].length > 0){
				ProcessSystemMessage(response.Data[0]);
			}
		}
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, FillChat); }, 4500);
}

function SelectCharacter(response, data){
	window.MyCharacter = new Character();
	
	Log("Login: " + response.Result);
	
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 

		window.MyCharacter.Construct(response.Data);
		UpdateStats();
	}else{
		if(!vc.DebugMode){
			alert("Please login again.");
			window.location = "./index.php";
		}
	}
	
	for(var i in window.MyCharacter.Channels){
		if(i != "remove"){
			AddTab(window.MyCharacter.Channels[i].Name, i, window.MyCharacter.Channels[i].Motd);
		}
	}
	
	Log("Select Character: " + JSON.stringify(data));
	
	$tabs.tabs('select', 0);
	
	vc.ch.GetMessagesFromChannel(i, FillChat);
	
	window.ChatQueue = new Queue({ Timeout: 4500 });
	window.ChatQueue.AddItem(vc.TYPE_CHAT, vc.ch.ACTION_GETMESSAGESFROMCHANNEL, { Channel: window.MyCharacter.CurrentChannel }, FillChat);
	
	vc.is.GetInventory(LoadInventory);
}

function BuildMap(){
	$(ICache["currentMapName"]).text(MyCharacter.CurrentMap.Name);
	$(ICache["currentMapPosition"]).text(MyCharacter.PositionX + " , " + MyCharacter.PositionY);
	/*var $currentMap = _("currentMap");
	$currentMap.empty();
	
	for(my = MyCharacter.CurrentMap.DimensionY-1; my >= 0; my--){
		var $tr = $("<tr />");
		for(mx = 0; mx < MyCharacter.CurrentMap.DimensionY; mx++){
			var $td = $("<td />");
			if(my == MyCharacter.PositionY && mx == MyCharacter.PositionX){
				$td.html("<span class='mapData player'>X</span>");
			}else{
				$td.html("<span class='mapData empty'>&nbsp;</span>");
			}
			$td.appendTo($tr);
		}
		
		$tr.appendTo($currentMap);
	}
	
	$currentMap.css({ height: 30*MyCharacter.CurrentMap.DimensionY, width: 30*MyCharacter.CurrentMap.DimensionX });
	*/
	
	BuildGameWindow();
}

function BuildGameWindow(){
	var myLocation = { Monsters: MyCharacter.CurrentMap.Monsters["Default"] };
	
	if(MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX] !== undefined){
		myLocation = MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX][MyCharacter.PositionY] || { Monsters: MyCharacter.CurrentMap.Monsters["Default"] };
	}

	var topWindow = _("topCenter");
	topWindow.html('&nbsp;');
	
	if(myLocation.Type === undefined){
		if(myLocation.Monsters !== undefined){
			var container = $("<form id='fightForm'><h1>Fight!</h1><span class='attackLabel'>Attack:</span></form>");
			var select = $("<select id='monsterList' />");
			select.appendTo(container);
			
			$("<button type='submit' id='attackButton' class='button attack'>Attack</button>").bind("click", function(e){ e.preventDefault(); Attack(0); }).button().appendTo(container);
			$("<button type='submit' id='castButton' class='button cast'>Cast</button>").bind("click", function(e){ e.preventDefault(); Attack(1); }).button().appendTo(container);
			$("<button class='look button' id='moveLook'>PK List</button>").bind("click", function(e){ $(this).button("option", "disabled", true); e.preventDefault(); vc.cs.PlayerListByLocation(ExamineLocation); }).button().appendTo(container);
			
			var monster = {};
			var option = {};
			var monstersOptGroup = $("<optgroup label='Monsters' />");
			
			for(m in myLocation.Monsters){
				if(m != "remove"){
					var monsterId = myLocation.Monsters[m];
					monster = V2Core.Monsters[monsterId];
					option = $("<option value='" + monster.Id + "'>" + monster.Name + "</option>").appendTo(monstersOptGroup);
				}
			}
			monstersOptGroup.appendTo(select);
			
			container.appendTo(topWindow);
			
			var fightResults = $("<div id='fightResults' class='fightResults'></div>");
			fightResults.appendTo(topWindow);
		}
	}else{
		switch(myLocation.Type){
			case 0: //store
				BuildShop(topWindow);
				break;
				
			case 1: //shrine
				BuildShrine(topWindow);
				break;
				
			case 2: //bank
				BuildBank(topWindow);
				break;
				
			case 3: //exit
				BuildExit(topWindow);
				break;
		}
	}
}

function SubmitBankTransaction(){
	var amt = _("transactionAmount")[0].value ;
	var action = _("transactionTypeSelection")[0].value ;
	
	if((action == 0 && amt == "all") || action == 2){
		amt = MyCharacter.Gold*1;
		action = 0;
	}else if((action == 1 && amt == "all") || action == 3){
		amt = MyCharacter.Bank*1;
		action = 1;
	}
	
	action = action*1;
	
	if(isInteger(amt) || amt > 0 ){
		switch(action){
			case 0:
				if(amt > MyCharacter.Gold){
					amt = MyCharacter.Gold;
				}

				vc.ms.Deposit(amt, ProcessBankDeposit);
				break;
			case 1: 
				if(amt < MyCharacter.Gold){
					amt = MyCharacter.Bank;
				}
				
				vc.ms.Widthdraw(amt, ProcessBankWithdraw);
				break;
		}
	}
}

function ProcessBankDeposit(response, data){
	ProcessBankTransaction(response, data, 0);
}

function ProcessBankWithdraw(response, data){
	ProcessBankTransaction(response, data, 1);
}

function ProcessBankTransaction(response, data, transactionType){
	var gold = data.Gold;
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		_("transactionAmount")[0].value   = '';
		
		if(transactionType == 0){
			window.MyCharacter.Gold -= (gold*1);
			window.MyCharacter.Bank += (gold*1);
		}else{
			window.MyCharacter.Gold += (gold*1);
			window.MyCharacter.Bank -= (gold*1);
		}
		
		$("#bankTransaction h3").text("You have " + window.MyCharacter.Bank + " gold in your account.");
		
		UpdateStats();
	}else{
		alert("You don't have that much gold!");
	}
	
	Log("Bank Transaction: " + JSON.stringify(data));
}

function ProcessBankTransfer(response, data){
	var gold = data.Gold;
	
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	
	if(response.Result == vc.ER_SUCCESS){ 

		$("#transferAmount, #transferTarget")[0].value   = ''
		window.MyCharacter.Bank -= gold;
		$("#bankTransaction h3").text("You have " + window.MyCharacter.Bank + " gold in your account.");
		UpdateStats();
	}else{
		alert("You don't have that much gold!");
	}
	
	Log("Bank Transfer: " + JSON.stringify(data));
}

function SubmitBankTransfer(){
	var amt = _("transferAmount")[0].value ;
	var name = _("transferTarget")[0].value ;
	vc.ms.Transfer(amt, name, ProcessBankTransfer);
}

function BuildExit(topWindow){
	//ChangeMapvar
	myLocation = MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX][MyCharacter.PositionY];
	var name = "Bank";
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	topWindow.append("<h1>" + name + "</h1>");
	var button = $("<button class='button'>Exit to " + myLocation.ExitTo + "</button>").bind("click", function(e){ e.preventDefault(); vc.ms.ChangeMap(ProcessMapChange); });
	var buttonContainer = $("<div class='locationExit'/>").append(button);
	topWindow.append(buttonContainer);
}

function ProcessMapChange(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	
	if(response.Result == vc.ER_SUCCESS){ 
		window.MyCharacter.CurrentMap = Maps[response.Data.MapId];
		window.MyCharacter.PositionX = response.Data.PositionX;
		window.MyCharacter.PositionY =  response.Data.PositionY;
		BuildMap();
		BuildGameWindow();
		UpdateStats();
	}
	
	Log("Map Change: " + JSON.stringify(data));
}

function BuildBank(topWindow){
	var myLocation = MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX][MyCharacter.PositionY];
	var name = "Bank";
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	topWindow.append("<h1>" + name + "</h1>");
	
	var bankForm = $("<form id='bankTransactionForm'></form>");
	var bankTransaction = $("<div id='bankTransaction'><h3>You have " + window.MyCharacter.Bank + " gold in your account.</h3></div>");
	var transactionTypeSelection = $("<select id='transactionTypeSelection'><option value='0'>Deposit</option><option value='2'>Deposit All</option><option value='1'>Withdraw</option><option value='3'>Withdraw All</option></select>");
	var transactionAmount = $("<input type='text' id='transactionAmount' />");
	var submitTransaction = $("<button id='submitTransaction' class='button'>Submit</buy>").bind("click", function(e){ e.preventDefault(); SubmitBankTransaction(); });
	
	bankTransaction.append(transactionTypeSelection).append(transactionAmount).append(submitTransaction);
	bankForm.append(bankTransaction);
	
	var bankTransferForm = $("<form id='bankTransferForm'></form>");
	var bankTransfer = $("<div id='bankTransfer'><h3>Transfer</h3></div>");
	
	var transferAmount = $("<div class='bankTransfer transferAmount'><label for='transferAmount'>Amount:</label> <input type='text' id='transferAmount' /></div>");
	var transferTarget = $("<div class='bankTransfer transferTarget'><label for='transferTarget'>Send to:</label> <input type='text' id='transferTarget' /></div>");
	var submitTransaction = $("<button id='submitTransaction' class='button'>Transfer</buy>").bind("click", function(e){ e.preventDefault(); SubmitBankTransfer(); });
	
	bankTransfer.append(transferAmount).append(transferTarget.append(submitTransaction));
	bankForm.append(bankTransfer);
	
	topWindow.append(bankForm);
}

function ReviveCharacter(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	
	if(response.Result == vc.ER_SUCCESS){ 
		MyCharacter.Health = MyCharacter.Vitality;
		UpdateStats();
		BuildGameWindow();
	}
	
	Log("Revive: " + JSON.stringify(data));
}

function Attack(fightType){
	SetEnableAttack(false); 
	$("#fightResults .result").remove();
	var enemyId = _("monsterList")[0].value ;
	var fightResults = _("fightResults");
	
	if(MyCharacter.Health < 1){
		alert("You can't fight! You're dead!");
		return;
	}
			
	if(enemyId.indexOf("MONS") > -1){
		if(MyCharacter.CurrentBattle !== undefined){
			if(MyCharacter.CurrentBattle.State == 2){
				fightResults.html('');
			}
			
			if(MyCharacter.CurrentBattle.Enemy == V2Core.Monsters[enemyId]){
				MyCharacter.CurrentBattle.State = 1;
			}else{
				MyCharacter.CurrentBattle = { Enemy: V2Core.Monsters[enemyId], State: 0 }
			}
		}else{
			MyCharacter.CurrentBattle = { Enemy: V2Core.Monsters[enemyId], State: 0 }
		}
		
		MyCharacter.CurrentBattle = { Enemy: V2Core.Monsters[enemyId], State: 0 }
		vc.mn.Fight(enemyId, fightType, AttackRound);
	}else if(enemyId.indexOf("CHAR") > -1){
		
		MyCharacter.CurrentBattle= { Enemy: { Id:enemyId, Name:$("#monsterList :selected").text() }, State: 0 }
		vc.cs.Fight(enemyId, fightType, AttackRound);
	}
}

function AttackRound(response, data){
	window.setTimeout(function(){SetEnableAttack(true)}, 1500);
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
if(response.Result == vc.ER_SUCCESS){ 

		var fightResults = _("fightResults");
		var battleObject = response.Data;
		
		if($(".round", fightResults).length > 0){
			$(".round", fightResults).animate({ opacity: 0 }, 250, function(){ 
				$(this).remove();
				BuildAttackMessage(battleObject, MyCharacter.CurrentBattle.Enemy.Name, true, fightResults);				
			});
		}else{
			BuildAttackMessage(battleObject, MyCharacter.CurrentBattle.Enemy.Name, true, fightResults);
		}
	}else{
		Log("Attack Error: " + JSON.stringify(data));
	}
}

function BuildShop(topWindow){
	var item = {};
	var myLocation = MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX][MyCharacter.PositionY];
	var name = "Shop";
	var itemTypeLabels = ["Weapons", "Accessories", "Armors", "Spells"];
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	topWindow.append("<h1>" + name + "</h1>");
	var buyForm = $("<form id='buyForm'></form>");
	var itemTypeSelection = $("<select id='itemTypeSelection'></select>").bind("change", function(e){ FilterItemTypes(this.value ); });
	var itemSelection = $("<select id='itemSelection'></select>");
	var buyItem = $("<button id='buyItem' class='button'>Purchase</buy>").bind("click", function(e){ e.preventDefault(); BuyItem(); });
	var itemInfo = $("<button id='itemInfo' class='button'>Info</buy>").bind("click", function(e){ 
		e.preventDefault(); 
		var index = $('#itemSelection option:selected').prevAll().length; 
		if(index < 0){ 
			index = 0; 
		} 
		var split = _("itemTypeSelection")[0].value .split("|");
		var item = V2Core.ItemTypes[2][split[0]][split[1]];
	
		DisplayItemInfo(item[index]); 
	});
	
	var itemDescription = $("<div id='itemDescription'></div>");
	var typeContainer = $("<div><label for='itemTypeSelection'>Shop For:</span></div>").append(itemTypeSelection).append(itemSelection);
	var currentItem = {};
	
	var weaponOptGroup = $("<optgroup label='Weapons'><option value='0|0'>Swords</option><option value='0|1'>Axes</option><option value='0|2'>Staves</option>option value='0|3'>Maces</option></optgroup>");
	var armorOptGroup = $("<optgroup label='Armors'><option value='1|0'>Armors</option><option value='1|1'>Shields</option></optgroup>");
	var spellsOptGroup = $("<optgroup label='Spells'><option value='3|0'>Fire</option><option value='3|1'>Cold</option><option value='3|2'>Air</option><option value='3|3'>Heal</option></optgroup>");
	var accessoriesOptGroup = $("<optgroup label='Accessories'><option value='2|0'>Accessories</option></optgroup>");
	itemTypeSelection.append(weaponOptGroup).append(armorOptGroup).append(spellsOptGroup).append(accessoriesOptGroup);
	
	buyForm.append(typeContainer).append(buyItem).append(itemInfo).append(itemDescription);
	topWindow.append(buyForm);
	
	var sellForm = $("<form id='sellForm'></form>");
	var sellSelection = $("<select id='sellSelection'></select>");
	
	var currentItem = {};		

	for(var i= 0; i < MyCharacter.Inventories["Personal"].length; i++){
		s = "";
		if(i == 0){
			var s = " selected='selected'";
		}
		
		currentItem = MyCharacter.Inventories["Personal"][i];
		sellSelection.append("<option value='" + currentItem.ItemId + "'" + s + ">" + currentItem.Name + " - " + currentItem.SellPrice + "</option>");
	}
	
	var sellItem = $("<button id='sellItem' class='button'>Sell</buy>").bind("click", function(e){ e.preventDefault(); SellItem(); });
	var sellInfo = $("<button id='sellInfo' class='button'>Info</buy>").bind("click", function(e){ e.preventDefault(); var index = $('#sellSelection option:selected').prevAll().length; if(index < 0){ index = 0; } DisplayItemInfo(MyCharacter.Inventories["Personal"][index]); });
	var sellDescription = $("<div id='sellDescription'></div>");
	var sellContainer = $("<div><label for='sellSelection'>Sell:</span></div>").append(sellSelection);
	sellForm.append(sellContainer).append(sellItem).append(sellInfo).append(sellDescription);
	topWindow.append(sellForm);
	FilterItemTypes("0|0");
}

function SellItem(){
	var val = _("sellSelection")[0].value ;
	if(val !== null && val != ""){
		itemId = val;
		vc.ms.Sell(itemId, ProcessSale);
	}
}

function BuyItem(){
	if(MyCharacter.Inventories["Personal"].length < 20){
		vc.ms.Buy(_("itemSelection")[0].value , ProcessPurchase);
	}
}

function DisplayItemInfo(item){
	if(item !== undefined){
		$("<div><div class='row'><span class='label'>Name</span><span class='value'>" +  item.Name + "</span></div><div class='row'><span class='label'>IC</span><span class='value'>" +  item.ItemClass + "</span></div><div class='row'><span class='label'>Buy Price</span><span class='value'>" +  item.BuyPrice + "</span></div><div class='row'><span class='label'>Sell Price</span><span class='value'>" +  item.SellPrice + "</span></div><div class='row'><span class='value'>" +  item.Description + "</span></div></div>").dialog({ title: "Details for " + item.Name });
	}
}

function FilterItemTypes(itemSlotType){
	var currentItem = {};
	var itemSelection = _("itemSelection").empty();
	var split = itemSlotType.split("|");
	var items = V2Core.ItemTypes[2][split[0]][split[1]];
	for(item in V2Core.ItemTypes[2][split[0]][split[1]]){
		if(item != "remove"){
			currentItem = items[item];
			s = "";
			if(item == 0){
				var s = " selected='selected'";
			}
			
			itemSelection.append("<option value='" + currentItem.ItemId + "'" + s + ">" + currentItem.Name + " - " + currentItem.BuyPrice + "</option>");
		}
	}
}

function ProcessPurchase(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	
	if(response.Result == vc.ER_SUCCESS){ 
		var item = response.Data;	
		MyCharacter.Inventories["Personal"][MyCharacter.Inventories["Personal"].length] = item;
		MyCharacter.Gold -= item.BuyPrice;
		UpdateStats();
		BuildInitialInventory();
		BuildInventoryLists();
		BuildGameWindow()
	}
	
	Log("Process Purchase: " + JSON.stringify(data));
}

function ProcessSale(response, data){
	var ItemId = data.ItemId;
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		var item = {};
		var asdf = 0;
		
		for(var i in MyCharacter.Inventories["Personal"]){
			if(isInteger(i)){
				if(MyCharacter.Inventories["Personal"][i].ItemId == ItemId){
					item = MyCharacter.Inventories["Personal"][i];
				}
				asdf++;
			}
		}
		
		asdf--;
		
		var price = item.SellPrice;
		
		MyCharacter.Inventories["Personal"].remove(asdf);
		MyCharacter.Gold += price;
		UpdateStats();
		BuildInitialInventory();
		BuildInventoryLists();
		BuildGameWindow()
	}
	
	Log("Process Sale: " + JSON.stringify(data));
}

function BuildShrine(topWindow){
	var myLocation = MyCharacter.CurrentMap.SpecialPlaces[MyCharacter.PositionX][MyCharacter.PositionY];
	var name = "Shrine";
	
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	var container = $("<form id='shrineForm'><h1>" + name + "</h1></form>");
	
	if(MyCharacter.Health > 0){
		container.append("<h2>Why are you here? You're not dead.</h2>");
	}else{
		var reviveButton = $("<button type='submit' id='reviveButton' class='button'>Revive</button>");
		reviveButton.bind("click", function(e){ e.preventDefault(); vc.ms.Revive(ReviveCharacter); });
		container.append(reviveButton);
	}
	
	$(topWindow).append(container);
}

function BuildInitialInventory(){
	_("itemsWindow").html('');
	var typeMapping = vc.is.TypeMapping;	
	var slotName = "";
	var body = window.MyCharacter.Equipment;
	var currentInventory = [];
	var item = {};
	var $select = {};
	
	for(var type = 0; type < 4; type++){
		if(body !== undefined && body[type] !== undefined){
			currentInventory = body[type];
			for(var i in currentInventory){
				if(i != "remove"){
					slotName = typeMapping[type];
					
					if(currentInventory.length > 1){
						slotName += " " + (i*1 + 1);
					}
					$select = $("<select class='" + typeMapping[type] + " itemType_" + type + "'><option value='0'>NONE</option></select>");
					$selectRow = $("<div class='itemSelection' />").append("<span class='itemType'>" + slotName + "</span>").append($select);

					if(currentInventory[i].ItemId !== null && currentInventory[i].Name !== undefined){
						item = currentInventory[i];
						$("<option value='" + item.ItemId + "' selected='selected'>" + item.Name + "</option>").prependTo($select);
					}
					
					_("itemsWindow").append($selectRow);
				}
			}
		}
	}
	
	$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
}

function LoadInventory(response, data){
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
if(response.Result == vc.ER_SUCCESS){ 

		window.MyCharacter.Inventories["Personal"] = response.Data;
		BuildInitialInventory();
		BuildInventoryLists();
	}else{
		Log("Load Inventory Error: " + JSON.stringify(data));
	}
	
	BuildMap();
	_("loading").animate({ opacity: 0 }, 500, function(){ _("loading").remove(); });
}

function BuildInventoryLists(){
	var selects = $("#itemsWindow select");
	var item = {};
	var select = {};
	var items = {};
	var typeMapping = vc.is.TypeMapping;
	
	items = window.MyCharacter.Inventories["Personal"];
	for(var i in items){
		if(i != "remove"){
			item = items[i];
			if(item !== undefined && item !== {} && item.ItemId != "undefined" && item.ItemId !== undefined){
				select = $("select." + typeMapping[item.SlotType], selects);
				$("<option value='" + item.ItemId + "'>" + item.Name + "</option>").appendTo($("select." + typeMapping[item.SlotType]));
			}
		}
	}
}

function InsertChat(response, data){
	var channel = data;
	var $chatWindow = $("#chatChannels input[value='" + channel + "']").parent();
	var $chatTab = $("a[href='#" + $chatWindow.id + "']").parent();
	
	if(response[0] !== undefined && response[0].Type !=vc.ch.CHAT_TYPE_MOTD && !$chatTab.hasClass("ui-tabs-selected")){
		$chatTab.addClass("newMessage");
	}
	
	for(x = 0; x < response.length; x++){
		var chatobj = response[x];
		if(chatobj !== undefined){
			switch(chatobj.Type){
				case vc.ch.CHAT_TYPE_GENERAL:
					var msg = $("<span class='message' />").text(chatobj.Message);
					$("<div class='chatMessage'><span class='name' style='color: #" + vc.cs.CalculateAlignColor(chatobj.AlignGood, chatobj.AlignOrder) + "'>" + chatobj.FromName + "</span>: </div>").append(msg).prependTo($chatWindow);
					break;
				case vc.ch.CHAT_TYPE_EMOTE:
					var msg = $("<span class='message' />").text(chatobj.Message);
					$("<div class='chatMessage emote'>" + chatobj.FromName + " </div>").append(msg).prependTo($chatWindow);
					break;
				case vc.ch.CHAT_TYPE_MOTD: //Channel message of the day
					var msg = $("<span class='message' />").text(chatobj.Message);
					$("<div class='chatMessage motd'></div>").append(msg).prependTo($chatWindow);
					break;
				default:
					var msg = $("<span class='message' />").text(chatobj.Message);
					$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
					break;
			}
		}
	}
}

function ProcessSystemMessage(data){
	for(x = 0; x< data.length; x++){
		var chatobj = data[x];
		
		if(chatobj.Message === undefined){
			return;
		}
		
		switch(chatobj.Message.MessageType){
			case 0:
				DisplayChannelStatusUpdate(chatobj.Message, chatobj);
				break;
				
			case 1:
				var fightResults = {};
				
				if(_("pvpMessage").length > 0){
					fightResults = _("pvpMessage");
				}else{
					fightResults = $("<div id='pvpMessage' class='fightResults' />");
				}
				
				BuildAttackMessage(chatobj.Message.BattleData, chatobj.Message.AttackedBy, false, fightResults).dialog({ title: "You Were Attacked!", modal: true, close:function(e){ _("pvpMessage").remove() } });
				break;
			case 2: //trades
				break;
			case 3:
				$("<div>" + chatobj.Message.From + " has sent you " + chatobj.Message.Amount + " gold!</div>").dialog({ title: chatobj.Message.From + " sent you gold!" });
				break;
			case 4:
				vc.CheckVersion(function(v){ if(v !== vc.Version) { alert("Your game file cache is out of date.\nPlease clear your browser's cache."); }  });
				break;
			default:
				break;
		}
	}
}

function BuildAttackMessage(Attack, EnemyName, PlayerIsAttacker, fightResults){
	var attackClass = ["player","enemy"];
	var damageLabel = ["attacked", "casted", "healed"];
	var criticalLabel = ["SMASHED", "BLASTED", "RECHARGED"];
	var name = "";
	var battleResult = {};
	var round = $("<div class='round' />");
	var battleObject = Attack.Rounds;
		
	var myActor = 0;
	var enemyActor = 1;

	if(!PlayerIsAttacker){
		myActor = 1;
		enemyActor = 0;
	}
	
	for(r in battleObject){
		if(isInteger(r)){
			var bo = battleObject[r];
			if(bo.Actor == myActor){
				name = "You";
			}else{
				name = EnemyName;
			}
			
			var special = "";
			if(Attack.Special !== undefined && Attack.Special > 0){
				special = " <span class='monsterType " + vc.MonsterSpecialTypes[Attack.Special] + "'>" + vc.MonsterSpecialTypes[Attack.Special] + "</span>";
			}
			
			if(bo.Type == 2){
				if(bo.Actor == myActor){
					MyCharacter.Health += bo.Damage;
					
					if(MyCharacter.Health > MyCharacter.Vitality){
						MyCharacter.Health = MyCharacter.Vitality;
					}
					
					UpdateHealth();
				}
			}else{
				if(bo.Actor != myActor){
					MyCharacter.Health -= bo.Damage;
					UpdateHealth();
				}
			}
			
			if(myActor == 1){
				attackClass = ["enemy", "player"]
			}

			var displaySpecial = special;
			
			var damageString = damageLabel[bo.Type];
			
			if(bo.IsCritical){
				damageString = "<strong>" + criticalLabel[bo.Type] + "</strong>";
			}
			
			if(bo.Actor == myActor){
				displaySpecial = "";
			}
			if(bo.Damage > 0){
				battleResult = $("<p class='result'><span class='attacker " + attackClass[bo.Actor] + "'>" + name + "</span>" + displaySpecial + " " + damageString + " for <span class='damage'>" + bo.Damage + "</span></p>");
			}else{
				battleResult = $("<p class='result'><span class='attacker " + attackClass[bo.Actor] + "'>" + name + "</span>" + displaySpecial + " <span class='damage'>missed</span></p>");
			}
			
			round.append(battleResult);
		}
	}
	
	fightResults.append(round);
			
	if(Attack.Masteries !== undefined && Attack.Masteries.length > 0){
		var masteryResult = {};
		var Masteries = ["Armor", "Sword", "Axe", "Mace", "Staff", "Bow", "Fire", "Air", "Cold", "Earth", "Shadow", "Arcane"];
		var masteryLabel = "";
		
		for(var m = 0; m < Attack.Masteries.length; m++){
			masteryLabel = Masteries[Attack.Masteries[m]];
			masteryResult = $("<p class='result mastery " + masteryLabel + "'><span class='attacker player'>Your</span> <strong>" + masteryLabel + "</strong> mastery has increased!</p>");
			round.append(masteryResult);
			Log("Mastery gain in " + masteryLabel);
		}
	}
	
	if(Attack.Winner !== undefined){
		if(Attack.Winner == myActor){
		
			if(!PlayerIsAttacker){
				fightResults.append("<div class='result wonFight'><span class='attacker player'>You</span> have successfully defended yourself!</span></div>");
			}else{
				fightResults.append("<div class='result wonFight'><span class='attacker player'>You</span> have defeated <span class='enemy'>" + EnemyName + "</span>" + special + "!</span></div>");
			}
			
			if(Attack.Gold !== undefined){
				MyCharacter.Gold += Attack.Gold;
			}
			
			if(Attack.Experience !== undefined){
				MyCharacter.Experience += Attack.Experience;
			}
			
			if(Attack.AlignGood !== undefined){
				MyCharacter.AlignGood = Attack.AlignGood;
			}
			
			if(Attack.AlignOrder !== undefined){
				MyCharacter.AlignOrder = Attack.AlignOrder;
			}
			
			if(Attack.LevelUp !== undefined && Attack.LevelUp == true){
				fightResults.append("<div class='result levelUp'><span class='attacker player'>You</span> have leveled up! <a href='#' class='chooseStats button'>Choose Stats</a></span></div>");
				MyCharacter.Experience -= MyCharacter.NextLevelAt();
				MyCharacter.FreeLevels++;
			}
			UpdateStats();
		}else{
			fightResults.append("<div class='result lostFight'><span class='attacker enemy'>You</span> were defeated!</span></div>");
			MyCharacter.Health = 0;
			MyCharacter.Gold = 0;
			UpdateStats();
		}
	}
	
	return fightResults;
}

function DisplayChannelStatusUpdate(ChannelInfo, chatobj){
	var $chatWindow = $("input[value='" + ChannelInfo.ChannelId + "']").parent();
	
	if(window.MyCharacter.Channels[ChannelInfo.ChannelId] === undefined){
		var title = ChannelInfo.Name;
		if(title.indexOf("!!PM") == 0){
			title = "a private channel";
		}
		
		$("<div class='chatMessage system'>" + chatobj.FromName + " invited you to join <span class='channelName'>" + title + "<input type='hidden' value='" + ChannelInfo.Name + "' /></span>! <a href='#' class='joinChannel'>Click here to join.</a></div>").dialog({ title: "Chat Room Invitation" });
	}else if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.isJoined == 1 && ChannelInfo.isJoined == 0){
		LeaveChannel(ChannelInfo.ChannelId);
		$("<div class='chatMessage system'>You have been kicked from <span class='channelName'>" + ChannelInfo.Name + "</span>!</div>").dialog({ title: "Kicked From Chat Room" });
	}else{
		if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Write == 1 && ChannelInfo.Write == 0){
			$("<div class='chatMessage system'>You have been muted in this channel.</div>").prependTo($chatWindow);
		}
		
		if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Moderate == 1 && ChannelInfo.Moderate == 0){
			$("<div class='chatMessage system'>You are no longer a mod in this channel.</div>").prependTo($chatWindow);
		}else if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Administrate == 1 && ChannelInfo.Administrate == 0){
			$("<div class='chatMessage system'>You are no longer an admin in this channel.</div>").prependTo($chatWindow);
		}
		
		if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Write == 0 && ChannelInfo.Write == 1){
			$("<div class='chatMessage system'>You have been voiced in this channel.</div>").prependTo($chatWindow);
		}
		
		if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Read == 1 && ChannelInfo.Read == 0){
			$("<div class='chatMessage system'>You have been deafened in this channel.</div>").prependTo($chatWindow);
		}else if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Read == 0 && ChannelInfo.Read == 1){
			$("<div class='chatMessage system'>You can now read this channel.</div>").prependTo($chatWindow);
		}
		
		if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Administrate == 0 && ChannelInfo.Administrate == 1){
			$("<div class='chatMessage system'>You are now an administrator in this channel.</div>").prependTo($chatWindow);
		}else if(window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions.Moderate == 0 && ChannelInfo.Moderate == 1){
			$("<div class='chatMessage system'>You are now a mod in this channel.</div>").prependTo($chatWindow);
		}
		
		window.MyCharacter.Channels[ChannelInfo.ChannelId].Permissions = { Read: ChannelInfo.Read, Write: ChannelInfo.Write, Moderate:ChannelInfo.Moderate, Administrate:ChannelInfo.Administrate }
	}
}

function SubmitMessage(message){
	if(message != ""){
		var msgobj = vc.ch.Utilities.ParseMessage(message);
		var myChannel = window.MyCharacter.CurrentChannel;
		
		if(!msgobj.NonMessageCommand){
			vc.ch.SendMessageToChannel(MyCharacter.CurrentChannel, message, function(){});
			InsertChat([{ "Type": msgobj.Type, "FromName": MyCharacter.Name, "Message": msgobj.Message, AlignGood: MyCharacter.AlignGood, AlignOrder: MyCharacter.AlignOrder  }],myChannel);
		}else{
			switch(msgobj.Type){
				
				case vc.cmd.ACTION_CHANNEL_SETRIGHTS:
					var rights = vc.ch.Utilities.ParseRights(msgobj.Message);
					vc.ch.SetRights(myChannel, rights.Character, rights.Rights, function(response, data){});
					break;
				case vc.ch.CHAT_TYPE_OPENPRIVATECHANNEL:
					CreatePrivateChannel(msgobj.Message);
					break;
				case vc.ch.CHAT_TYPE_IDPLAYER:
					vc.cmd.SendChatCommand(myChannel, vc.cmd.ACTION_ID, msgobj.Message, function(response, character){ ProcessIDPlayer(response, character); });
					break;
				case vc.CommandService.ACTION_CHANNEL_SETPARAMETERS:
					if(message.indexOf("/motd") == 0){
						type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
						var value = message.split('/motd ')[1];
						vc.ch.SetParameters(myChannel, 'Motd', value, function(response, data){ var parameter = data.Parameter; var value = data[0].value ; ProcessChannelParamterChange(myChannel, parameter, value); });
					}else if(message.indexOf("/publicRead") == 0){
						type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
						var value = message.split('/publicRead ')[1];
						vc.ch.SetParameters(myChannel, 'PublicRead', value, function(response, data){ var parameter = data.Parameter; var value = data[0].value ; ProcessChannelParamterChange(myChannel, parameter, value); });
					}else if(message.indexOf("/publicWrite") == 0){
						type = vc.CommandService.ACTION_CHANNEL_SETPARAMETERS;
						var value = message.split('/publicWrite ')[1];
						vc.ch.SetParameters(myChannel, 'PublicWrite', value, function(response, data){ var parameter = data.Parameter; var value = data[0].value ; ProcessChannelParamterChange(myChannel, parameter, value); });
					}
					break;
			}
		}
	}
}

function ProcessChannelParamterChange(channel, parameter, value){
	if(parameter == "Motd"){
		InsertChat([{ "Type": 999, "FromName": "", "Message": value }], channel);
	}
}

function CreatePrivateChannel(character){
	var channelName = "!!PM" + character + "!!" + GUID();
	vc.ch.CreateChannel(channelName, "Private Channel with " + character, 0, 0, function(response, data){
		if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
		if(response.Result == vc.ER_SUCCESS){ 
			CreateChannel(response, response.Data);
			SubmitMessage("/invite " + character);
		}else if(data == vc.ER_ALREADYEXISTS){
			CreatePrivateChannel(character);
		}
	});
}

function ProcessIDPlayer(response, data){
	var characterName = data.Character;
	if(vc.DebugMode && response.RequestDuration > 0){vc.Requests++;  vc.RequestDurationTotal += response.RequestDuration; ICache["rda_value"].text(vc.RequestDurationTotal / vc.Requests);}
	if(response.Result == vc.ER_SUCCESS){ 
		var character = response.Data;
		
		var alignName = vc.AlignName(character);
		var alignClass = "neutral";
		if(alignName.indexOf("Good") > -1){
			alignClass = "good";
		}else if(alignName.indexOf("Evil") > -1){
			alignClass = "evil";
		}
		
		var $alignContainer = $('<div class="stat align"><span class="statLabel icon alignment ' + alignClass + '" title="Alignment">Alignment</span></div>');
		$("<span />").text(alignName + " (" + character.AlignGood + " / " + character.AlignOrder + ")").addClass(alignClass).appendTo($alignContainer);
			
		$("<div class='statsWindow " + V2Core.Races[character.RaceId].Name + "'><div class='stat'><h2>" + characterName + "</h2><h4>" + V2Core.Races[character.RaceId].Name + "</h4></div><div class='stat lvl'><span class='statLabel icon lvl' title='Level'>Level</span><span>" + character.Level + "</span></div></div>").append($alignContainer).dialog({ title: characterName });
	}else if(response.Result == vc.ER_BADDATA){
		alert("Character '" + characterName + "' not found!");
	}else{
		Log("ID Player: Player(" + characterName + ") " + JSON.stringify(data));
	}
}

function Logout(response, data){
	FB.getLoginStatus(function(response) {
		if (!!response.session) {
			FB.logout();
		}
	});
	
	$.cookie("l",false);
	
	window.location = "./index.php";
}

function isInteger(s) {
  return (s.toString().search(/^-?[0-9]+$/) == 0);
}
// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};


function S4() {
   return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
}

function GUID() {
   return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

function Log(text){
	if(vc.DebugMode){
		$("#logs div:nth-child(n+30)").remove();
		_("logs").prepend("<div>" + text + "</div>");
	}
}

function OpenDebugWindow(){
	_("debugWindow").toggle();
}

function UpdateStats(){
	var mc = window.MyCharacter;
			
	ICache["myCharacter_Name"].text(mc.Name);
	ICache["myCharacter_Strength"].text(mc.Strength);
	ICache["myCharacter_Dexterity"].text(mc.Dexterity);
	ICache["myCharacter_Wisdom"].text(mc.Wisdom);
	ICache["myCharacter_Intelligence"].text(mc.Intelligence);
	ICache["myCharacter_Vitality"].text(mc.Vitality);
	ICache["myCharacter_Gold"].add(ICache["myCharacter_CurrentGold"]).text(mc.Gold);
	ICache["myCharacter_ExperienceBar"].progressbar("value", (mc.Experience / mc.NextLevelAt()) * 100)[0].setAttribute("title", mc.Experience + " / " + mc.NextLevelAt());
	ICache["myCharacter_HealthBar"].progressbar("value", ((mc.Health / mc.Vitality) * 100))[0].setAttribute("title", mc.Health + " / " + mc.Vitality);
	ICache["myCharacter_LevelTitle"].add(ICache["myCharacter_Level"]).text(mc.Level);
	ICache["myCharacter_FreeLevels"].text(mc.FreeLevels);
	ICache["myCharacter_Health"].text(mc.Health);
	ICache["myCharacter_Experience"].text(mc.Experience);
	ICache["myCharacter_Bank"].text(mc.Bank);
	
	var alignName = mc.AlignName();
	var alignClass = "neutral";
	if(alignName.indexOf("Good") > -1){
		alignClass = "good";
	}else if(alignName.indexOf("Evil") > -1){
		alignClass = "evil";
	}
	
	_("myCharacter_Alignment").text(alignName + " (" + mc.AlignGood + " / " + mc.AlignOrder + ")").siblings(".statLabel").addClass(alignClass);
	
	if(MyCharacter.FreeLevels > 0){
		$("#statsWindow button, #statsWindow .all").show();
	}
}

function UpdateHealth(){
	var mc = window.MyCharacter;
	ICache["myCharacter_HealthBar"].progressbar("value", ((mc.Health / mc.Vitality) * 100))[0].setAttribute("title", mc.Health + " / " + mc.Vitality);
	ICache["myCharacter_Health"].text(mc.Health);
}

function LoadICache(){
	ICache = new Array();
	ICache["myCharacter_Name"] = _("myCharacter_Name");
	ICache["myCharacter_Strength"] = _("myCharacter_Strength");
	ICache["myCharacter_Dexterity"] = _("myCharacter_Dexterity");
	ICache["myCharacter_Wisdom"] = _("myCharacter_Wisdom");
	ICache["myCharacter_Intelligence"] = _("myCharacter_Intelligence");
	ICache["myCharacter_Vitality"] = _("myCharacter_Vitality");
	ICache["myCharacter_Gold"] = _("myCharacter_Gold");
	ICache["myCharacter_CurrentGold"] = _("myCharacter_CurrentGold");
	ICache["myCharacter_ExperienceBar"] = _("myCharacter_ExperienceBar");
	ICache["myCharacter_HealthBar"] = _("myCharacter_HealthBar");
	ICache["myCharacter_LevelTitle"] = _("myCharacter_LevelTitle");
	ICache["myCharacter_Level"] = _("myCharacter_Level");
	ICache["myCharacter_FreeLevels"] = _("myCharacter_FreeLevels");
	ICache["myCharacter_Health"] = _("myCharacter_Health");
	ICache["myCharacter_Experience"] = _("myCharacter_Experience");
	ICache["myCharacter_Name"] = _("myCharacter_Name");
	ICache["myCharacter_Bank"] = _("myCharacter_Bank");
	ICache["rda_value"] = _("rda_value");
	ICache["currentMapPosition"] = _("currentMapPosition");
	ICache["currentMapName"] = _("currentMapName");
	
	window.ICache = ICache;
}

function _(e){
	return $(document.getElementById(e));
}