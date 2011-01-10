(function( window, undefined ) {
	var Interface = function (){};
	
	Interface = Interface.prototype = {
		UpdateStats: function() {
			$("#myCharacter_Name").text(window.MyCharacter.Name);
			$("#myCharacter_Strength").text(window.MyCharacter.Strength);
			$("#myCharacter_Dexterity").text(window.MyCharacter.Dexterity);
			$("#myCharacter_Wisdom").text(window.MyCharacter.Wisdom);
			$("#myCharacter_Intelligence").text(window.MyCharacter.Intelligence);
			$("#myCharacter_Vitality").text(window.MyCharacter.Vitality);
			$("#myCharacter_Gold").text(window.MyCharacter.Gold);
			$("#myCharacter_Experience").progressbar("value", (((window.MyCharacter.Experience*1 - vc.CalculateLevelRequiredExp(window.MyCharacter.Level-1, 0)) / (window.MyCharacter.NextLevelAt() - vc.CalculateLevelRequiredExp(window.MyCharacter.Level-1, 0)) ) * 100)).attr("title", window.MyCharacter.Experience + " / " + window.MyCharacter.NextLevelAt());
			$("#myCharacter_Health").progressbar("value", ((window.MyCharacter.Health / window.MyCharacter.Vitality) * 100)).attr("title", window.MyCharacter.Health + " / " + window.MyCharacter.Vitality);
			$("#myCharacter_Level").text(window.MyCharacter.Level);
			
			if(MyCharacter.FreeLevels > 0){
				$("#statsWindow button, #statsWindow .stat.all").show();
			}
		},
		
		UpdateHealth: function(){
			$("#myCharacter_Health").progressbar("value", ((window.MyCharacter.Health / window.MyCharacter.Vitality) * 100)).attr("title", window.MyCharacter.Health + " / " + window.MyCharacter.Vitality);
		}
	}
	
	V2Core.Interface = V2Core.i = Interface;
})(window);
