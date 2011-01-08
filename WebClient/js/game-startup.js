$(function(){
	window.chatTabIndex = 0;
	
	$("#myCharacter_Experience").progressbar();
	
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
		
		vc.ch.CreateChannel(channelName, channelMotd, CreateChannel)
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
	$("#moveLook").button({ icons: { primary: "ui-icon-search" }, text: false });
	
	$("#movementform button").bind("click", function(e){
		e.preventDefault();
		$this = $(this);
		
		if($this.hasClass("look")){
			
		}else{
			SetEnableMovement(false);
			var dirx = $this.siblings(".x").val() *1;
			var diry = $this.siblings(".y").val() *1;
			var x = dirx + MyCharacter.PositionX *1;
			var y = diry + MyCharacter.PositionY *1;
			
			if(x > (MyCharacter.CurrentMap.DimensionX -1) || MyCharacter.PositionX < 0){
				x = MyCharacter.PositionX ;
			}
			
			if(y > (MyCharacter.CurrentMap.DimensionY -1) || y < 0){
				y = MyCharacter.PositionY ;
			}
			
			vc.ms.Move(x, y, RefreshMap);
			
			if(dirx+diry == 1 || dirx + diry == -1){
				window.setTimeout(function(){SetEnableMovement(true)}, 750);
			}else{
				window.setTimeout(function(){SetEnableMovement(true)}, 1060);
			}
		}
	});
	
	$("#statsWindow").dialog({ title: "Character Stats", autoOpen: false });
	$("#itemsWindow").dialog({ title: "Inventory", modal: true, autoOpen: false});
	
	$(".accountActions .logOut").bind("click", function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	$("#statsWindowButton").bind("click", function(e){
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
			vc.is.Equip($this.val(), slotType, slotIndex, EquipItem);
		}
	});
	
	$(window).resize(function(){
		$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-412)+'px'});
	});
	
	$("#statsWindow button").bind("click", function(e){
		e.preventDefault();
		switch($(this).parent().attr("class")){
			case "stat str":
				
				break;
			
			case "stat dex":
				
				break;
			
			case "stat vit":
				
				break;
			
			case "stat wis":
				
				break;
			
			case "stat int":
				
				break;
			
			case "stat all":
				
				break;
			
		}
	});
});

