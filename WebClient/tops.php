<?php
date_default_timezone_set('America/New_York');
define('FACEBOOK_APP_ID', '119442588120693');
define('FACEBOOK_SECRET', '394479c493bac0ee777a8d9cf61ac4fd');

function get_facebook_cookie($app_id, $application_secret)
{
	$args = array();
	if(isset($_COOKIE['fbs_' . $app_id]))
	{
		parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		foreach ($args as $key => $value)
		{
			if ($key != 'sig')
			{
				$payload .= $key . '=' . $value;
			}
		}
		if (md5($payload . $application_secret) != $args['sig'])
		{
			return null;
		}
	}
	return $args;
}

$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);

include_once('php/simplepie.inc');
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
		<meta name="keywords" content="free online mmo, mmorpg, rpg, neflaria, shimlar, neflaria v2" />
		<meta name="description" content="Chrysellia is a free online RPG: create an account and fight for the top spot!" />

		<meta name="author" content="silwarnaiilo@neflaria.com" />
		<meta name="distribution" content="Global" />
		<meta name="copyright" content="All content copyright 2010 Jack Lawson and Drew Ditthardt. All rights reserved." />
		
		<title>Chrysellia (Beta): Rankings</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		
		<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<!--<link href="css/neflaria.min.css" rel="stylesheet" media="screen" />
		<link href="css/grid.min.css" rel="stylesheet" media="screen" />-->
		
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
	<body class="tops">	
		<div id="navigation">
			<div class="container_12">
				<div class="grid_12" id="mainNav">
					<nav>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="account.php" class="playNow">Play</a></li>
							<li><a href="http://blog.chrysellia.com" target="_blank">Blog</a></li>
							<li><a href="http://wiki.chrysellia.com" target="_blank">Manual</a></li>
							<li><a href="tops.php" class="selected">Rankings</a></li>
							<li><a href="http://forum.chrysellia.com" target="_blank">Forum</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="U9PMXZHBZPVPJ" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li class='fbButton'><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.chrysellia.com&amp;layout=button_count&amp;show_faces=true&amp;width=75&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe></li>
							<!--<li><a href="#">Store</a></li>-->
						</ul>
					</nav>
					
					<div class="quickLogin" style="display: none;">
						<form action="submitaction.php" method="post" id="quickLoginForm">
							<input type="text" placeholder="Username" name="quickLogin_un" id="quickLogin_un" />
							<input type="password" placeholder="Password" name="quickLogin_pw" id="quickLogin_pw" />
							<input type="hidden" value="login" name="action" id="action" />
							
							<button type="submit" class="button">Log in</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container_12">
			<div class="container_12">
				<div class="grid_12">
					<header>
						<h1>Chrysellia</h1>
						<h2>The classic free online RPG</h2>
					</header>
				</div>
				
				<div class="clear"></div>
				
				<div class="grid_12">
					
					<h3>Options</h3>
					<div class="options">
						<form id="topsOptions" action="tops.php" method="get">
							Sort by: 
							<select id="sortOptions"><option value="0" selected="Selected">Level</option><option value="1">Align (Good / Evil)</option><option value="2">Align (Ordered / Chaotic)</option></select>
							<select id="sortDirection"><option value="0" selected="Selected">Descending</option><option value="1">Ascending</option></select>
							<button type="submit">Sort Results</button>
						</form>
					</div>
					
					<ul id="topList">
						<!--<li class="Troll" title="#0: Nastra69 Neutral Level 2202 Troll"><div><h2 class="rank number_0">#1</h2><h3 class="charName">Nastra69</h3><span class="charDetails">Neutral Level 2202 Troll</span></div></li><li class="Gargoyle" title="#1: Catalyst of evil Neutral Level 2200 Gargoyle"><div><h2 class="rank number_1">#2</h2><h3 class="charName">Catalyst of evil</h3><span class="charDetails">Neutral Level 2200 Gargoyle</span></div></li><li class="Human" title="#2: SnowFlake Neutral Level 1237 Human"><div><h2 class="rank number_2">#3</h2><h3 class="charName">SnowFlake</h3><span class="charDetails">Neutral Level 1237 Human</span></div></li><li class="Aviakan" title="#3: Glitched Neutral Level 1190 Aviakan"><div><h2 class="rank number_3">#4</h2><h3 class="charName">Glitched</h3><span class="charDetails">Neutral Level 1190 Aviakan</span></div></li><li class="Orc" title="#4: Bird Of Prey Neutral Level 1018 Orc"><div><h2 class="rank number_4">#5</h2><h3 class="charName">Bird Of Prey</h3><span class="charDetails">Neutral Level 1018 Orc</span></div></li><li class="Drow" title="#5: UnholyRider Neutral Level 1000 Drow"><div><h2 class="rank number_5">#6</h2><h3 class="charName">UnholyRider</h3><span class="charDetails">Neutral Level 1000 Drow</span></div></li><li class="Drow" title="#6: Goliath Neutral Level 970 Drow"><div><h2 class="rank number_6">#7</h2><h3 class="charName">Goliath</h3><span class="charDetails">Neutral Level 970 Drow</span></div></li><li class="Dwarf" title="#7: General_Lee Neutral Level 866 Dwarf"><div><h2 class="rank number_7">#8</h2><h3 class="charName">General_Lee</h3><span class="charDetails">Neutral Level 866 Dwarf</span></div></li><li class="Troll" title="#8: Pea Wolf Neutral Level 736 Troll"><div><h2 class="rank number_8">#9</h2><h3 class="charName">Pea Wolf</h3><span class="charDetails">Neutral Level 736 Troll</span></div></li><li class="Drow" title="#9: Krios Neutral Level 705 Drow"><div><h2 class="rank number_9">#10</h2><h3 class="charName">Krios</h3><span class="charDetails">Neutral Level 705 Drow</span></div></li><li class="Troll" title="#10: Robberlord Neutral Level 608 Troll"><div><h2 class="rank number_10">#11</h2><h3 class="charName">Robberlord</h3><span class="charDetails">Neutral Level 608 Troll</span></div></li><li class="Drow" title="#11: TheBigBangBoom Neutral Level 529 Drow"><div><h2 class="rank number_11">#12</h2><h3 class="charName">TheBigBangBoom</h3><span class="charDetails">Neutral Level 529 Drow</span></div></li><li class="Goblin" title="#12: The Flame Alchemist  Neutral Level 487 Goblin"><div><h2 class="rank number_12">#13</h2><h3 class="charName">The Flame Alchemist </h3><span class="charDetails">Neutral Level 487 Goblin</span></div></li><li class="Troll" title="#13: Swoon Neutral Level 485 Troll"><div><h2 class="rank number_13">#14</h2><h3 class="charName">Swoon</h3><span class="charDetails">Neutral Level 485 Troll</span></div></li><li class="Orc" title="#14: Sakuretsu_Armour Neutral Level 481 Orc"><div><h2 class="rank number_14">#15</h2><h3 class="charName">Sakuretsu_Armour</h3><span class="charDetails">Neutral Level 481 Orc</span></div></li><li class="Dwarf" title="#15: Pink Speedos Neutral Level 461 Dwarf"><div><h2 class="rank number_15">#16</h2><h3 class="charName">Pink Speedos</h3><span class="charDetails">Neutral Level 461 Dwarf</span></div></li><li class="Drow" title="#16: Dobby Neutral Level 456 Drow"><div><h2 class="rank number_16">#17</h2><h3 class="charName">Dobby</h3><span class="charDetails">Neutral Level 456 Drow</span></div></li><li class="Drow" title="#17: Slust Neutral Level 455 Drow"><div><h2 class="rank number_17">#18</h2><h3 class="charName">Slust</h3><span class="charDetails">Neutral Level 455 Drow</span></div></li><li class="Troll" title="#18: bognar Neutral Level 411 Troll"><div><h2 class="rank number_18">#19</h2><h3 class="charName">bognar</h3><span class="charDetails">Neutral Level 411 Troll</span></div></li><li class="Troll" title="#19: Ozkan Neutral Level 410 Troll"><div><h2 class="rank number_19">#20</h2><h3 class="charName">Ozkan</h3><span class="charDetails">Neutral Level 410 Troll</span></div></li><li class="Orc" title="#20: Drinky Crow Neutral Level 400 Orc"><div><h2 class="rank number_20">#21</h2><h3 class="charName">Drinky Crow</h3><span class="charDetails">Neutral Level 400 Orc</span></div></li><li class="Dwarf" title="#21: Bored Neutral Level 393 Dwarf"><div><h2 class="rank number_21">#22</h2><h3 class="charName">Bored</h3><span class="charDetails">Neutral Level 393 Dwarf</span></div></li><li class="Drow" title="#22: NikNak Neutral Level 361 Drow"><div><h2 class="rank number_22">#23</h2><h3 class="charName">NikNak</h3><span class="charDetails">Neutral Level 361 Drow</span></div></li><li class="Drow" title="#23: cripple Neutral Level 334 Drow"><div><h2 class="rank number_23">#24</h2><h3 class="charName">cripple</h3><span class="charDetails">Neutral Level 334 Drow</span></div></li><li class="Drow" title="#24: Norvalk Neutral Level 323 Drow"><div><h2 class="rank number_24">#25</h2><h3 class="charName">Norvalk</h3><span class="charDetails">Neutral Level 323 Drow</span></div></li>-->
					</ul>
				</div>
				
			</div>
			
			<div class="clear"></div>
		</div>
		
		<footer class="copyright">
			<div class="container_12">
				&copy; 2010 <a href="mailto:silwarnaiilo@neflaria.com">Jack Lawson</a> and <a href="mailto:sexylingerie@neflaria.com">Drew Ditthardt</a>, 
				all rights reserved. <a href="tos.html">Terms of Service</a> - <a href="pp.html">Privacy Policy</a> - <a href="mailto:administration@neflaria.com">Contact</a>
			</div>
		</footer>
		
		<div id="playNow" style="display:none">
			<section class="logIn">
				<h1>Log In</h1>
				<p><a class="fb_button fb_button_medium" id="fblogin" href="#"><span class="fb_button_text">Log In</span></a> using Facebook</p>
				<em class="or"> - or - </em>
				<h3>Log In Manually:</h3>
				<form action="submitaction.php" method="post"  id="loginForm">
					<div class="formRow">
						<div class="formLabel">
							<label for="li_username">Username:</label>
						</div>
						<div class="formInput">
							<input type="text" id="li_username" placeholder="Account Username" />
						</div>
						<div class="formValidator">
							<span id="li_username_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel">
							<label for="li_password">Password:</label>
						</div>
						<div class="formInput">
							<input type="password" id="li_password" placeholder="Password" />
						</div>
						<div class="formValidator">
							<span id="li_password_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel"></div>
						<div class="formInput">
							<button type="submit" id="submitLogIn" class="button">Log In</button>
						</div>
					</div>
				</form>
			</section>
			<section class="register">
				<h1>Register</h1>
				<p><a class="fb_button fb_button_medium" id="fbregister" href="#"><span class="fb_button_text">Register</span></a> using Facebook</p>
				<em class="or"> - or - </em>
				<h3>Register Manually:</h3>
				<form action="submitaction.php" method="post"  id="registerForm">
					<div class="formRow">
						<div class="formLabel">
							<label for="ca_username">Username:</label>
						</div>
						<div class="formInput">
							<input type="text" id="ca_username" placeholder="Account Username" />
						</div>
						<div class="formValidator">
							<span id="ca_username_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel">
							<label for="ca_password">Password:</label>
						</div>
						<div class="formInput">
							<input type="password" id="ca_password" placeholder="Password" />
						</div>
						<div class="formValidator">
							<span id="ca_password_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel">
							<label for="ca_confirmPassword">Confirm Password:</label>
						</div>
						<div class="formInput">
							<input type="password" id="ca_confirmPassword" placeholder="Confirm Password" />
						</div>
						<div class="formValidator">
							<span id="ca_confirmPassword_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel">
							<label for="ca_email">Email:</label>
						</div>
						<div class="formInput">
							<input type="text" id="ca_email" placeholder="Account Email" />
						</div>
						<div class="formValidator">
							<span id="ca_email_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel">
							<label for="ca_confirmEmail">Confirm Email:</label>
						</div>
						<div class="formInput">
							<input type="text" id="ca_confirmEmail" placeholder="Confirm Email" />
						</div>
						<div class="formValidator">
							<span id="ca_confirmEmail_validator"></span>
						</div>
					</div>
					
					<div class="formRow">
						<div class="formLabel"></div>
						<div class="formInput">
							<button type="submit" id="submitCreateAccount" class="button createAccount">Create</button>
						</div>
					</div>
				</form>
			</section>
		</div>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

		<!--[if IE]>
		<div id='incompatible'>
			Internet Explorer is unsupported for the duration of 
			Chrysellia's beta. For the best experience, use another browser. Try
			<a href="http://http://www.google.com/chrome">Chrome</a>, 
			<a href="http://www.mozilla.com/en-US/firefox/">Firefox</a>, 
			<a href="http://www.apple.com/safari/">Safari</a>, or 
			<a href="http://www.opera.com">Opera</a>.
		</div>
		
		<script type='text/javascript'>
			$(function(){
				$("#incompatible").dialog({ modal: true, title: "Unsupported Browser" });
			});
		</script>
		<![endif]-->
		
		<script id="topstmpl" type="text/x-jquery-tmpl">
			{{each character }}
				<li title="#${$index + 1}: ${Name} ${AlignName(AlignGood, AlignOrder)} ${Level} ${vc.Races[RaceId].Name}" class="${vc.Races[RaceId].Name}">
					<div>
						<h2 class='rank number_${$index + 1}'>#${$index + 1}</h2>
						<h3 class='charName'>${Name}</h3>
						<span class='charDetails'>${AlignName(AlignGood, AlignOrder)} Level ${Level} ${vc.Races[RaceId].Name}</span>
					</div>
				</li>
			{{/each}}
		</script>
		
		<!-- Here come the plugins -->
			<script src="./js/jquery.watermark.min.js"></script>
			<script src="./js/jquery.cookie.js"></script>
			<script src="./js/jquery.datalink.js"></script>
			<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
			<script src="./Core/jquery-md5.js" type="text/javascript"></script>
			<script src="./Core/json.js" type="text/javascript"></script>
		<!-- <script src="./js/plugins.min.js"></script>-->
				
		<!-- Here come the services -->
			<script src="./Core/core.js"></script>
			<script src="./Core/core-AccountService.js"></script>
			<script src="./Core/core-CharacterService.js"></script>
			<script src="./Core/core-APIService.js"></script>
		<!-- <script src="./Core/core.min.js"></script>-->
		
		<!-- Here come the data libraries -->
		<script src="./Core/staticInfo/races.js"></script>
		
		<!-- Page setup -->
		<script src="./js/startup.js"></script>
		<script src="./js/tops-startup.js"></script>
		
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script type="text/javascript">

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