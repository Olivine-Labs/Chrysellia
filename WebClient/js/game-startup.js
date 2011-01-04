$(function(){
	window.chatTabIndex = 0;
	
	$("#myCharacter_Experience").progressbar();
	
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	$("#chatForm").bind("submit", function(e){
		e.preventDefault();
		SubmitMessage();
	});
	
	window.$tabs = $('#chatChannels').tabs({
		tabTemplate: '<li><a href="#{href}" class="chatChannelLabel}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
		add: function(event, ui) {
			$(ui.panel).append('<div />');
			$tabs.tabs('select', '#' + ui.panel.id);
		},
		select: function(event, ui){
			window.MyCharacter.CurrentChannel = $(".channelId", ui.panel).val();
		}
	});

	$('#chatChannels span.ui-icon-close').live('click', function() {
		var channelId = $(".channelId", $($(this).siblings("a").attr("href"))).val();
		if(channelId != vc.ch.StaticRooms["General"] && channelId !=  vc.ch.ChatService.StaticRooms["Trade"]){
			window.ChatToCloseIndex = $('li',$tabs).index($(this).parent()); 
			vc.ch.PartChannel(channelId, function(){ $tabs.tabs('remove', window.ChatToCloseIndex); });
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
		$("#statsWindow").dialog("open");
	});
	
	$("#itemsWindowButton").bind("click", function(e){
		$("#itemsWindow").dialog("open");
	});
});

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

function CreateChannel(data){
	if(data.Result == vc.ER_SUCCESS){
		$("#cc_channelName, #cc_channelMOTD").val('');
		$("#createChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId, data.Data.Motd);
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
	}else{
		alert("An error has occured.");
	}
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
			InsertChat(list.Data[i], i);
		}
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, FillChat); }, 3000);
}

function SelectCharacter(data){
	window.MyCharacter = new Character();
	
	if(data.Result == vc.ER_SUCCESS){
		window.MyCharacter.Construct(data.Data);
		vc.i.UpdateStats();
	}else{
		alert("Please login again.");
		window.location = "./index.html";
	}
	
	for(var i in window.MyCharacter.Channels){
		AddTab(window.MyCharacter.Channels[i].Name, i, window.MyCharacter.Channels[i].Motd);
	}
	
	$tabs.tabs('select', 0);
	BuildMap();
	
	vc.ch.GetMessagesFromChannel(i, FillChat);
	
	vc.is.GetInventory(LoadInventory);
}

function BuildMap(){
	$("#currentMapName").text(MyCharacter.CurrentMap.Name);
	$currentMap = $("#currentMap");
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
	
	$currentMap.css({ height: 30*MyCharacter.CurrentMap.DimensionY, width: 30*MyCharacter.CurrentMap.DimensionX })
}

function LoadInventory(data){
	if(data.Result == vc.ER_SUCCESS){
		MyCharacter.Inventories["Personal"] = data.Data;
		for(var i in MyCharacter.Inventories["Personal"]){
			var item = MyCharacter.Inventories["Personal"][i];
			var $opt = $("<option value='" + item.ItemId + "'>" + item.Name + "</option>");
			switch(item.SlotType){
				case 0:
					$opt.appendTo($("#lhSelection, #rhSelection"));
					break;
				
				case 1:
					$opt.appendTo($("#aSelection"));
					break;
				
				case 2:
					$opt.appendTo($("#s1Selection, #s2Selection"));
					break;
			}
		}
	}
}

function InsertChat(data, channel){
	var $chatWindow = $("input[value='" + channel + "']").parent();
	
	for(x = 0; x< data.length; x++){
		var chatobj = data[x];
		var msg = $("<span class='message' />").text(chatobj.Message);
		
		switch(chatobj.Type){
			case vc.ch.CHAT_TYPE_GENERAL:
				$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
				break;
			case vc.ch.CHAT_TYPE_EMOTE:
				$("<div class='chatMessage emote'>" + chatobj.FromName + " </div>").append(msg).prependTo($chatWindow);
				break;
			case vc.ch.CHAT_TYPE_MOTD: //motd
				$("<div class='chatMessage motd'></div>").append(msg).prependTo($chatWindow);
				break;
			default:
				$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
				break;
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
		if(msgobj.Type = cmd.ACTION_CHANNEL_SETRIGHTS){
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