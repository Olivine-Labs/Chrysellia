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
		
		<title>Chrysellia (Beta 2)</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		
		<!--<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<link href="css/tipsy.css" rel="stylesheet" media="screen" />-->
		<link href="css/neflaria.min.css" rel="stylesheet" media="screen" />
		<link href="css/grid.min.css" rel="stylesheet" media="screen" />
		
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
	<body class="index">	
	<?php
		$newsFeed = new SimplePie();

		$newsFeed->set_feed_url("http://blog.chrysellia.com/atom/");
		$newsFeed->set_item_limit(4);

		$newsFeedSuccess = $newsFeed->init();
		$newsFeed->handle_content_type();
		
		
		?>
		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span class="info">Online: <span id="onlines" class="loading">...</span></span>
					<span class="info">News: 
						<?php
							if ($newsFeedSuccess):
							?>
								<?php 
								foreach($newsFeed->get_items(0, 1) as $item){
								?>
									<a href="<?php if ($item->get_permalink()) echo $item->get_permalink() ?>" target="_blank"><?php echo $item->get_title(); ?></a> - (<date><?php echo $item->get_date('j M Y, g:i a'); ?></date>)
								<?php } ?>
						<?php endif; ?>
					</span>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div id="navigation">
			<div class="container_12">
				<div class="grid_12" id="mainNav">
					<nav>
						<ul>
							<li><a href="index.php" class="selected">Home</a></li>
							<li><a href="account.php" class="playNow">Play</a></li>
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
				</div>
			</div>
		</div>
		
		<section id="top10" class="container_12">
			<div class="grid_12">
			<h1>Top 30:</h1>
				<ul id="topList">
				</ul>
			</div>
		</section>
		
		<div class="container_12">
			<div class="mainContainer">
				<div class="grid_12">
					<header class="pageHeader">
						<h1>Chrysellia</h1>
						<h2>The classic free online RPG</h2>
						<a class="button bigButton" href="#" id="btnPlayNow">Play Now!</a>
					</header>
				</div>
				
				<div class="clear"></div>
				
				<div class="container_8">
					<section class="grid_8 news">
						<h1>News</h1>
						<section class="mainNews newsItem">
							<h1>Chrysellia: Beta 2 Has Begun!</h1>
							<em class="alternate"><date>2/16/11</date> - by Silwar Naiilo</em>
							<p>
								We made a lot of changes to Chrysellia. <a href="https://docs.google.com/a/neflaria.com/document/d/1IPe8gfz3TidozV7xrtKNO2ij2lRmHRQcQI-kw2Zsd3o/edit?hl=en&pli=1&authkey=COr4h7UB" target="_blank">View the patch notes here</a>. Notable entries:
							</p>
							
							<ul>
								<li>
									Alignment gains from monsters- and alignment colors for anyone with positive or negative 100! Alignment colors blend
									based on your overall alignment. <a href="http://blog.chrysellia.com/2011/02/01/blended-alignment-colors/" target="_blank">Read more here</a>.
								</li>
								<li>
									More items! Over 350, to be exact. All kinds of weapons, spells, and armor for you to use.
								</li>
								<li>
									New chat commands: /id, /m, and some new chat settings. Read about all of the commands at the <a href="http://wiki.chrysellia.com/index.php?title=Chat_System" target="_blank">chat commands wiki page</a>.
								</li>
								<li>
									Masteries that improve how you use your gear
								</li>
								<li>
									Tops list page
								</li>
								<li>
									More locations to explore, and more monsters to fight
								</li>
								<li>
									Myriad bug fixes
								</li>
								<li>
									Decreased movement delay, and TONS of code optimizations
								</li>
							</ul>
							<p>
								Remember- Chrysellia is in beta and you may run into a bug or two. Tell Silwar Naiilo or Sexy Lingerie and you'll find 
								help as quickly as possible. We'll try to get bug fixes in asap.
							</p>
							<p>
								Chrysellia is run entirely by donations. If you enjoy the game, please consider donating towards our servers-
								that means less lag and better availability!
							</p>
							<p>
								Keep up with the <a href="http://blog.chrysellia.com">Chrysellia Blog</a> for update notes, and join the 
								<a href="http://forum.chrysellia.com">Chrysellia Forum</a> for up-to-date information.
							</p>
						</section>
						
						<section class="secondaryNews newsItem">
							<h1>News</h1>
								<?php
									if ($newsFeedSuccess):
									?>
									<ul>
										<?php 
										foreach($newsFeed->get_items(0, 5) as $item){
										?>
											<li class="alternate"><a href="<?php if ($item->get_permalink()) echo $item->get_permalink() ?>" target="_blank"><?php echo $item->get_title(); ?></a> - (<date><?php echo $item->get_date('j M Y, g:i a'); ?></date>)</li>
										<?php } ?>
										<li><a href="http://blog.chrysellia.com/atom/" class="alternate rssFeed">Subscribe to the Chrysellia News RSS</a></li>
										<li><a href="http://www.twitter.com/chrysellia" class="twitter">Follow Chrysellia</a> on Twitter</li>
									</ul>
									
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
		
		<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
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
		
		<!-- Here come the plugins
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
		<script src="./js/jsend.min.js"></script>
		<script src="./js/jquery.tipsy.js"></script>-->
		<script src="./js/plugins.min.js"></script>
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<script src="./Core/core-APIService.js"></script> -->
		<script src="./Core/core.min.js"></script>
		
		<!-- Data Libraries
		<script src="./Core/staticInfo/races.js"></script>-->
		<script src="./Core/staticInfo/libraries.min.js"></script>

		<!-- Page setup
		<script src="./js/startup.js"></script>
		<script src="./js/index-startup.js"></script> -->
		<script src="./js/startup.min.js"></script>
		<script src="./js/index-startup.min.js"></script>
		
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