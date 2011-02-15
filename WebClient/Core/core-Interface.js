(function( window, undefined ) {
	var Interface = function (){};
	
	Interface = Interface.prototype = {
		UpdateStats: function() {
			var mc = window.MyCharacter;
			
			$("#myCharacter_Name").text(mc.Name);
			$("#myCharacter_Strength").text(mc.Strength);
			$("#myCharacter_Dexterity").text(mc.Dexterity);
			$("#myCharacter_Wisdom").text(mc.Wisdom);
			$("#myCharacter_Intelligence").text(mc.Intelligence);
			$("#myCharacter_Vitality").text(mc.Vitality);
			$("#myCharacter_Gold, #myCharacter_CurrentGold").text(mc.Gold);
			$("#myCharacter_ExperienceBar").progressbar("value", (mc.Experience / mc.NextLevelAt()) * 100).attr("title", mc.Experience + " / " + mc.NextLevelAt());
			$("#myCharacter_HealthBar").progressbar("value", ((mc.Health / mc.Vitality) * 100)).attr("title", mc.Health + " / " + mc.Vitality);
			$("#myCharacter_LevelTitle, #myCharacter_Level").text(mc.Level);
			$("#myCharacter_FreeLevels").text(mc.FreeLevels);
			$("#myCharacter_Health").text(mc.Health);
			$("#myCharacter_Experience").text(mc.Experience);
			$("#myCharacter_Bank").text(mc.Bank);
			
			var alignName = mc.AlignName();
			var alignClass = "neutral";
			if(alignName.indexOf("Good") > -1){
				alignClass = "good";
			}else if(alignName.indexOf("Evil") > -1){
				alignClass = "evil";
			}
			
			$("#myCharacter_Alignment").text(alignName + " (" + mc.AlignGood + " / " + mc.AlignOrder + ")").siblings(".statLabel").addClass(alignClass);
			
			if(MyCharacter.FreeLevels > 0){
				$("#statsWindow button, #statsWindow .all").show();
			}
		},
		
		UpdateHealth: function(){
			var mc = window.MyCharacter;
			$("#myCharacter_HealthBar").progressbar("value", ((mc.Health / mc.Vitality) * 100)).attr("title", mc.Health + " / " + mc.Vitality);
			$("#myCharacter_Health").text(mc.Health);
		}
	}
	
	V2Core.Interface = V2Core.i = Interface;
})(window);
