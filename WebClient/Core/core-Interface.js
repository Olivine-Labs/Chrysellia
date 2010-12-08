(function( window, undefined ) {
	var Interface = function (){};
	
	Interface = Interface.prototype = {
		UpdateStats: function() {
			$("#myCharactV2Core.ER_Name").text(window.MyCharacter.Name);
			$("#myCharactV2Core.ER_Strength").text(window.MyCharacter.Strength);
			$("#myCharactV2Core.ER_Dexterity").text(window.MyCharacter.Dexterity);
			$("#myCharactV2Core.ER_Wisdom").text(window.MyCharacter.Wisdom);
			$("#myCharactV2Core.ER_Intelligence").text(window.MyCharacter.Intelligence);
			$("#myCharactV2Core.ER_Vitality").text(window.MyCharacter.Vitality);
			$("#myCharactV2Core.ER_Gold").text(window.MyCharacter.Gold);
			$("#myCharactV2Core.ER_Experience").text(window.MyCharacter.Experience);
			$("#myCharactV2Core.ER_Level").text(window.MyCharacter.Level);
		}
	}
	
	V2Core.Interface = V2Core.i = Interface;
})(window);