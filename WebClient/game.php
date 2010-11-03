<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
		<meta name="keywords" content="free online mmo, mmorpg, rpg, neflaria, shimlar, neflaria v2" />
		<meta name="description" content="Neflaria V2 is a free online RPG: create an account and fight for the top spot!" />

		<meta name="author" content="silwarnaiilo@neflaria.com" />
		<meta name="distribution" content="Global" />
		<meta name="copyright" content="All content copyright 2010 Chrysolite Foundation. All rights reserved." />
		<!-- todo: remove for beta -->
		<meta name="robots" content="nofollow" />
		
		<title>Neflaria V2</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid-fluid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<link href="css/selectmenu.css" rel="stylesheet" media="screen" />
		
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
		<link rel="alternate" type="application/rss+xml" title="Neflaria News RSS Feed" href="http://v2.neflaria.com/blog/feed/" />
	</head>
	<body class="game">
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span id="latestStatus" class="info">Latest status: You just dropped a Drf**!</span>
					<span id="latestPM" class="info">
						<a href="#">Matt</a>: Dude, I need more cola. (<a href="#">more</a>)
					</span>
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
								<h2><span class="statLabel">Level</span>:
								<span id="myCharacter_Level"></span></h2>
							</div>
							<div class="stat exp">
								<span class="statLabel">Exp</span>:
								<span id="myCharacter_Experience"></span>
							</div>
							<div class="stat gold">
								<span class="statLabel">Gold</span>:
								<span id="myCharacter_Gold"></span>
							</div>
							<div class="stat str">
								<span class="statLabel">Str</span>:
								<span id="myCharacter_Strength"></span>
							</div>
							<div class="stat dex">
								<span class="statLabel">Dex</span>:
								<span id="myCharacter_Dexterity"></span>
							</div>
							<div class="stat wis">
								<span class="statLabel">Wis</span>:
								<span id="myCharacter_Wisdom"></span>
							</div>
							<div class="stat int">
								<span class="statLabel">Int</span>:
								<span id="myCharacter_Intelligence"></span>
							</div>
							<div class="stat vit">
								<span class="statLabel">Vit</span>:
								<span id="myCharacter_Vitality"></span>
							</div>
						</section>
					</div>
					
					<div id="topCenter" class="container top grid_6">
						<h1>Game Window</h1>
					</div>
					
					<div id="topRight" class="container top grid_3">
						<h1>Other Window</h1>
					</div>
				</div>
				
				<div class="clear"></div>
				
				<div id="bottom" class="grid_12 bottom">
					<form action="game.html" id="chatForm" class="CHAN_00000000000000000000001">
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
				&copy; 2010 <a href="#">Chrysolite Foundation</a>, all rights reserved. <a href="#">Terms of Service</a> - <a href="#">Privacy Policy</a> - <a href="#">Contact</a>
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
					<div class="formInput"><button class="button">Create</button></div>
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
					<div class="formInput"><button class="button">Join</button></div>
				</div>
			</form>
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		<!-- Here come the plugins -->
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jcarousel-lite.js"></script>
		<script src="./js/jquery-easing.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<script src="./Core/core-CommandService.js"></script>
		<script src="./Core/core-ChatService.js"></script>
		<script src="./Core/core-Interface.js"></script>
		<script src="./js/startup.js"></script>
		<script src="./js/game-startup.js"></script>
	</body>
</html>