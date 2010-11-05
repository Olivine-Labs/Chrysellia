$(function(){
	window.chatTabIndex = 0;
	window.GENERALCHATID = "CHAN_00000000000000000000001";
	window.TRADECHATID = "CHAN_00000000000000000000002";
	
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	$("#chatForm").submit(function(e){
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
		if(channelId != GENERALCHATID && channelId !=  TRADECHATID){
			window.ChatToCloseIndex = $('li',$tabs).index($(this).parent()); 
			vc.ch.PartChannel(channelId, function(){ $tabs.tabs('remove', window.ChatToCloseIndex); });
		}
	});
	
	$("#createChannelForm").dialog({ autoOpen: false, title:"Create Chat Channel", width: 400 });
	$("#joinChannelForm").dialog({ autoOpen: false, title:"Join Chat Channel", width: 400 });
	
	$("#createChannelForm form").submit(function(e){
		e.preventDefault();
		
		var channelName = $("#cc_channelName").val();
		var channelMotd = $("#cc_channelMOTD").val();
		
		vc.ch.CreateChannel(channelName, channelMotd, CreateChannel)
	});
	
	$("#joinChannelForm form").submit(function(e){
		e.preventDefault();
		var channelName = $("#jc_channelName").val();
		vc.ch.JoinChannel(channelName, JoinChannel);
	});
	
	$("#quickLoginForm .button").click(function(e){
		e.preventDefault();
		vc.as.Logout(Logout);
	});
	
	$("#createChannelLink").click(function(){ $("#createChannelForm").dialog("open"); });
	$("#joinChannelLink").click(function(){ $("#joinChannelForm").dialog("open"); });
	
	$("#moveNW").button({ icons: { primary: "ui-icon-arrowthick-1-nw" }, text: false });
	$("#moveN").button({ icons: { primary: "ui-icon-arrowthick-1-n" }, text: false });
	$("#moveNE").button({ icons: { primary: "ui-icon-arrowthick-1-ne" }, text: false });
	$("#moveW").button({ icons: { primary: "ui-icon-arrowthick-1-w" }, text: false });
	$("#moveE").button({ icons: { primary: "ui-icon-arrowthick-1-e" }, text: false });
	$("#moveSW").button({ icons: { primary: "ui-icon-arrowthick-1-sw" }, text: false });
	$("#moveS").button({ icons: { primary: "ui-icon-arrowthick-1-s" }, text: false });
	$("#moveSE").button({ icons: { primary: "ui-icon-arrowthick-1-se" }, text: false });
	
	$("#movementform button").click(function(e){
		e.preventDefault();
		
		SetEnableMovement(false);
		
		$this = $(this);
		
		var x = ($this.siblings(".x").val() *1) + MyCharacter.PositionX *1;
		var y = ($this.siblings(".y").val() *1) + MyCharacter.PositionY *1;
		
		if(x > (MyCharacter.CurrentMap.DimensionX -1) || MyCharacter.PositionX < 0){
			x = MyCharacter.PositionX ;
		}
		
		if(y > (MyCharacter.CurrentMap.DimensionY -1) || y < 0){
			y = MyCharacter.PositionY ;
		}
		
		vc.ms.Move(x, y, RefreshMap);
		
		window.setTimeout(function(){SetEnableMovement(true)}, 1000);
	});
});

function RefreshMap(data){
	if(data.Result == ER_SUCCESS){
		MyCharacter.PositionX = data.Data.X;
		MyCharacter.PositionY = data.Data.Y;
		BuildMap();
	}
}

function SetEnableMovement(enabled){
	$("#movementform button").button("option", "disabled", !enabled);
}

function CreateChannel(data){
	if(data.Result == ER_SUCCESS){
		$("#cc_channelName").val('');
		$("#cc_channelMOTD").val('');
		$("#createChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId);
		window.MyCharacter.CurrentChannel = data.Data.ChannelId;
	}else if(data.Result == ER_ALREADYEXISTS){
		alert("Channel name already exists!");
	}else{
		alert("An error has occured.");
	}
}

function JoinChannel(data){
	if(data.Result == ER_SUCCESS){
		$("#jc_channelName").val('');
		$("#cc_channelMOTD").val('');
		$("#joinChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId, data.Data.Motd);
	}else if(data.Result == ER_ALREADYEXISTS){
		alert("Channel name already exists!");
	}else{
		alert("An error has occured.");
	}
}

function AddTab(title, channelId, motd) {
	$tabs.tabs('add', '#channelTabs-'+chatTabIndex, title);
	$("<input type='hidden' value='" + channelId + "' class='channelId' />").appendTo($('#channelTabs-'+chatTabIndex));
	InsertChat([{ "Type": 999, "FromName": "", "Message": motd }], channelId);
	chatTabIndex++;
}

function FillChat(list){
	if(list.Result == ER_SUCCESS){
		for(var i in list.Data){
			InsertChat(list.Data[i], i);
		}
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, FillChat); }, 3000);
}

function SelectCharacter(data){
	window.MyCharacter = new Character();
	
	if(data.Result == ER_SUCCESS){
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
}

function BuildMap(){
	$("#currentMapName").text(MyCharacter.CurrentMap.Name);
	$("#currentX").text(MyCharacter.PositionX);
	$("#currentY").text(MyCharacter.PositionY);
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

function InsertChat(data, channel){
	var $chatWindow = $("input[value='" + channel + "']").parent();
	
	for(x = 0; x< data.length; x++){
		var chatobj = data[x];
		var msg = $("<span class='message' />").text(chatobj.Message);
		switch(chatobj.Type){
			case 0:
				$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
				break;
			
			case 1:
				$("<div class='chatMessage emote'>" + chatobj.FromName + " </div>").append(msg).prependTo($chatWindow);
				break;
			case 999: //motd
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
		if(msgobj.Type = ACTION_CHANNEL_SETRIGHTS){
			var rights = vc.ch.Utilities.ParseRights(msgobj.Message);
			vc.ch.SetRights(window.MyCharacter.CurrentChannel, rights.Character, rights.Rights, function(){});
		}
	}
	
	chatbox.val('');
}