$(function(){
	if($.cookie("theme") == "dark"){
		$("body").addClass("dark");
		$("#themeSelect").children("options").eq(1).attr("selected", "selected");
	}
	
	$("#themeSelect").bind("change", function(e){ 
		$this = $(this);
		if($this.val() == 0){
			$("body").removeClass("dark");
			$.cookie("theme", "light")
		}else{
			$("body").addClass("dark");
			$.cookie("theme", "dark")
		}
	});
	
	window.chatTabIndex = 0;
	
	$("#myCharacter_ExperienceBar").progressbar();
	$("#myCharacter_HealthBar").progressbar();
	
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	$("#chatForm").bind("submit", function(e){
		e.preventDefault();
		SubmitMessage();
	});
	
	window.$tabs = $('#chatChannels').tabs({
		tabTemplate: '<li><a href="#{href}" class="chatChannelLabel">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
		add: function(event, ui) {
			$(ui.panel).append('<div />');
			$tabs.tabs('select', '#' + ui.panel.id);
		},
		select: function(event, ui){
			window.MyCharacter.CurrentChannel = $(".channelId", ui.panel).val();
			$(ui.tab).parent().removeClass("newMessage");
		}
	});

	$('#chatChannels span.ui-icon-close').live('click', function() {
		var channelId = $(".channelId", $($(this).siblings("a").attr("href"))).val();
		if(channelId != vc.ch.StaticRooms["General"] && channelId !=  vc.ch.StaticRooms["Trade"]){
			LeaveChannel(channelId);
		}
	});
	
	$("#createChannelForm").dialog({ autoOpen: false, title:"Create Chat Channel", width: 400 });
	$("#joinChannelForm").dialog({ autoOpen: false, title:"Join Chat Channel", width: 400 });
	
	$("#createChannelForm form").bind("submit", function(e){
		e.preventDefault();
		
		var channelName = $("#cc_channelName").val();
		var channelMotd = $("#cc_channelMOTD").val();
		var publicRead = $("#cc_publicRead").attr('checked');
		var publicWrite = $("#cc_publicWrite").attr('checked');
		
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
		
		vc.ch.CreateChannel(channelName, channelMotd, publicRead, publicWrite, CreateChannel)
	});
	
	$("#joinChannelForm form").bind("submit", function(e){
		e.preventDefault();
		var channelName = $("#jc_channelName").val();
		vc.ch.JoinChannel(channelName, JoinChannel);
	});
	
	$("#quickLoginForm .button").bind("click", function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	$("#createChannelLink").bind("click", function(){ $("#createChannelForm").dialog("open"); });
	$("#joinChannelLink").bind("click", function(){ $("#joinChannelForm").dialog("open"); });
	
	$("#moveNW").button({ icons: { primary: "ui-icon-arrowthick-1-nw" }, text: false });
	$("#moveN").button({ icons: { primary: "ui-icon-arrowthick-1-n" }, text: false });
	$("#moveNE").button({ icons: { primary: "ui-icon-arrowthick-1-ne" }, text: false });
	$("#moveW").button({ icons: { primary: "ui-icon-arrowthick-1-w" }, text: false });
	$("#moveE").button({ icons: { primary: "ui-icon-arrowthick-1-e" }, text: false });
	$("#moveSW").button({ icons: { primary: "ui-icon-arrowthick-1-sw" }, text: false });
	$("#moveS").button({ icons: { primary: "ui-icon-arrowthick-1-s" }, text: false });
	$("#moveSE").button({ icons: { primary: "ui-icon-arrowthick-1-se" }, text: false });
	
	$("#movementform button").bind("click", function(e){
		e.preventDefault();
		SetEnableMovement(false);
		$this = $(this);
		
		var dirx = $this.siblings(".x").val() *1;
		var diry = $this.siblings(".y").val() *1;
		
		Move(dirx, diry);
	});
	
	$("#statsWindow").dialog({ title: "Character Stats", autoOpen: false });
	$("#itemsWindow").dialog({ title: "Inventory", autoOpen: false});
	
	$(".accountActions .logOut").bind("click", function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	$("#statsWindowButton").bind("click", function(e){
		e.preventDefault();
		$("#statsWindow").dialog("open");
	});
	
	$(".chooseStats").live("click", function(e){
		e.preventDefault();
		$("#statsWindow").dialog("open");
	});
	
	$("#itemsWindowButton").bind("click", function(e){
		e.preventDefault();
		$("#itemsWindow").dialog("open");
	});
	
	$(".chatMessage.system a.joinChannel").live("click", function(e){
		e.preventDefault();
		$this = $(this);
		var channelName = $this.siblings(".channelName").text();
		vc.ch.JoinChannel(channelName, JoinChannel);
		$this.parentsUntil(".ui-dialog").parent().dialog("destroy").remove();
	});
	
	$("#itemsWindow select").live("change", function(e){
		$this = $(this);
		var itemType = $this.attr("class").split(' ')[0];
		$('#itemsWindow select').attr("disabled", "disabled");
		
		var slotType = $this.attr("class").split(' ')[1].replace(/itemType_/,'')*1;
		var slotIndex = $('#itemsWindow select.'+itemType).index($this);
		if($this.val() == 0){
			vc.is.UnEquip(window.MyCharacter.Equipment[slotType][slotIndex].ItemId, slotType, slotIndex, UnEquipItem);
		}else{
			if(MyCharacter.Equipment[slotType][slotIndex] !== {}){
				vc.is.UnEquip(window.MyCharacter.Equipment[slotType][slotIndex].ItemId, slotType, slotIndex, function(data){vc.is.Equip($this.val(), slotType, slotIndex, EquipItem)} );
			}else{
				vc.is.Equip($this.val(), slotType, slotIndex, EquipItem)
			}
		}
	});
	
	$(window).resize(function(){
		$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
	});
	
	$("#statsWindow button").bind("click", function(e){
		e.preventDefault();
		$(".chooseStats").remove();
		
		switch($(this).parent().attr("class")){
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
		window.setTimeout(function(){SetEnableMovement(true)}, 750);
	}else{
		window.setTimeout(function(){SetEnableMovement(true)}, 1060);
	}
}

function ExamineLocation(data){
	$("#moveLook").button("option", "disabled", false);
	if(data.Result == vc.ER_SUCCESS){
		$("optgroup[label='Other Players']").remove();
		var playersOptGroup = $("<optgroup label='Other Players' />");
		
		var name = "";
		var level = "";
		var pid = "";
		for(c in data.Data){
			if(c != "remove"){
				pid = data.Data[c].CharacterId;
				name = data.Data[c].Name;
				level = data.Data[c].Level;
				option = $("<option value='" + pid + "'>" + name + " (" + level + ")</option>").appendTo(playersOptGroup);
			}
		}
		playersOptGroup.appendTo($("#monsterList"));
	}
}

function LevelUpResponse(data, stat){
	if(data.Result == vc.ER_SUCCESS){
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
		
		vc.i.UpdateStats();
	}
}

function EquipItem(data, itemId, slotType, slotIndex){
	if(data.Result == vc.ER_SUCCESS){
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
		$("option[value=" + item.ItemId + "]").remove();
		$("<option value='" + item.ItemId + "' selected='selected'>" + item.Name + "</option>").appendTo($("select." + typeMapping[item.SlotType]).eq(slotIndex));
	}
	
	$('#itemsWindow select').removeAttr('disabled');
}

function UnEquipItem(data, itemId, slotType, slotIndex){
	if(data.Result == vc.ER_SUCCESS){
		var item = window.MyCharacter.Equipment[slotType][slotIndex];
		var typeMapping = vc.is.TypeMapping;
		
		$("option[value=" + item.ItemId + "]").remove();
		$("<option value='" + item.ItemId + "'>" + item.Name + "</option>").appendTo($("select." + typeMapping[item.SlotType]));
		window.MyCharacter.Inventories["Personal"][window.MyCharacter.Inventories["Personal"].length] = item;
		window.MyCharacter.Equipment[slotType][slotIndex] = {};
	}
	
	$('#itemsWindow select').removeAttr('disabled');
	
	if(MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX].Type == 0){
		BuildGameWindow()
	}
}

function RefreshMap(data){
	if(data.Result == vc.ER_SUCCESS){
		MyCharacter.PositionX = data.Data.X;
		MyCharacter.PositionY = data.Data.Y;
		BuildMap();
	}
}

function SetEnableMovement(enabled){
	$("#movementform button").button("option", "disabled", !enabled).removeClass("ui-state-hover");
}

function SetEnableAttack(enabled){
	$("#fightForm button").button("option", "disabled", !enabled).removeClass("ui-state-hover");
}

function CreateChannel(data){
	if(data.Result == vc.ER_SUCCESS){
		$("#cc_channelName, #cc_channelMOTD").val('');
		$("#createChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId, data.Data.Motd);
		
		window.MyCharacter.Channels[data.Data.ChannelId] = { Motd: data.Data.Motd, Name: data.Data.Name, Permissions: { Read: 1, Write: 1, Moderate: 1, Administrate: 1, isJoined: 1 } }
	}else if(data.Result == vc.ER_ALREADYEXISTS){
		alert("Channel name already exists!");
	}else{
		alert("An error has occured.");
	}
}

function JoinChannel(data){
	if(data.Result == vc.ER_SUCCESS){
		$("#jc_channelName, #cc_channelMOTD").val('');
		$("#joinChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId, data.Data.Motd);
		data.Data.Permissions.isJoined = 1;
		window.MyCharacter.Channels[data.Data.ChannelId] = { Motd: data.Data.Motd, Name: data.Data.Name, Permissions: data.Data.Permissions }
		$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
	}else{
		alert("An error has occured.");
	}
}

function LeaveChannel(channelId){
	var $chatWindow = $("#chatChannels input[value='" + channelId + "']").parent();
	var $chatTab = $("a[href='#" + $chatWindow.attr("id") + "']").parent();
	var chatToCloseIndex =  $('li',$tabs).index($chatTab); 
	vc.ch.PartChannel(channelId, function(){ $tabs.tabs('remove', chatToCloseIndex); });
	delete window.MyCharacter.Channels[channelId];
}

function AddTab(title, channelId, motd) {
	$tabs.tabs('add', '#channelTabs-'+chatTabIndex, title.replace(/</g, "&lt;").replace(/>/g, "&gt;"));
	$("<input type='hidden' value='" + channelId + "' class='channelId' />").appendTo($('#channelTabs-'+chatTabIndex));
	InsertChat([{ "Type": 999, "FromName": "", "Message": motd }], channelId);
	chatTabIndex++;
	window.MyCharacter.CurrentChannel = channelId;
}

function FillChat(list){
	if(list.Result == vc.ER_SUCCESS){
		for(var i in list.Data){
			if(i != "remove"){
				if(i!=0){
					InsertChat(list.Data[i], i);
				}else{
					ProcessSystemMessage(list.Data[0]);
				}
			}
		}
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, FillChat); }, 4500);
}

function SelectCharacter(data){
	window.MyCharacter = new Character();
	
	if(data.Result == vc.ER_SUCCESS){
		window.MyCharacter.Construct(data.Data);
		vc.i.UpdateStats();
	}else{
		alert("Please login again.");
		window.location = "./index.php";
	}
	
	for(var i in window.MyCharacter.Channels){
		if(i != "remove"){
			AddTab(window.MyCharacter.Channels[i].Name, i, window.MyCharacter.Channels[i].Motd);
		}
	}
	
	$tabs.tabs('select', 0);
	
	vc.ch.GetMessagesFromChannel(i, FillChat);
	
	vc.is.GetInventory(LoadInventory);
}

function BuildMap(){
	$("#currentMapName").text(MyCharacter.CurrentMap.Name);
	var $currentMap = $("#currentMap");
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
	
	BuildGameWindow();
}

function BuildGameWindow(){
	var myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
	var topWindow = $("#topCenter");
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
					var monsterId = GetFullMonsterId(myLocation.Monsters[m]);
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
	var amt = $("#transactionAmount").val();
	var action = $("#transactionTypeSelection").val();
	
	if(action == 0 && amt == "all" || action == 2){
		amt = MyCharacter.Gold;
		action = 0;
	}else if(action == 1 && amt == "all" || action == 3){
		amt = MyCharacter.Bank;
		action = 1;
	}

	if(isInteger(amt) || amt > 0 ){
		switch(action){
			case 0:
				if(amt > MyCharacter.Gold){
					amt == MyCharacter.Gold;
				}
				vc.ms.Deposit(amt, ProcessBankTransaction);
				break;
			case 1: 
				if(amt < MyCharacter.Gold){
					amt == MyCharacter.Bank;
				}
				vc.ms.Widthdraw(amt, ProcessBankTransaction);
				break;
		}
	}
}

function ProcessBankTransaction(data, gold, transactionType){
	if(data.Result == vc.ER_SUCCESS){
		$("#transactionAmount").val('')
		
		if(transactionType == 0){
			window.MyCharacter.Gold -= gold;
			window.MyCharacter.Bank += gold;
		}else{
			window.MyCharacter.Gold += gold;
			window.MyCharacter.Bank -= gold;
		}
		
		$("#bankTransaction h3").text("You have " + window.MyCharacter.Bank + " gold in your account.");
		
		vc.i.UpdateStats();
	}else{
		alert("You don't have that much gold!");
	}
}

function ProcessBankTransfer(data, gold){
	if(data.Result == vc.ER_SUCCESS){
		$("#transferAmount, #transferTarget").val('')
		window.MyCharacter.Bank -= gold;
		$("#bankTransaction h3").text("You have " + window.MyCharacter.Bank + " gold in your account.");
		vc.i.UpdateStats();
	}else{
		alert("You don't have that much gold!");
	}
}

function SubmitBankTransfer(){
	var amt = $("#transferAmount").val();
	var name = $("#transferTarget").val();
	vc.ms.Transfer(amt, name, ProcessBankTransfer);
}

function BuildExit(topWindow){
	//ChangeMapvar
	myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
	var name = "Bank";
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	topWindow.append("<h1>" + name + "</h1>");
	var button = $("<button class='button'>Exit to " + myLocation.ExitTo + "</button>").bind("click", function(e){ e.preventDefault(); vc.ms.ChangeMap(ProcessMapChange); });
	var buttonContainer = $("<div class='locationExit'/>").append(button);
	topWindow.append(buttonContainer);
}

function ProcessMapChange(data){
	if(data.Result == vc.ER_SUCCESS){
		window.MyCharacter.CurrentMap = Maps[data.Data.MapId];
		window.MyCharacter.PositionX = data.Data.PositionX;
		window.MyCharacter.PositionY =  data.Data.PositionY;
		BuildMap();
		BuildGameWindow();
		vc.i.UpdateStats();
	}
}

function BuildBank(topWindow){
	var myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
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

function ReviveCharacter(data){
	if(data.Result == vc.ER_SUCCESS){
		MyCharacter.Health = MyCharacter.Vitality;
		vc.i.UpdateStats();
		BuildGameWindow();
	}
}

function Attack(fightType){
	SetEnableAttack(false); 
	$("#fightResults .result").remove();
	var enemyId = $("#monsterList").val();
	var fightResults = $("#fightResults");
	
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

function AttackRound(data){
	window.setTimeout(function(){SetEnableAttack(true)}, 1500);
	if(data.Result == vc.ER_SUCCESS){
		var fightResults = $("#fightResults");
		var battleObject = data.Data;
		
		if($(".round", fightResults).length > 0){
			$(".round", fightResults).animate({ opacity: 0 }, 250, function(){ 
				$(this).remove();
				BuildAttackMessage(battleObject, MyCharacter.CurrentBattle.Enemy.Name, true, fightResults);				
			});
		}else{
			BuildAttackMessage(battleObject, MyCharacter.CurrentBattle.Enemy.Name, true, fightResults);
		}
	}
}

function BuildShop(topWindow){
	var item = {};
	var myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
	var name = "Shop";
	var itemTypeLabels = ["Weapons", "Armors", "Spells"];
	if(myLocation.Name !== undefined){
		var name = myLocation.Name;
	}
	
	topWindow.append("<h1>" + name + "</h1>");
	var buyForm = $("<form id='buyForm'></form>");
	var itemTypeSelection = $("<select id='itemTypeSelection'></select>").bind("change", function(e){ FilterItemTypes($(this).val()); });
	var itemSelection = $("<select id='itemSelection'></select>");
	var buyItem = $("<button id='buyItem' class='button'>Purchase</buy>").bind("click", function(e){ e.preventDefault(); BuyItem(); });
	var itemInfo = $("<button id='itemInfo' class='button'>Info</buy>").bind("click", function(e){ 
		e.preventDefault(); 
		var index = $('#itemSelection option:selected').prevAll().length; 
		if(index < 0){ 
			index = 0; 
		} 
		var split = $("#itemTypeSelection").val().split("|");
		var item = V2Core.ItemTypes[2][split[0]][split[1]];
	
		DisplayItemInfo(item[index]); 
	});
	
	var itemDescription = $("<div id='itemDescription'></div>");
	var typeContainer = $("<div><label for='itemTypeSelection'>Shop For:</span></div>").append(itemTypeSelection).append(itemSelection);
	var currentItem = {};
	
	var weaponOptGroup = $("<optgroup label='Weapons'><option value='0|0'>Swords</option><option value='0|1'>Axes</option><option value='0|2'>Staves</option>option value='0|3'>Maces</option></optgroup>");
	var armorOptGroup = $("<optgroup label='Armors'><option value='1|0'>Armors</option><option value='1|1'>Shields</option></optgroup>");
	var spellsOptGroup = $("<optgroup label='Spells'><option value='2|0'>Fire</option><option value='2|1'>Cold</option><option value='2|2'>Air</option><option value='2|3'>Heal</option></optgroup>");
	itemTypeSelection.append(weaponOptGroup).append(armorOptGroup).append(spellsOptGroup);
	
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
	FilterItemTypes($("#itemTypeSelection option:first").val());
}

function SellItem(){
	if($("#sellSelection").val() !== null){
		itemId = $("#sellSelection").val();
		vc.ms.Sell(itemId, ProcessSale);
	}
}

function BuyItem(){
	if(MyCharacter.Inventories["Personal"].length < 20){
		vc.ms.Buy($("#itemSelection").val(), ProcessPurchase);
	}
}

function DisplayItemInfo(item){
	if(item !== undefined){
		$("<div><div class='row'><span class='label'>Name</span><span class='value'>" +  item.Name + "</span></div><div class='row'><span class='label'>IC</span><span class='value'>" +  item.ItemClass + "</span></div><div class='row'><span class='label'>Buy Price</span><span class='value'>" +  item.BuyPrice + "</span></div><div class='row'><span class='label'>Sell Price</span><span class='value'>" +  item.SellPrice + "</span></div></div>").dialog({ title: "Details for " + item.Name });
	}
}

function FilterItemTypes(itemSlotType){
	var currentItem = {};
	var itemSelection = $("#itemSelection").empty();
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

function ProcessPurchase(data){
	if(data.Result == vc.ER_SUCCESS){
		var item = data.Data;	
		MyCharacter.Inventories["Personal"][MyCharacter.Inventories["Personal"].length] = item;
		MyCharacter.Gold -= item.BuyPrice;
		vc.i.UpdateStats();
		BuildInitialInventory();
		BuildInventoryLists();
		BuildGameWindow()
	}
}

function ProcessSale(data, ItemId){
	if(data.Result == vc.ER_SUCCESS){
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
		vc.i.UpdateStats();
		BuildInitialInventory();
		BuildInventoryLists();
		BuildGameWindow()
	}
}

function BuildShrine(topWindow){
	var myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
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
	$("#itemsWindow").html('');
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

					if(currentInventory[i].ItemId !== null){
						item = currentInventory[i];
						$("<option value='" + item.ItemId + "' selected='selected'>" + item.Name + "</option>").prependTo($select);
					}
					
					$("#itemsWindow").append($selectRow);
				}
			}
		}
	}
	
	$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-432)+'px'});
}

