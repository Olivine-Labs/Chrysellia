$(function(){
	vc.cs.GetCurrentCharacter(SelectCharacter);
	vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat);
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var message = chatbox.val();
		vc.ch.SendMessageToChannel("CHAN_00000000000000000000001", message, function(){});
		chatbox.val('');
		
		var msgobj = vc.ch.Utilities.ParseMessage(message);
		
		if(msgobj.Type == 0){
			var msg = $("<span class='message' />").text(msgobj.Message);
			$("<div class='chatMessage'><strong>" + MyCharacter.Name() + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
		}else if(msgobj.Type == 1){
			var msg = $("<span class='message' />").text(msgobj.Message);
			$("<div class='chatMessage emote'>" + MyCharacter.Name() + " </div>").append(msg).prependTo($("#chatMessages"));
		}
	});
});

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, c) {
			if(c.Type == 0){
				var msg = $("<span class='message' />").text(c.Message);
				$("<div class='chatMessage'><strong>" + c.FromName + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
			}else{
				var msg = $("<span class='message' />").text(c.Message);
				$("<div class='chatMessage emote'>" + c.FromName + " </div>").append(msg).prependTo($("#chatMessages"));
			}
		}); 
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat); }, 3000);
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
}