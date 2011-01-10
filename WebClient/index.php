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
	<body>
		<!--<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span class="info">Online: <span id="onlines">0</span></span>
					<span class="info">News: <a href="#">We've updated the graphics, and redeveloped some...</a></span>
				</div>
			</div>
			<div class="clear"></div>
		</div>-->
		
		<div id="navigation">
			<div class="container_12">
				<div class="grid_12" id="mainNav">
					<nav>
						<ul>
							<li><a href="index.php" class="selected">Home</a></li>
							<li><a href="#" class="playNow">Play</a></li>
							<li><a href="http://blog.chrysellia.com" target="_blank">Blog</a></li>
							<li><a href="http://wiki.chrysellia.com" target="_blank">Manual</a></li>
							<!--<li><a href="#">Rankings</a></li>-->
							<li><a href="http://forum.chrysellia.com" target="_blank">Forum</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="U9PMXZHBZPVPJ" name="hosted_button_id"><input type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" src="./css/images/donate.png" class='donateButton'><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<!--<li><a href="#">Store</a></li>-->
						</ul>
					</nav>
					
					<div class="quickLogin">
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
		
		<section id="top10" class="container_12">
			<div class="grid_12">
			<h1>Top 25 (Level):</h1>
				<ul>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
		</section>
		
		<div class="container_12">
			<div class="mainContainer">
				<div class="container_8">
					<div class="grid_8">
						<header class="pageHeader">
							<h1>Chrysellia</h1>
							<h2>The classic free online RPG</h2>
							<a class="button bigButton" href="#" id="btnPlayNow">Play Now!</a>
						</header>
					</div>
					
					<div class="clear"></div>
					
					<section class="grid_8 news">
						<h1>News</h1>
						<section class="mainNews newsItem">
							<h1>Chrysellia Beta Open</h1>
							<em class="alternate"><date>1/11/10</date> - by Silwar Naiilo</em>
							<p>
								Chrysellia is finally in beta! Here's a few points to remember:
								<ul>
									<li>
										Chrysellia was developed for the <a href="https://gaming.mozillalabs.com/" target="_blank">Mozilla Labs Game On</a> 
										competition. As such, Chrysellia is NOT feature-complete. We took the game to the point of playability, with most 
										of the features of Neflaria, and we plan on adding a whole lot more after the juding period. Things like:
										<ul>
											<li>Extended Clan Wars</li>
											<li>New Continents to Explore</li>
											<li>New Races, Weapons, Spells, and Armors</li>
											<li>Storyline Quests</li>
										</ul>
									</li>
									<li>
										Chrysellia is in beta and you may run into a bug or two. Tell Silwar Naiilo or Sexy Lingerie and you'll find 
										help as quickly as possible. Due to the rules of the gaming competition, however, we can't actually <em>fix</em>
										bugs until the judging period has ended.
									</li>
									<li>
										Chrysellia is run entirely by donations. If you enjoy the game, please consider donating towards our servers.
										That means less lag and better availability.
									</li>
									<li>
										Keep up with the <a href="http://blog.chrysellia.com">Chrysellia blog</a> for updates and answers to questions!
									</li>
								</ul>
							</p>
						</section>
						
						<section class="secondaryNews newsItem">
							<h1>News</h1>
							<?php
								$newsFeed = new SimplePie();

								$newsFeed->set_feed_url("http://blog.chrysellia.com/atom/");
								$newsFeed->set_item_limit(4);

								$newsFeedSuccess = $newsFeed->init();
								$newsFeed->handle_content_type();
								
								if ($newsFeedSuccess):
									?>
									<ul>
										<?php 
										foreach($newsFeed->get_items() as $item){
										?>
											<li class="alternate"><a href="<?php if ($item->get_permalink()) echo $item->get_permalink() ?>"><?php echo $item->get_title(); ?></a> - (<date><?php echo $item->get_date('j M Y, g:i a'); ?></date>)</li>
										<?php } ?>
									</ul>
									<a href="http://blog.chrysellia.com/atom/" class="alternate">Subscribe to RSS</a> - <a href="http://www.twitter.com/neflaria">@Neflaria</a> on twitter
								<?php endif; ?>
						</section>
					</section>
					
					<!--
					<section class="grid_4 fromManual">
						<h1>From the Manual</h1>
						<h2>Race Choices</h2>
						<p></p>
						<a href="#" class="alternate">Visit the Manual</a>
					</section>-->
				</div>
				
				<div class="grid_4 goodx"></div>
				
				<div class="clear"></div>
			</div>
		</div>
		
		<footer class="copyright">
			<div class="container_12">
				&copy; 2010 <a href="mailto:silwarnaiilo@neflaria.com">Jack Lawson</a> and <a href="mailto:sexylingerie@neflaria.com">Drew Ditthardt</a>, 
				all rights reserved. <a href="tos.html">Terms of Service</a> - <a href="pp.html">Privacy Policy</a> - <a href="mailto:administration@neflaria.com">Contact</a>
			</div>
		</footer>
		
		<div id="playNow" style="display:none">
			<section class="register">
				<h1>Register</h1>
				<p><a class="fb_button fb_button_medium" id="fbregister" href="#"><span class="fb_button_text">Log In</span></a> and skip registration!</p>
				<em class="or">or</em>
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
						<span class="explanation">
							Once you've clicked "create", check your e-mail for a confirmation from accounts@neflaria.com. Be sure 
							to check your spam folder if you don't see anything within 30 minutes. <a href="#">Help?</a>
						</span>
					</div>
					
					<div class="formRow">
						<div class="formLabel"></div>
						<div class="formInput">
							<button type="submit" id="submitCreateAccount" class="button createAccount">Create</button>
						</div>
					</div>
				</form>
			</section>
			<section class="logIn">
				<h1>Log In</h1>
				<p><a class="fb_button fb_button_medium" id="fblogin" href="#"><span class="fb_button_text">Log In</span></a></p>
				<em class="or">or</em>
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
		</div>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
		
		<!--[if lte IE 8]>
		<div id='incompatible'>
			Internet Explorer version 8 and leser are unsupported for the duration of 
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
		
		<!-- Here come the plugins -->
		<!-- <script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>-->
		<script src="./js/plugins.min.js"></script>
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->
		<!-- <script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>-->
		<script src="./Core/core.min.js"></script>
		
		<!-- Page setup -->
		<script src="./js/startup.js"></script>
		<script src="./js/index-startup.js"></script>
		
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		
	</body>
</html>