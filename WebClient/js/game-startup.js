$(function(){
	vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat);
	window.setInterval(function(){ vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat); }, 1500);
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var chat = chatbox.val();
		vc.ch.SendMessageToChannel("CHAN_00000000000000000000001", chat, function(){});
		chatbox.val('');
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