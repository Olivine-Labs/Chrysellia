$(function(){
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var message = chatbox.val();
		vc.ch.SendMessageToChannel(MyCharacter.CurrentChannel, message, function(){});
		chatbox.val('');
		
		var msgobj = vc.ch.Utilities.ParseMessage(message);
		insertChat({ Type: msgobj.Type, FromName: MyCharacter.Name(), Message: msgobj.Message  });
	});
});

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, c) {
			insertChat(c);
		}); 
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
	
	vc.ch.GetMessagesFromChannel(MyCharacter.CurrentChannel, fillChat);
}

function insertChat(c){
	var msg = $("<span class='message' />").text(c.Message);
	
	switch(c.Type){
		case 0:
			$("<div class='chatMessage'><strong>" + c.FromName + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
			break;
		
		case 1:
			$("<div class='chatMessage emote'>" + c.FromName + " </div>").append(msg).prependTo($("#chatMessages"));
			break;
		
		default:
			$("<div class='chatMessage'><strong>" + c.FromName + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
			break;
	}
}