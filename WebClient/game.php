<!DOCTYPE html>

<html lang="en">
  <?php include('head.php'); ?>  
  <body class="game dark">
		<div id="loading" style="width: 100%; height: 100%; background-color: #000; text-align: center; position: absolute; top: 0; left: 0; z-index: 100;"><div style="margin-top: 100px; color: #fff;"><h1>Loading</h1></div></div>
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span id="latestStatus" class="info"></span>
					<span id="latestPM" class="info">
						
					</span>
					
					<div class="accountActions">
						<!--Theme: <select id='themeSelect'><option value='1'>Dark</option><option value='0'>Light</option></select>-->
						<a href="./tops.php" target="_blank">Rankings</a>
						<a href="http://forum.chrysellia.com" target="_blank">Forum</a>
						<a href="http://wiki.chrysellia.com" target="_blank">Manual</a>
						<a href="http://blog.chrysellia.com" target="_blank">Blog</a>
						<a href="./account.php" class="button alternateButton account">Account</a>
						<a href="./index.php" class="button alternateButton logOut">Log Out</a>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="innerContainer container_12">	
			<div id="content">
				<div id="top">
					<div id="topLeft" class="container top grid_3">
						<section class="stats">
							<div class="stat name">
								<h1><span id="MyCharacter_Name"></span></h1>
							</div>
							<div class="stat level">
								<h2><span class="statLabel" title="Level">Level</span>
								<span id="MyCharacter_LevelTitle"></span></h2>
							</div>
							<div class="stat exp">
								<span class="statLabel icon experience" title="Experience Points">XP</span>
								<div id="MyCharacter_ExperienceBar"></div>
							</div>
							<div class="stat hp">
								<span class="statLabel icon health" title="Health">Health</span>
								<div id="MyCharacter_HealthBar"></div>
							</div>
							<div class="stat gold">
								<span class="statLabel icon gold" title="Gold">Gold</span>
								<span id="MyCharacter_CurrentGold"></span>
							</div>
						</section>
						<a href="#" class="button stats" id="statsWindowButton">Stats</a>
						<a href="#" class="button items" id="itemsWindowButton">Items</a>
					</div>
					
					<div id="topCenter" class="container top grid_6">
						
					</div>
					
					<section id="topRight" class="container top grid_3">
						<h1 id="currentMapName"></h1>
						<h3 id="currentMapPosition"></h3>
						<div id="currentMap"><div id="marker"></div></div>
						<form action="submitaction.php" id="movementform">
							<input type="hidden" value="move">
							<table id="movement">
								<tr>
									<td><button class="nw" id="moveNW">NW</button><input type="hidden" class="y" value="1" /><input type="hidden" class="x" value="-1" /></td>
									<td><button class="n" id="moveN">N</button><input type="hidden" class="y" value="1" /><input type="hidden" class="x" value="0" /></td>
									<td><button class="ne" id="moveNE">NE</button><input type="hidden" class="y" value="1" /><input type="hidden" class="x" value="1" /></td>
								</tr>
								<tr>
									<td><button class="w" id="moveW">W</button><input type="hidden" class="y" value="0" /><input type="hidden" class="x" value="-1" /></td>
									<td></td>
									<td><button class="e" id="moveE">E</button><input type="hidden" class="y" value="0" /><input type="hidden" class="x" value="1" /></td>
								</tr>
								<tr>
									<td><button class="sw" id="moveSW">SW</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="-1" /></td>
									<td><button class="s" id="moveS">S</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="0" /></td>
									<td><button class="se" id="moveSE">SE</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="1" /></td>
								</tr>
							</table>
						</form>
						<a href="./css/images/large_maps/Parlaor_20.png" target="_blank" id="largeMap">View Large Map</a>
					</section>
				</div>
				
				<div class="clear"></div>
				
				<div id="bottom" class="grid_12 bottom">
					<form action="submitaction.php" id="chatForm" class="CHAN_00000000000000000000001">
						<input type="hidden" value="chat" class="button">
						Say: 
						<input type="text" id="chatInput" style="width: 400px;" maxlength="500" />
						<input type="submit" value="Send">
						
						<a href="#" id="createChannelLink" class="button" style="float:right;">Create Channel</a>
						<a href="#" id="joinChannelLink" class="button" style="float:right;">Join Channel</a>
					</form>
					
					<div id="chatChannels" class="chatChannels">
						<ul id="channelTabs"></ul>
					</div>
				</div>
			</div>
		</div>

		<div class="clear"></div>
		
		<footer class="copyright">
			<div class="container_12">
				&copy; 2010 <a href="mailto:silwarnaiilo@neflaria.com">Jack Lawson</a> and <a href="mailto:sexylingerie@neflaria.com">Drew Ditthardt</a>, 
				all rights reserved. <a href="tos.html">Terms of Service</a> - <a href="pp.html">Privacy Policy</a> - <a href="mailto:administration@neflaria.com">Contact</a>
			</div>
		</footer>
		
		<div style="hidden" id="createChannelForm" style="display:none;">
			<form action="submitaction.php" method="post">
				<input type="hidden" value="createChannel">
				<div class="formRow">
					<div class="formLabel"><label for="cc_channelName">Channel Name</label></div>
					<div class="formInput"><input id="cc_channelName" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel"><label for="cc_channelMOTD">MOTD</label></div>
					<div class="formInput"><input id="cc_channelMOTD" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel"><label for="cc_publicRead">Public Read</label></div>
					<div class="formInput"><input id="cc_publicRead" type="checkbox" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel"><label for="cc_publicWrite">Public Write</label></div>
					<div class="formInput"><input id="cc_publicWrite" type="checkbox" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">&nbsp;</div>
					<div class="formInput"><button type="submit" class="button">Create</button></div>
				</div>
			</form>
		</div>
		
		<div style="hidden" id="joinChannelForm" style="display:none;">
			<form action="submitaction.php" method="post">
				<input type="hidden" value="joinChannel">
				<div class="formRow">
					<div class="formLabel"><label for="jc_channelName">Channel Name</label></div>
					<div class="formInput"><input id="jc_channelName" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">&nbsp;</div>
					<div class="formInput"><button type="submit" class="button">Join</button></div>
				</div>
			</form>
		</div>
		
		<div style="hidden" id="statsWindow" class="statsWindow" style="display: none;">
			<div class="stat lvl">
				<span class="statLabel icon lvl" title="Level">Level</span>
				<span id="MyCharacter_Level"></span>
			</div>
			<div class="stat freeLvls">
				<span class="statLabel icon freeLevels" title="Free Levels">Free Levels</span>
				<span id="MyCharacter_FreeLevels"></span>
			</div>
			<div class="stat align">
				<span class="statLabel icon alignment" title="Alignment">Alignment</span>
				<span id="MyCharacter_Alignment"></span>
			</div>
			<div class="stat str">
				<span class="statLabel icon str" title="Strength">Strength</span>
				<span id="MyCharacter_Strength"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat dex">
				<span class="statLabel icon dex" title="Dexterity">Dexterity</span>
				<span id="MyCharacter_Dexterity"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat wis">
				<span class="statLabel icon wis" title="Wisdom">Wisdom</span>
				<span id="MyCharacter_Wisdom"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat int">
				<span class="statLabel icon int" title="Intelligence">Intelligence</span>
				<span id="MyCharacter_Intelligence"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat vit">
				<span class="statLabel icon vit" title="Vitality">Vitality</span>
				<span id="MyCharacter_Vitality"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat vit">
				<span class="statLabel icon health" title="Vitality">Health</span>
				<span id="MyCharacter_Health"></span>
			</div>
			<div class="stat exp">
				<span class="statLabel icon experience" title="Experience">Experience</span>
				<span id="MyCharacter_Experience"></span>
			</div>
			<div class="stat gold">
				<span class="statLabel icon gold" title="Gold">Gold</span>
				<span id="MyCharacter_Gold"></span>
			</div>
			<div class="stat gold">
				<span class="statLabel icon bankedGold" title="Bank">Bank</span>
				<span id="MyCharacter_Bank"></span>
			</div>
		</div>
		
		<div style="hidden" id="itemsWindow" style="display: none;"></div>
		
		<div id="debugWindow">
			<h1>Debug</h1>
			<div class='row' id="rda"><span class='label'>RequestDuration Average</span><span class='value' id="rda_value"></span></div>
			<div id="logs"></div>
		</div>
		
		<!--[if IE 8]>
		</div>
		<![endif]-->
		
		<!--[if IE 7]>
		</div>
		<![endif]-->
		
		<!--[if IE 6]>
		</div>
		<![endif]-->
		<!-- -->

    <?php include('commonscripts.php'); ?>
    <script src="./js/game-startup.js"></script>
  </body>
</html>
