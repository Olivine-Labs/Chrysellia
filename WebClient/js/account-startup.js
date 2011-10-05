(function(){
  function UpdateNameAvailability(r){
    if(r.Result === vc.ER_SUCCESS){
      $("#c_checkName_status").removeClass("unavailable").addClass("available");
    }else{
      $("#c_checkName_status").removeClass("available").addClass("unavailable");
    }
  }

  function Logout(data){
    $.cookie("l",false);
    
    window.location = "./index.php";
  }

  function CurrentStatBalance(){
    var used = 0;
    
    $(".statChooser").each(function(){
      used += ($(this).text() *1);
    });
    
    var total = 0;
    var race = V2Core.Races[$("#c_race").val()];
    total += race.Str;
    total += race.Dex;
    total += race.Int;
    total += race.Wis;
    total += race.Vit;

    return 25 - (used - total);
  }

  function UpdateCreateCharacterStats(ui, e){
    var $remPoints = $("#remPoints");
    var currentBalance = CurrentStatBalance();
    var currentStatValue = 0;
    var currentStatMax = 0;
    var currentStatMin = 0;
    var raceBaseStat = 0;
    
    if(ui.hasClass("minus")){
      currentStatValue = ui.siblings(".statChooser").text() *1;
      currentStatMin = ui.siblings("em").children(".raceBaseStat").text() * 1;
      
      if(currentStatValue-1 >= currentStatMin){
        ui.siblings(".statChooser").text(currentStatValue-1);
      }
    }else if(ui.hasClass("plus")){
      currentStatValue = ui.siblings(".statChooser").text() *1;
      currentStatMax = ui.siblings("em").children(".statMax").text() * 1;
      
      if(currentStatValue + 1 <= currentStatMax && currentBalance > 0){
        ui.siblings(".statChooser").text(currentStatValue+1);
      }
    }
    
    currentBalance = CurrentStatBalance();
    if(currentBalance > 25 || currentBalance < 0){
      $remPoints.text(currentBalance).parent().addClass("ui-state-highlight");
    }else{
      $remPoints.text(currentBalance).parent().removeClass("ui-state-highlight");
    }
  }

  function LoadCharacterList(list){
    $login = $("#logIn");
    $(".character", $login).remove();
    if(list.Result == vc.ER_SUCCESS){
      $.each(list.Data, function(index, charData) {
        var c = new Character();
        c.Construct(charData);
        
        var level = c.Level || 1;
        
        var x = c.PositionX || 0;
        var y = c.PositionY || 0;
        
        $('<div class="character"><input type="hidden" value="' + c.CharacterId + '" class="c_id" /><input type="hidden" value="' + c.HasPin + '" class="c_haspin" /><a class="button bigButton" href="#"><span class="characterPortrait ' + c.RaceName().replace(/ /g,'') + '"></span><span class="characterName">' + c.Name + '</span> <span class="characterStats">Lvl ' + level + ' ' + c.AlignName() + " " + c.RaceName() + '</span><ul class="recentActivity"><li class="ra_gold"><span class="icon gold"></span><span>' + c.Gold + '</span></li><li class="ra_location">Located at ' + x + ', ' + y + ' ' + c.CurrentMap.Name + '</li><li class="ra_created">Created: ' + c.CreatedOn + '</li></ul></a></div>').appendTo($login);
      });
    }else{
      if($.cookie("l") == "true"){
        vc.as.Logout(Logout);
      }
      
      $.cookie("l", "false");
      
      alert("Please login again.");
      window.location = "./index.php";
    }
    
    if(list.Data.length === 0){
      var text = "<p>Often times we view the past as the golden years. Years in which the world was just better, things worked the way they were supposed to. Logic prevailed and insanity was not as close to home as is in the now. At few moments in history do these feelings, this nostalgia, actually hold any meaning in the real world. Few are the times in which today really is worse than yesterday.</p><p>According to the survivors, Neflaria was once a rich continent filled with wonders beyond the dreams of even the most imaginative minds, the pinnacle of civilization. When taken with a grain of salt, we see that this land truly was once prosperous and free of the oppression of evil. As a fledgeling historian, I have tasked myself with solving the riddle that is this land we now live in and what caused the loss of so many priceless objects and more importantly, knowledge. Many survivors speak of the great libraries in Ta'Lorn, the kingdom of light, and the fantastic implements of war created by the Dwarves in their mountain kingdom of Asbarun. Although there is much history in the greatness that was before, I have yet to discover a soul willing to divulge the great evils that brought this once fantastic land to it's proverbial knees.</p><p>My journey begins in Ta'Lorn, where hopefully I will find some clue as the the fate of this once great kingdom...</p>";
      $("<div>" + text + "</div>").dialog({ modal: true, title: "Welcome to Chrysellia", width: 450, height: 400 });
    }
  }

  function SelectCharacter(chardata){
    switch(chardata.Result){
      case vc.ER_SUCCESS:
        $("#accountSelection").fadeOut(500, function(){ window.location = "./game.php"; });
        break;
      case vc.ER_BADDATA:
      case vc.ER_MALFORMED:
      case vc.ER_DBERROR:
        alert("Please check name length and try again.");
        break;
      case vc.ER_ACCESSDENIED:
        alert("Incorrect PIN Number.");
        break;
      default:
        alert("An error has occured. Try again later.");
        break;
    }
  }

  $(function(){
    $(".button.plus").button({ icons: { primary: "ui-icon-circle-plus" }, text: false });
    $(".button.minus").button({ icons: { primary: "ui-icon-circle-minus" }, text: false });
    
    var r = {};
    var $race = {};

    for(var i in V2Core.Races){
     
      if(V2Core.Races.hasOwnProperty(i)){
        r = V2Core.Races[i];		
        $race = $('<li class="character raceList"><a class="button bigButton" href="#"><input type="hidden" value="' + i + '" class="r_id" /><span class="characterPortrait ' + r.Name.replace(/ /g,'') + '"></span><span class="characterName">' + r.Name + '</span><span class="raceStats"><span class="icon str" title="Strength"></span><span>' + r.Str + '</span><br /><span class="icon dex" title="Dexterity"></span><span>' + r.Dex + '</span><br /><span class="icon int" title="Intelligence"></span><span>' + r.Int + '</span><br /><span class="icon wis" title="Wisdom"></span><span>' + r.Wis + '</span><br /><span class="icon vit" title="Vitality"></span><span>' + r.Vit + '</span><br /></span><span class="description">' + r.Description + '</span></a></li>');
        
        if(r.Align == "good"){
          $race.appendTo($("#goodRaces ul"));
        }else{
          $race.appendTo($("#evilRaces ul"));
        }
      }
    }
    
    $("#statSelection").dialog({ 
      modal: true, 
      title: "Select Stats", 
      width: 400, 
      height: 420, 
      autoOpen: false, 
      buttons: { 
        "Create Character": function() { 
          var str = ($("#startingStr").text() * 1) - V2Core.Races[$("#c_race").val()].Str;
          var dex = ($("#startingDex").text() * 1) - V2Core.Races[$("#c_race").val()].Dex;
          var intel = ($("#startingInt").text() * 1) - V2Core.Races[$("#c_race").val()].Int;
          var wis = ($("#startingWis").text() * 1) - V2Core.Races[$("#c_race").val()].Wis;
          var vit = ($("#startingVit").text() * 1) - V2Core.Races[$("#c_race").val()].Vit;

          if((str + dex + intel + wis + vit) != 25){
            $(".selectStats > em").addClass("ui-state-error");
          }else{
            $(this).dialog("close"); 
            $("#createCharacterForm").submit();
          }
        }, 
        
        Cancel: function() { 
          $(this).dialog("close"); 
        } 
      } 
    });
    
    $(".raceList a").bind("click", function(e){
      e.preventDefault();
      var $this = $(this);
      var id = $this.children(".r_id").val();
      $("#c_race").val(id).change();
      $("#startingStr").change();
      $("#remPoints").text('25');
      $("#statSelection").dialog("open");
    });
    
    $("#submitCreateAccount").bind("click", function(e){
      e.preventDefault();
      
      var name = $("#c_fn").val();
      if(name.length > 3 && name.length < 50){
        vc.cs.CheckName($("#c_fn").val(), function(data){ if(data.Result == vc.ER_SUCCESS){ $("#accountSelection").fadeOut(500, function(){ $("#raceSelection").fadeIn(500); }); } else { $("#c_checkName_status").removeClass("available").addClass("unavailable"); } });
      }else{
        alert("Please select a character name between 3 and 50 characters.");
        $("#c_checkName_status").removeClass("available").addClass("unavailable");
      }
    });
    
    $("#cancelCreation a ").bind("click", function(e){ e.preventDefault(); $("#raceSelection").fadeOut(500, function(){ $("#accountSelection").fadeIn(500); }); });
    
    $("#createCharacterForm").bind("submit", function(e){
      e.preventDefault();

      var name = $("#c_fn").val();
      var race = V2Core.Races[$("#c_race").val()];
      var gender = $("#c_gender").val();
      var str = ($("#startingStr").text() * 1) - V2Core.Races[$("#c_race").val()].Str;
      var dex = ($("#startingDex").text() * 1) - V2Core.Races[$("#c_race").val()].Dex;
      var intel = ($("#startingInt").text() * 1) - V2Core.Races[$("#c_race").val()].Int;
      var wis = ($("#startingWis").text() * 1) - V2Core.Races[$("#c_race").val()].Wis;
      var vit = ($("#startingVit").text() * 1) - V2Core.Races[$("#c_race").val()].Vit;
      var pin = $("#c_pin").val();
      
      if(name == "Character Name") { 
        alert("Please enter a name."); 
        return; 
      }
      
      vc.cs.Create(name, gender, pin, race.Id, str, dex, intel, wis, vit, function(r){
        switch(r.Result){
          case vc.ER_SUCCESS:
            vc.cs.List(function(data) { LoadCharacterList(data); $("#logIn .character a:last").click(); });
            
            break;
          case vc.ER_BADDATA:
          case vc.ER_MALFORMED:
          case vc.ER_DBERROR:
            alert("A database error has occured..");
            break;
          case vc.ER_ALREADYEXISTS:
            alert("A character with that name already exists!");
            break;
          default:
            alert("An error has occured. Try again later.");
            break;
        }
      });
    });
    
    $("#accountSelection .bigButton").live("click", function(e){
      e.preventDefault();
      $parent = $(this).parent();
      
      var cId = $parent.children(".c_id").val();
      var hasPin = $parent.children(".c_haspin").val();
      var pin = 0;
      
      if(hasPin == "true"){
        pin = prompt("What is the character's PIN?", "");
      }
      
      vc.cs.Select(cId, pin, SelectCharacter);
    });
    
    $(".raceSelection").css({ display: "none" });
    
    $("#c_race").bind("change", function(){
      var race = V2Core.Races[$(this).val()];
      $("#baseStr").text(race.Str);
      $("#baseDex").text(race.Dex);
      $("#baseInt").text(race.Int);
      $("#baseWis").text(race.Wis);
      $("#baseVit").text(race.Vit);
      
      $("#startingStr").text(race.Str);
      $("#startingDex").text(race.Dex);
      $("#startingInt").text(race.Int);
      $("#startingWis").text(race.Wis);
      $("#startingVit").text(race.Vit);

      $("#raceStrMax").text(race.StrMax);
      $("#raceDexMax").text(race.DexMax);
      $("#raceIntMax").text(race.IntMax);
      $("#raceWisMax").text(race.WisMax);
      $("#raceVitMax").text(race.VitMax);
    });
    
    $(".selectStats .formInput input").bind("change", function(e){
      UpdateCreateCharacterStats($(this), e);
    });
    
    $(".selectStats .formInput button").bind("click", function(e){
      e.preventDefault();
      UpdateCreateCharacterStats($(this), e);
    });
    
    $("#quickLoginForm .button").bind("click", function(e){
      e.preventDefault();
      vc.as.Logout(Logout);
    });
    
    $("#c_checkName").bind("click", function(e){
      e.preventDefault();
      var name = $("#c_fn").val();
      
      if(name == "Character Name"){
        name = "";
      }
      
      if(name.length > 3 && name.length < 50){
        vc.cs.CheckName($("#c_fn").val(), UpdateNameAvailability);
      }else{
        $("#c_checkName_status").removeClass("available").addClass("unavailable");
      }
    });
    
    vc.cs.List(LoadCharacterList);
  });
})(window);