function LoadInventory(data){
	if(data.Result == vc.ER_SUCCESS){
		window.MyCharacter.Inventories["Personal"] = data.Data;
		BuildInitialInventory();
		BuildInventoryLists();
	}
	
	BuildMap();
	$("#loading").animate({ opacity: 0 }, 500, function(){ $("#loading").remove(); });
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

function InsertChat(data, channel){
	var $chatWindow = $("#chatChannels input[value='" + channel + "']").parent();
	var $chatTab = $("a[href='#" + $chatWindow.attr("id") + "']").parent();
	
	if(data[0] !== undefined && data[0].Type !=vc.ch.CHAT_TYPE_MOTD && !$chatTab.hasClass("ui-tabs-selected")){
		$chatTab.addClass("newMessage");
	}
	
	for(x = 0; x < data.length; x++){
		
		var chatobj = data[x];
		if(chatobj !== undefined){
			switch(chatobj.Type){
				case vc.ch.CHAT_TYPE_GENERAL:
					var msg = $("<span class='message' />").text(chatobj.Message);
					$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
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
		
		switch(chatobj.Message.MessageType){
			case 0:
				DisplayChannelStatusUpdate(chatobj.Message, chatobj);
				break;
				
			case 1:
				var fightResults = {};
				
				if($("#pvpMessage").length > 0){
					fightResults = $("#pvpMessage");
				}else{
					fightResults = $("<div id='pvpMessage' class='fightResults' />");
				}
				
				BuildAttackMessage(chatobj.Message.BattleData, chatobj.Message.AttackedBy, false, fightResults).dialog({ title: "You Were Attacked!", modal: true, close:function(e){ $("#pvpMessage").remove() } });
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
	var attackClass = ["player","enemy"]
	var damageLabel = ["attacked", "casted", "healed"]
	var name = "";
	var battleResult = {};
	var round = $("<div class='round' />");
	var battleObject = Attack;
	
	if(PlayerIsAttacker){
		myActor = 0;
		enemyActor = 1;
	}else{
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
			if(battleObject.Special !== undefined && battleObject.Special > 0){
				special = " <span class='monsterType " + vc.MonsterSpecialTypes[battleObject.Special] + "'>" + vc.MonsterSpecialTypes[battleObject.Special] + "</span>";
			}
			
			if(bo.Type == 2){
				if(bo.Actor == myActor){
					MyCharacter.Health += bo.Damage;
					
					if(MyCharacter.Health > MyCharacter.Vitality){
						MyCharacter.Health = MyCharacter.Vitality;
					}
					
					vc.i.UpdateHealth();
				}
			}else{
				if(bo.Actor != myActor){
					MyCharacter.Health -= bo.Damage;
					vc.i.UpdateHealth();
				}
			}
			
			if(myActor == 1){
				attackClass = ["enemy", "player"]
			}

			var displaySpecial = special;
			if(bo.Actor == myActor){
				displaySpecial = "";
			}
			if(bo.Damage > 0){
				battleResult = $("<p class='result'><span class='attacker " + attackClass[bo.Actor] + "'>" + name + "</span>" + displaySpecial + " " + damageLabel[bo.Type] + " for <span class='damage'>" + bo.Damage + "</span></p>");
			}else{
				battleResult = $("<p class='result'><span class='attacker " + attackClass[bo.Actor] + "'>" + name + "</span>" + displaySpecial + " <span class='damage'>missed</span></p>");
			}
			
			round.append(battleResult);
		}
	}
	
	fightResults.append(round);
	
	if(battleObject.Winner !== undefined){
		if(battleObject.Winner == myActor){
		
			if(!PlayerIsAttacker){
				fightResults.append("<div class='result wonFight'><span class='attacker player'>You</span> have successfully defended yourself!</span></div>");
			}else{
				fightResults.append("<div class='result wonFight'><span class='attacker player'>You</span> have defeated <span class='enemy'>" + EnemyName + "</span>" + special + "!</span></div>");
			}
			
			if(battleObject.Gold !== undefined){
				MyCharacter.Gold += battleObject.Gold;
			}
			
			if(battleObject.Experience !== undefined){
				MyCharacter.Experience += battleObject.Experience;
			}
			
			if(battleObject.AlignGood !== undefined){
				MyCharacter.AlignGood = battleObject.AlignGood;
			}
			
			if(battleObject.AlignOrder !== undefined){
				MyCharacter.AlignOrder = battleObject.AlignOrder;
			}
			
			if(battleObject.LevelUp !== undefined && battleObject.LevelUp == true){
				fightResults.append("<div class='result levelUp'><span class='attacker player'>You</span> have levelled up! <a href='#' class='chooseStats button'>Choose Stats</a></span></div>");
				MyCharacter.FreeLevels++;
			}
			vc.i.UpdateStats();
		}else{
			fightResults.append("<div class='result lostFight'><span class='attacker enemy'>You</span> were defeated!</span></div>");
			MyCharacter.Health = 0;
			MyCharacter.Gold = 0;
			vc.i.UpdateStats();
		}
	}
	
	return fightResults;
}

function DisplayChannelStatusUpdate(ChannelInfo, chatobj){
	var $chatWindow = $("input[value='" + ChannelInfo.ChannelId + "']").parent();
	
	if(window.MyCharacter.Channels[ChannelInfo.ChannelId] === undefined){
		$("<div class='chatMessage system'>" + chatobj.FromName + " invited you to join <span class='channelName'>" + ChannelInfo.Name + "</span>! <a href='#' class='joinChannel'>Click here to join.</a></div>").dialog({ title: "Chat Room Invitation" });
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

function SubmitMessage(){
	var chatbox = $("#chatInput");
	var message = chatbox.val();
	var msgobj = vc.ch.Utilities.ParseMessage(message);
	
	if(!msgobj.NonMessageCommand){
		vc.ch.SendMessageToChannel(MyCharacter.CurrentChannel, message, function(){});
		InsertChat([{ "Type": msgobj.Type, "FromName": MyCharacter.Name, "Message": msgobj.Message }], window.MyCharacter.CurrentChannel);
	}else{
		if(msgobj.Type = vc.cmd.ACTION_CHANNEL_SETRIGHTS){
			var rights = vc.ch.Utilities.ParseRights(msgobj.Message);
			vc.ch.SetRights(window.MyCharacter.CurrentChannel, rights.Character, rights.Rights, function(){});
		}
	}
	
	chatbox.val('');
}

function GetFullMonsterId(id){
	var monsterId = "MONS_00000000000000000000001";
	var myLocation = MyCharacter.CurrentMap.Places[MyCharacter.PositionY][MyCharacter.PositionX];
	monsterId = monsterId.substr(0, monsterId.length - (id + "").length) + myLocation.Monsters[m];
	return monsterId;
}

function Logout(data){
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