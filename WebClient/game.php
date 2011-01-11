<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
		<meta name="keywords" content="free online mmo, mmorpg, rpg, neflaria, shimlar, neflaria v2" />
		<meta name="description" content="Chrysellia is a free online RPG: create an account and fight for the top spot!" />

		<meta name="author" content="silwarnaiilo@neflaria.com" />
		<meta name="distribution" content="Global" />
		<meta name="copyright" content="All content copyright 2010 Chrysolite Foundation. All rights reserved." />
		<!-- todo: remove for beta -->
		<meta name="robots" content="nofollow" />
		
		<title>Chrysellia</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		
		<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid-fluid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<!--<link href="css/neflaria.min.css" rel="stylesheet" media="screen" />
		<link href="css/grid-fluid.min.css" rel="stylesheet" media="screen" />-->
		
		
		<!--[if IE 8]>
		<link href="css/ie8.css" rel="stylesheet" media="screen" />
		<![endif]-->
		
		<!--[if IE 7]>
		<link href="css/ie7.css" rel="stylesheet" media="screen" />
		<![endif]-->
		
		<!--[if IE 6]>
		<link href="css/ie6.css" rel="stylesheet" media="screen" />
		<![endif]-->
		
		<link rel="icon" type="image/png" href="images/favicon.ico" /> 
		<link rel="alternate" type="application/rss+xml" title="Chrysellia News RSS Feed" href="http://v2.neflaria.com/blog/feed/" />
	</head>
	<body class="game">
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span id="latestStatus" class="info"></span>
					<span id="latestPM" class="info">
						
					</span>
					
					<div class="accountActions">
						<a href="http://forum.chrysellia.com">Forum</a>
						<a href="http://wiki.chrysellia.com">Manual</a>
						<a href="http://blog.chrysellia.com">Blog</a>
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
								<h1><span id="myCharacter_Name"></span></h1>
							</div>
							<div class="stat level">
								<h2><span class="statLabel" title="Level">Level</span>
								<span id="myCharacter_Level"></span></h2>
							</div>
							<div class="stat exp">
								<span class="statLabel icon experience" title="Experience Points">XP</span>
								<div id="myCharacter_Experience"></div>
							</div>
							<div class="stat hp">
								<span class="statLabel icon health" title="Health">Health</span>
								<div id="myCharacter_Health"></div>
							</div>
							<div class="stat gold">
								<span class="statLabel icon gold" title="Gold">Gold</span>
								<span id="myCharacter_Gold"></span>
							</div>
						</section>
						<a href="#" class="button stats" id="statsWindowButton">Stats</a>
						<a href="#" class="button items" id="itemsWindowButton">Items</a>
					</div>
					
					<div id="topCenter" class="container top grid_6">
						
					</div>
					
					<section id="topRight" class="container top grid_3">
						<h1 id="currentMapName"></h1>
						<table id="currentMap"></table>
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
									<td><button class="look" id="moveLook">Look</button><input type="hidden" class="y" value="0" /><input type="hidden" class="x" value="0" /></td>
									<td><button class="e" id="moveE">E</button><input type="hidden" class="y" value="0" /><input type="hidden" class="x" value="1" /></td>
								</tr>
								<tr>
									<td><button class="sw" id="moveSW">SW</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="-1" /></td>
									<td><button class="s" id="moveS">S</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="0" /></td>
									<td><button class="se" id="moveSE">SE</button><input type="hidden" class="y" value="-1" /><input type="hidden" class="x" value="1" /></td>
								</tr>
							</table>
						</form>
					</section>
				</div>
				
				<div class="clear"></div>
				
				<div id="bottom" class="grid_12 bottom">
					<form action="submitaction.php" id="chatForm" class="CHAN_00000000000000000000001">
						<input type="hidden" value="chat" class="button">
						Say: 
						<input type="text" id="chatInput" style="width: 400px;" />
						<input type="submit" value="Send">
						
						<a href="#" id="createChannelLink" class="button" style="float:right;">Create channel</a>
						<a href="#" id="joinChannelLink" class="button" style="float:right;">Join channel</a>
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
		
		<div style="hidden" id="statsWindow" style="display: none;">
			<div class="stat str">
				<span class="statLabel icon str" title="Strength">Strength</span>
				<span id="myCharacter_Strength"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat dex">
				<span class="statLabel icon dex" title="Dexterity">Dexterity</span>
				<span id="myCharacter_Dexterity"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat wis">
				<span class="statLabel icon wis" title="Wisdom">Wisdom</span>
				<span id="myCharacter_Wisdom"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat int">
				<span class="statLabel icon int" title="Intelligence">Intelligence</span>
				<span id="myCharacter_Intelligence"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat vit">
				<span class="statLabel icon vit" title="Vitality">Vitality</span>
				<span id="myCharacter_Vitality"></span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
			<div class="stat all" style="display: none;">
				<span class="statLabel" title="All Stats">All Stats</span>
				<button type="submit" class="button" style="display: none;">+</button>
			</div>
		</div>
		
		<div style="hidden" id="itemsWindow" style="display: none;">
			
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
		
		<!-- Here come the plugins -->
		<!--<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery-easing.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>-->
		<script src="./js/plugins.min.js"></script>
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<script src="./Core/core-CommandService.js"></script>
		<script src="./Core/core-ChatService.js"></script>
		<script src="./Core/core-MapService.js"></script>
		<script src="./Core/core-ItemService.js"></script>
		<script src="./Core/core-MonsterService.js"></script>
		<script src="./Core/core-Interface.js"></script>
		<!--<script src="./Core/core.min.js"></script>-->
		
		<!-- Data Libraries -->
		<script src="./Core/staticInfo/races.js"></script>
		<script src="./Core/staticInfo/maps.js"></script>
		<script src="./Core/staticInfo/monsters.js"></script>
		<script src="./Core/staticInfo/items.js"></script>
		<!--<script src="./Core/staticInfo/libraries.min.js"></script>-->
		
		<script src="./js/startup.js"></script>
		
		<script src="./js/game-startup.js"></script>
		<!--<script src="./js/game-startup.min.js"></script>-->
		
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
	</body>
</html>