function EquipItem(data, itemId, slotType, slotIndex){
	if(data.Result == vc.ER_SUCCESS){
		var item = {};
		var typeMapping = vc.is.TypeMapping;
		
		for(var i in window.MyCharacter.Inventories["Personal"]){
			if(window.MyCharacter.Inventories["Personal"][i].ItemId = itemId){
				window.MyCharacter.Equipment[slotType][slotIndex] = window.MyCharacter.Inventories["Personal"][i];
				delete window.MyCharacter.Inventories["Personal"][i];
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
			if(i!=0){
				InsertChat(list.Data[i], i);
			}else{
				ProcessSystemMessage(list.Data[0]);
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
		AddTab(window.MyCharacter.Channels[i].Name, i, window.MyCharacter.Channels[i].Motd);
	}
	
	$tabs.tabs('select', 0);
	BuildMap();
	BuildInitialInventory();
	
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
	var window = $("#topCenter");
	window.html('');
	
	if(myLocation.Type === undefined){
		if(myLocation.Monsters !== undefined){
			var container = $("<form id='fightForm'><h1>Fight!</h1><span class='attackLabel'>Attack:</span></form>");
			var select = $("<select id='monsterList' />");
			select.appendTo(container);
			
			$("<button type='submit' id='attackButton' class='button attack'>Attack</button>").bind("click", function(e){ e.preventDefault(); AttackMonster(0); }).button().appendTo(container);
			$("<button type='submit' id='castButton' class='button cast'>Cast</button>").bind("click", function(e){ e.preventDefault(); AttackMonster(1); }).button().appendTo(container);
			
			var monster = {};
			var option = {};

			for(m in myLocation.Monsters){
				monster = V2Core.Monsters[myLocation.Monsters[m]];
				option = $("<option value='" + monster.Id + "'>" + monster.Name + "</option>").appendTo(select);
			}
			
			container.appendTo(window);
			
			var fightResults = $("<div id='fightResults'></div>");
			fightResults.appendTo(window);
		}
	}
}

function AttackMonster(fightType){
	SetEnableAttack(false); 
	window.setTimeout(function(){SetEnableAttack(true)}, 1500);
	var monsterId = $("#monsterList").val();
	
	if(MyCharacter.CurrentBattle !== undefined){
		if(MyCharacter.CurrentBattle.State == 2){
			fightResults.html('');
		}
		
		if(MyCharacter.CurrentBattle.State == 3){
			alert("You can't fight! You're dead!");
			return;
		}
		
		if(MyCharacter.CurrentBattle.Monster == V2Core.Monsters[monsterId]){
			MyCharacter.CurrentBattle.State = 1;
		}else{
			MyCharacter.CurrentBattle = { Monster: V2Core.Monsters[monsterId], State: 0 }
		}
	}else{
		MyCharacter.CurrentBattle = { Monster: V2Core.Monsters[monsterId], State: 0 }
	}
	
	MyCharacter.CurrentBattle = { Monster: V2Core.Monsters[monsterId], State: 0 }
	vc.mn.Fight(monsterId, fightType, AttackRound);
}

function AttackRound(data){
	if(data.Result == vc.ER_SUCCESS){
		fightResults = $("#fightResults");
		
		var battleObject = data.Data;
		
		if(battleObject[0] != []){
			for(var x = 0; x < battleObject[0].length; x++){
				var damage = battleObject[0][x].Damage;
				var heal = battleObject[0][x].Heal;
				
				fightResults.append("<div class='result'><span class='attacker player'>You</span> attacked for <span class='damage'>" + battleObject[0][x].Damage + "</span></div>");
				
				if(heal > 0){
					fightResults.append("<div class='result'><span class='attacker player'>You</span> healed for <span class='damage'>" + battleObject[0][x].Heal + "</span></div>");
				}
			}
		}
		
		if(battleObject[1] != []){
			for(var x = 0; x < battleObject[1].length; x++){
				var damage = battleObject[1][x].Damage;
				var heal = battleObject[1][x].Heal;
				
				fightResults.append("<div class='result'><span class='attacker enemy'>You</span> were attacked for <span class='damage'>" + battleObject[1][x].Damage + "</span></div>");
				
				if(heal > 0){
					fightResults.append("<div class='result'><span class='attacker enemy'>" + MyCharacter.CurrentBattle.Monster.Name + "</span> healed for <span class='damage'>" + battleObject[1][x].Heal + "</span></div>");
				}
			}
		}
		
		if(battleObject.Winner !== undefined){
			if(battleObject.Winner == 0){
				fightResults.append("<div class='result wonFight'><span class='attacker player'>You</span> have defeated the " + MyCharacter.CurrentBattle.Monster.Name + "!</span></div>");
				MyCharacter.CurrentBattle.State = 2;
				MyCharacter.Gold += battleObject.Gold;
				MyCharacter.Experience += battleObject.Experience;
				
				vc.i.UpdateStats();
			}else{
				fightResults.append("<div class='result lostFight'><span class='attacker enemy'>You</span> were defeated!</span></div>");
				MyCharacter.CurrentBattle.State = 3;
			}
		}
		
		if(battleObject.LevelUp !== undefined && battleObject.LevelUp == true){
			fightResults.append("<div class='result levelUp'><span class='attacker player'>You</span> have levelled up! Don't forget to add your stat points in the stats window!</span></div>");
			$("#statsWindow button, #statsWindow .stat.all").show();
		}
		
	}else if(data.Result == vc.ER_ACCESSDENIED){
		
	}
}

function BuildInitialInventory(){
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
	
	$('#chatChannels .ui-tabs-panel').css({'height':(($(window).height())-412)+'px'});
}

function LoadInventory(data){
	if(data.Result == vc.ER_SUCCESS){
		var item = {};
		var typeMapping = vc.is.TypeMapping;
		window.MyCharacter.Inventories["Personal"] = data.Data;
		for(var i in MyCharacter.Inventories["Personal"]){
			item = MyCharacter.Inventories["Personal"][i];
			if(item !== undefined && item !== {}){
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
	
	for(x = 0; x< data.length; x++){
		var chatobj = data[x];
		
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

function ProcessSystemMessage(data){
	for(x = 0; x< data.length; x++){
		var chatobj = data[x];
		var ChannelInfo = chatobj.Message;
		
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

function Logout(data){
	FB.getLoginStatus(function(response) {
		if (!!response.session) {
			FB.logout();
		}
	});
	
	$.cookie("l",false);
	
	window.location = "./index.php";
}