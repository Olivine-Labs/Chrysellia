<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
		<meta name="keywords" content="free online mmo, mmorpg, rpg, neflaria, shimlar, neflaria v2" />
		<meta name="description" content="Chrysellia is a free online RPG: create an account and fight for the top spot!" />

		<meta name="author" content="silwarnaiilo@neflaria.com" />
		<meta name="distribution" content="Global" />
		<meta name="copyright" content="All content copyright 2010 Jack Lawson and Drew Ditthardt. All rights reserved." />
		
		<title>Chrysellia (Beta)</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		<!--<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<link href="css/tipsy.css" rel="stylesheet" media="screen" />-->
		<!--<link href="css/neflaria.min.css" rel="stylesheet" media="screen" />
		<link href="css/grid.min.css" rel="stylesheet" media="screen" />-->
		<link href="http://s3.amazonaws.com/Chrysellia/css/neflaria.min.css.gz" rel="stylesheet" media="screen" />
		<link href="http://s3.amazonaws.com/Chrysellia/css/grid.min.css.gz" rel="stylesheet" media="screen" />

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
	<body>
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span class="info"></span>
					<span class="info"><strong></strong></span>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div id="navigation">
			<div class="container_12">
				<div class="grid_12" id="mainNav">
					<nav>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="account.php" class="playNow selected">Play</a></li>
							<li><a href="http://blog.chrysellia.com" target="_blank">Blog</a></li>
							<li><a href="http://wiki.chrysellia.com" target="_blank">Manual</a></li>
							<li><a href="tops.php">Rankings</a></li>
							<li><a href="http://forum.chrysellia.com" target="_blank">Forum</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="U9PMXZHBZPVPJ" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li><a href="about.php">About</a></li>
							<li><a href="api.php">API</a></li>
							<li class='fbButton'><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.chrysellia.com&amp;layout=button_count&amp;show_faces=true&amp;width=75&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe></li>
							<!--<li><a href="#">Store</a></li>-->
						</ul>
					</nav>
					
					<div class="quickLogin">
						<form action="submitaction.php" method="post" id="quickLoginForm">
							<input type="hidden" value="logout" name="action" id="action" />
							<button type="submit" class="button">Log Out</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container_12 mainSection">
			<div id="accountSelection">
				<section id="logIn" class="grid_5">
					<h1>Select Character</h1>
				</section>
				
				<section class="grid_7">
					<h1>Create New Character</h1>
					
					<form action="submitaction.php" method="post" id="createCharacterForm">
						<div id="createCharacter">
							<div class="formRow">
								<span class="explanation">
									You can create new characters for your account. Your characters will share a bank
									account, and once your first character reaches level 15, all subsequent characters will
									have the ability to chat without having to first level to 15.
								</span>
							</div>
							
							<div class="formRow characterName">
								<div class="formLabel">
									<label for="c_name">Name:</label>
								</div>
								<div class="formInput">
									<input type="text" id="c_fn" placeholder="Character Name" />
									<span id="c_checkName_status"></span>
									<a href="#" id="c_checkName">Check Name</a>
								</div>
								<div class="formValidator">
									<span id="c_name_validator"></span>
								</div>
							</div>
							
							<input id="c_race" type="hidden">
							
							<div class="formRow">
								<div class="formLabel">
									<label for="c_gender">Gender:</label>
								</div>
								<div class="formInput">
									<select id="c_gender">
										<option value="0">Male</option>
										<option value="1">Female</option>
									</select>
								</div>
								<div class="formValidator">
									<span id="c_race_validator"></span>
								</div>
							</div>
							
							<div class="formRow">
								<div class="formLabel">
									<label for="c_pin">Numeric PIN (Optional):</label>
								</div>
								<div class="formInput">
									<input type="password" id="c_pin" placeholder="" maxlength="4" />
								</div>
								<div class="formValidator">
									<span id="c_pin_validator" maxlength="4"></span>
								</div>
							</div>
							
							<div class="formRow">
								<div class="formLabel">
									<label for="c_confirmpin">Confirm PIN:</label>
								</div>
								<div class="formInput">
									<input type="password" id="c_confirmpin" placeholder="" maxlength="4" />
								</div>
								<div class="formValidator">
									<span id="c_confirmpin_validator"></span>
								</div>
							</div>
							
							<div class="formRow">
								<div class="formLabel"></div>
								<div class="formInput">
									<button id="submitCreateAccount" class="button createAccount" type="submit">Continue</button>
								</div>
							</div>
						</div>
					</form>
				</section>
			</div>
			
			<div id="raceSelection" style="display: none;">
				<section id="goodRaces" class="grid_6">
					<h1>Good</h1>
					<ul></ul>
				</section>
				
				<section id="evilRaces" class="grid_6">
					<h1>Evil</h1>
					<ul></ul>
				</section>
				
				<div class="clear"></div>
				
				<div class="grid_12" id="cancelCreation">
					<a href="account.php" class="button alternateButton">Cancel Character Creation</a>
				</div>
			</div>
		</div>
		
		<div id="statSelection" style="display: none;">
			<div class="selectStats">
				<em>You have <span id="remPoints">0</span> points to distribute.</em>
				<div class="formRow">
					<div class="formLabel">
						<label for="startingStr" class="icon str" title="Strength">Str</label>
					</div>
					<div class="formInput">
						<button type="submit" class="button minus">+</button>
						<span class="statChooser" id="startingStr">20</span>
						<button type="submit" class="button plus">-</button>
						<br />
						<em><span id="baseStr" class="raceBaseStat">20</span> - <span id="raceStrMax" class="statMax">30</span></em>
					</div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">
						<label for="startingDex" class="icon dex" title="Dexterity">Dex</label>
					</div>
					<div class="formInput">
						<button type="submit" class="button minus">+</button>
						<span class="statChooser" id="startingDex">20</span>
						<button type="submit" class="button plus">-</button>
						<br />
						<em><span id="baseDex" class="raceBaseStat">20</span> - <span id="raceDexMax" class="statMax">30</span></em>
					</div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">
						<label for="startingInt" class="icon int" title="Intelligence">Int</label>
					</div>
					<div class="formInput">
						<button type="submit" class="button minus">+</button>
						<span class="statChooser" id="startingInt">20</span>
						<button type="submit" class="button plus">-</button>
						<br />
						<em><span id="baseInt" class="raceBaseStat">20</span> - <span id="raceIntMax" class="statMax">30</span></em>
					</div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">
						<label for="startingWis" class="icon wis" title="Wisdom">Wis</label>
					</div>
					<div class="formInput">
						<button type="submit" class="button minus">+</button>
						<span class="statChooser" id="startingWis">20</span>
						<button type="submit" class="button plus">-</button>
						<br />
						<em><span id="baseWis" class="raceBaseStat">20</span> - <span id="raceWisMax" class="statMax">30</span></em>
					</div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">
						<label for="startingVit" class="icon vit" title="Vitality">Vit</label>
					</div>
					<div class="formInput">
						<button type="submit" class="button minus">+</button>
						<span class="statChooser" id="startingVit">20</span>
						<button type="submit" class="button plus">-</button>
						<br />
						<em><span id="baseVit" class="raceBaseStat">20</span> - <span id="raceVitMax" class="statMax">30</span></em>
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

		<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
		
		<!-- Here come the plugins 
		<script src="./js/plugins.min.js"></script>-->
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
		<script src="./js/jsend.min.js"></script>
		<script src="./js/jquery.tipsy.js"></script>
		<script src="./js/jstorage.js"></script>
		<script src="./js/consolefix.js"></script>
		
		<!-- Here come the plugins 
		<script src="./js/plugins.min.js"></script>
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
		<script src="./js/jsend.min.js"></script>
		<script src="./js/jquery.tipsy.js"></script>
		<script src="./js/jstorage.js"></script>-->
		<script src="http://s3.amazonaws.com/Chrysellia/js/plugins.min.js.gz"></script>
		<script src="./js/consolefix.js"></script>
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us
		<script src="./Core/core.min.js"></script>
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<script src="./Core/core-CommandService.js"></script>
		<script src="./Core/core-ChatService.js"></script>
		<script src="./Core/core-MapService.js"></script>
		<script src="./Core/core-ItemService.js"></script>
		<script src="./Core/core-MonsterService.js"></script>	-->	
		<script src="http://s3.amazonaws.com/Chrysellia/js/core.min.js.gz"></script>
		
		<!-- Libraries -->
		<script src="https://s3.amazonaws.com/Chrysellia/js/libraries.min.js.gz"></script>
		
		<!-- Page setup
		<script src="./js/startup.min.js"></script>
		<script src="./js/game-startup.min.js"></script>
		<script src="./js/startup.js"></script>
		<script src="./js/game-startup.js"></script>-->
		
		<script src="http://s3.amazonaws.com/Chrysellia/js/startup.min.js.gz"></script>
		<script src="http://s3.amazonaws.com/Chrysellia/js/account-startup.min.js.gz"></script>
		
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script><script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-20727556-1']);
		  _gaq.push(['_setDomainName', 'none']);
		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</body>
</html>