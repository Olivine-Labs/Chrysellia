$(function(){
	vc.cs.GetCurrentCharacter(SelectCharacter);
	
	vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat);
	window.setInterval(function(){ vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat); }, 1500);
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var message = chatbox.val();
		vc.ch.SendMessageToChannel("CHAN_00000000000000000000001", message, function(){});
		chatbox.val('');
		
		$("<div class='chatMessage'><strong>" + MyCharacter.Name + "</strong>: " + message + "</div>").prependTo($("#chatMessages"));
	});
});

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, c) {
			$("<div class='chatMessage'><strong>" + c.FromName + "</strong>: " + c.Message + "</div>").prependTo($("#chatMessages"));
		}); 
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
}

function SelectCharacter(data){
	window.MyCharacter = new Character();
	window.MyCharacter.Construct(data.Result);
	
	if(data.Result == ER_SUCCESS){
		window.MyCharacter.Construct(data.Data);
	}else{
		alert("Please login again.");
		window.location = "./index.html";
	}
}