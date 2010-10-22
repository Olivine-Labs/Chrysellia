$(function(){
	vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat);
	window.setInterval(function(){ vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat); }, 5000);
	
	$("#chatInputButton").click(function(){
		var chatbox = $("#chatInput");
		var chat = chatbox.val();
		vc.ch.SendMessageToChannel("CHAN_00000000000000000000001", chat, function(){});
		chatbox.val('');
	});
});

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, c) {
			$("<div><strong>" + c.FromName + "</strong>: " + c.Message + "</div>").prependTo($("#chatMessages"));
		}); 
	}
}