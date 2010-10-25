$(function(){
	vc.cs.GetCurrentCharacter(SelectCharacter);
	vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat);
	
	$("#chatForm").submit(function(e){
		e.preventDefault();
		var chatbox = $("#chatInput");
		var message = chatbox.val();
		vc.ch.SendMessageToChannel("CHAN_00000000000000000000001", message, function(){});
		chatbox.val('');
		
		var msg = $("<span class='message' />").text(message);
		$("<div class='chatMessage'><strong>" + MyCharacter.Name() + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
	});
});

function fillChat(list){
	if(list.Result == ER_SUCCESS){
		$.each(list.Data, function(index, c) {
			var msg = $("<span class='message' />").text(c.Message);
			$("<div class='chatMessage'><strong>" + c.FromName + "</strong>: </div>").append(msg).prependTo($("#chatMessages"));
		}); 
	}
	
	$(".chatMessage:nth-child(n+50)").remove();
	
	window.setTimeout(function(){ vc.ch.GetMessagesFromChannel("CHAN_00000000000000000000001", fillChat); }, 3000);
}

function SelectCharacter(data){
	window.MyCharacter = new Character();
	window.MyCharacter.Construct(data.Result);
	
	if(data.Result == ER_SUCCESS){
		window.MyCharacter.Construct(data.Data);
		var name = $("<div class='charName'>" + window.MyCharacter.Name() + "</div>");
		var str = $("<div class='stat'>Str: " + window.MyCharacter.Strength + "</div>"); 
		var dex = $("<div class='stat'>Dex: " + window.MyCharacter.Dexterity + "</div>"); 
		var wis = $("<div class='stat'>Wis: " + window.MyCharacter.Wisdom + "</div>"); 
		var inte = $("<div class='stat'>Int: " + window.MyCharacter.Intelligence + "</div>"); 
		var vit = $("<div class='stat'>Vit: " + window.MyCharacter.Vitality + "</div>"); 
		var gold = $("<div class='stat'>Gold: " + window.MyCharacter.Gold + "</div>"); 
		var exp = $("<div class='stat'>Exp: " + window.MyCharacter.Experience + "</div>"); 
		var level = $("<div class='stat'>Level: " + window.MyCharacter.Level + "</div>"); 
		var statsPanel = $("<div class='stats'></div>");
		statsPanel.append(name).append(str).append(dex).append(wis).append(inte).append(vit).append(gold).append(exp).append(level);
		statsPanel.appendTo($("#topLeft"));
		
	}else{
		alert("Please login again.");
		window.location = "./index.html";
	}
}