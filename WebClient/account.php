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
		<link href="css/grid.css" rel="stylesheet" media="screen" />
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
	<body>
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span class="info">You last logged in at 3:00 last Tuesday from around Cincinnati, OH (123.85.987.123).</span>
					<span class="info"><strong>You have 8 unread private messages on your characters.</strong></span>
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
							<li><a href="#" class="selected">Play</a></li>
							<li><a href="http://v2.neflaria.com">Blog</a></li>
							<li><a href="#">Manual</a></li>
							<li><a href="#">Rankings</a></li>
							<li><a href="http://www.neflaria.com/forum">Forum</a></li>
							<li><a href="#">Donate</a></li>
							<li><a href="#">Store</a></li>
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
			<section id="logIn" class="grid_5">
				<h1>Select Character</h1>
				<!--<div class="character">
					<a class="button bigButton" href="#">
						<span class="characterName">Silent Warrior</span>
						<span class="characterStats">Neutral level 186 Human : 2,2 Ta'Lorn</span>
					</a>
					<ul class="recentActivity">
						<li>#96 for Character Longevity</li>
						<li>02/04/10: *Ding* Level 50 - time to pick a last name! Use "/last name".</li>
						<li>02/03/10: *Ding* Level 15 - time to chat!</li>
						<li>02/01/10: Character created!</li>
						<li><strong>1 unread message</strong></li>
					</ul>
				</div>-->
			</section>
			
			<section>
				<h1 class="grid_7">Create New Character</h1>
				
				<form action="submitaction.php" method="post" id="createCharacterForm">
					<div id="createCharacter" class="grid_4">
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
								<!--<input type="text" id="c_mn" placeholder="Middle Name" />
								<input type="text" id="c_ln" placeholder="Last Name" />-->
							</div>
							<div class="formValidator">
								<span id="c_name_validator"></span>
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
								<input type="password" id="c_confirmpin" placeholder="" />
							</div>
							<div class="formValidator">
								<span id="c_confirmpin_validator"></span>
							</div>
						</div>
						
						<div class="formRow">
							<div class="formLabel">
								<label for="c_race">Race:</label>
							</div>
							<div class="formInput">
								<select id="c_race">
								</select>
							</div>
							<div class="formValidator">
								<span id="c_race_validator"></span>
							</div>
						</div>
						
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
							<div class="formLabel"></div>
							<div class="formInput">
								<button type="submit" id="submitCreateAccount" class="button createAccount">Create</button>
							</div>
						</div>
					</div>
						
					<div class="grid_3 selectStats">
						<em>You have <span id="remPoints">0</span> points to distribute.</em>
						<div class="formRow">
							<div class="formLabel">
								<label for="startingStr">Str</label>
							</div>
							<div class="formInput">
								<button type="submit" class="button minus">+</button>
								<span id="baseStr" class="raceBaseStat">20</span> + <input class="statChooser" id="startingStr" maxlength="2" value="0" />
								<button type="submit" class="button plus">-</button>
								<br />
								<em>Race max: <span id="raceStrMax">30</span></em>
							</div>
						</div>
						
						<div class="formRow">
							<div class="formLabel">
								<label for="startingDex">Dex</label>
							</div>
							<div class="formInput">
								<button type="submit" class="button minus">+</button>
								<span id="baseDex" class="raceBaseStat">20</span> + <input class="statChooser" id="startingDex" maxlength="2" value="0" />
								<button type="submit" class="button plus">-</button>
								<br />
								<em>Race max: <span id="raceDexMax">30</span></em>
							</div>
						</div>
						
						<div class="formRow">
							<div class="formLabel">
								<label for="startingInt">Int</label>
							</div>
							<div class="formInput">
								<button type="submit" class="button minus">+</button>
								<span id="baseInt" class="raceBaseStat">20</span> + <input class="statChooser" id="startingInt" maxlength="2" value="0" />
								<button type="submit" class="button plus">-</button>
								<br />
								<em>Race max: <span id="raceIntMax">30</span></em>
							</div>
						</div>
						
						<div class="formRow">
							<div class="formLabel">
								<label for="startingWis">Wis</label>
							</div>
							<div class="formInput">
								<button type="submit" class="button minus">+</button>
								<span id="baseWis" class="raceBaseStat">20</span> + <input class="statChooser" id="startingWis" maxlength="2" value="0" />
								<button type="submit" class="button plus">-</button>
								<br />
								<em>Race max: <span id="raceWisMax">30</span></em>
							</div>
						</div>
						
						<div class="formRow">
							<div class="formLabel">
								<label for="startingVit">Vit</label>
							</div>
							<div class="formInput">
								<button type="submit" class="button minus">+</button>
								<span id="baseVit" class="raceBaseStat">20</span> + <input class="statChooser" id="startingVit" maxlength="2" value="0" />
								<button type="submit" class="button plus">-</button>
								<br />
								<em>Race max: <span id="raceVitMax">30</span></em>
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
		
		<div class="clear"></div>
		
		<footer class="copyright">
			<div class="container_12">
				&copy; 2010 <a href="#">Chrysolite Foundation</a>, all rights reserved. <a href="#">Terms of Service</a> - <a href="#">Privacy Policy</a> - <a href="#">Contact</a>
				<br />
				Neflaria is built on the <a href="#">Chrysolite Game Engine</a>, available under <a href="#">BSD Licensing</a>.
			</div>
		</footer>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
		
		<!-- Here come the plugins -->
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.selectmenu.js"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
		
		<!-- Data Libraries -->
		<script src="./Core/staticInfo/races.js"></script>
		<script src="./Core/staticInfo/maps.js"></script>
		
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<script src="./js/startup.js"></script>
		<script src="./js/account-startup.js"></script>
	</body>
</html>