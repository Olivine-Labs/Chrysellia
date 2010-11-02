

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
		insertChat([{ "Type": msgobj.Type, "FromName": MyCharacter.Name, "Message": msgobj.Message }], window.MyCharacter.CurrentChannel);
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
	})
});

function addTab(title, channelId) {
	$tabs.tabs('add', '#channelTabs-'+chatTabIndex, title);
	$("<input type='hidden' value='" + channelId + "' class='channelId' />").appendTo($('#channelTabs-'+chatTabIndex));
	chatTabIndex++;
}

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		for(var i in list.Data){
			insertChat(list.Data[i], i);
		}
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, fillChat); }, 3000);
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
		addTab(window.MyCharacter.Channels[i], i);
	}
	
	$tabs.tabs('select', 0);
	
	vc.ch.GetMessagesFromChannel(i, fillChat);
}

function insertChat(data, channel){
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