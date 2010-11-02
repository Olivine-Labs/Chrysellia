$(function(){
	window.chatTabIndex = 0;
	window.GENERALCHATID = "CHAN_00000000000000000000001";
	window.TRADECHATID = "CHAN_00000000000000000000002";
	
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var message = chatbox.val();
		vc.ch.SendMessageToChannel(MyCharacter.CurrentChannel, message, function(){});
		chatbox.val('');
		
		var msgobj = vc.ch.Utilities.ParseMessage(message);
		InsertChat([{ "Type": msgobj.Type, "FromName": MyCharacter.Name, "Message": msgobj.Message }], window.MyCharacter.CurrentChannel);
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
	
	
	$("#createChannelLink").click(function(){ $("#createChannelForm").dialog("open"); });
	$("#joinChannelLink").click(function(){ $("#joinChannelForm").dialog("open"); });
});

function CreateChannel(data){
	if(data.Result == ER_SUCCESS){
		$("#cc_channelName").val('');
		$("#cc_channelMOTD").val('');
		$("#createChannelForm").dialog("close");
		AddTab(data.Data.Name, data.Data.ChannelId);
	}else if(data.Result == ER_ALREADYEXISTS){
		alert("Channel name already exists!");
	}else{
		alert("An error has occured.");
	}
}

function JoinChannel(data){
	
}

function AddTab(title, channelId, motd) {
	$tabs.tabs('add', '#channelTabs-'+chatTabIndex, title);
	$("<input type='hidden' value='" + channelId + "' class='channelId' />").appendTo($('#channelTabs-'+chatTabIndex));
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
		AddTab(window.MyCharacter.Channels[i].Name, i, i.Motd);
	}
	
	$tabs.tabs('select', 0);
	
	vc.ch.GetMessagesFromChannel(i, FillChat);
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
			
			default:
				$("<div class='chatMessage'><strong>" + chatobj.FromName + "</strong>: </div>").append(msg).prependTo($chatWindow);
				break;
		}
	}
}