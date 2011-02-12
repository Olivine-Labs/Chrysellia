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
		
		<title>Chrysellia (Beta)</title>
		
		<!--[if IE]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
		
		
		<link href="css/html5-reset.css" rel="stylesheet" media="screen" />
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen" />
		<link href="css/grid.css" rel="stylesheet" media="screen" />
		<link href="css/neflaria-base.css" rel="stylesheet" media="screen" />
		<link href="css/tipsy.css" rel="stylesheet" media="screen" />
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
	<body class="about">	
	<?php
		$newsFeed = new SimplePie();

		$newsFeed->set_feed_url("http://blog.chrysellia.com/atom/");
		$newsFeed->set_item_limit(4);

		$newsFeedSuccess = $newsFeed->init();
		$newsFeed->handle_content_type();
		
		
		?>
		<div id="messages"></div>
		
		<div id="navigation">
			<div class="container_12">
				<div class="grid_12" id="mainNav">
					<nav>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="account.php" class="playNow">Play</a></li>
							<li><a href="http://blog.chrysellia.com" target="_blank">Blog</a></li>
							<li><a href="http://wiki.chrysellia.com" target="_blank">Manual</a></li>
							<li><a href="tops.php">Rankings</a></li>
							<li><a href="http://forum.chrysellia.com" target="_blank">Forum</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="U9PMXZHBZPVPJ" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li><a href="about.php" class="selected">About</a></li>
							<li><a href="api.php">API</a></li>
							<li class='fbButton'><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.chrysellia.com&amp;layout=button_count&amp;show_faces=true&amp;width=75&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe></li>
							<!--<li><a href="#">Store</a></li>-->
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
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
				
				<div class="grid_8">
					<section id="about">
						<h1>About Chrysellia</h1>
						<p>
							Chrysellia is the sequel to the popular online game Neflaria, which itself was a ressurection of the game Shimlar.
							Ut ut lorem id sem blandit mollis lobortis sodales dui. Donec interdum aliquam tincidunt. Pellentesque posuere ligula ut mi scelerisque et porta felis accumsan. Nam faucibus tortor in quam cursus fringilla vel euismod nibh. Suspendisse potenti. Mauris consectetur sollicitudin turpis sit amet fermentum. Donec non hendrerit mauris. Duis at mi et lorem porttitor pretium. Pellentesque eu purus consectetur ligula tincidunt iaculis nec et velit. Nullam ut scelerisque leo. Vivamus tincidunt nibh eu ipsum dignissim eu ultrices elit euismod. Sed non nibh sem. Morbi sagittis, libero eget hendrerit hendrerit, nibh diam porta magna, at condimentum tellus libero vel lorem. Etiam laoreet laoreet dui ac adipiscing. Nullam eget ligula non est viverra aliquet sed vitae diam. Aliquam gravida felis at ipsum vestibulum mattis placerat erat imperdiet.
						</p>
						<p>
							Integer bibendum tincidunt felis, sed vehicula sapien volutpat ac. In lobortis nulla a metus accumsan euismod. Suspendisse eu urna erat. Nullam scelerisque turpis nec ante eleifend non accumsan turpis ultrices. Proin porta molestie eros sed pellentesque. Suspendisse vehicula luctus scelerisque. Suspendisse elementum mollis libero, pulvinar adipiscing quam convallis non. Etiam iaculis cursus consectetur. Fusce libero mauris, dictum in ornare tincidunt, iaculis in mi. Suspendisse facilisis interdum sapien at mollis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin molestie odio eget lectus pharetra volutpat. Nam sit amet leo id est luctus auctor a quis tellus. Curabitur dapibus pellentesque est, nec dictum metus ullamcorper eget.
						</p>
					</section>
					<section id="tech">
						<h1>Technology Credits</h1>
						<p>
							Chrysellia couldn't be possible without the awesome open-source tools and libraries provided at no cost, under free licenses.
							Some of the many tools we used include:
						</p>
						<ul>
							<li>
								<a href="http://www.php.net/" target="_blank">PHP</a>
								<p>
									Chrysellia's engine runs on PHP; all of the logic flows through a series of PHP methods, 
									which retrieve and process information from the database.
								</p>
							</li>
							<li>
								<a href="http://jsend.org/" target="_blank">jSend</a>
								<p>
									jSend is a compression library for encoding and decoding request strings, making server
									requests even faster by compressing the data sent to the server.
								</p>
							</li>
							<li>
								<a href="http://simplepie.org/" target="_blank">SimplePie</a>
								<p>
									SimplePie provided the RSS reader for our news post on our index page, and other locations.
								</p>
							</li>
							<li>
								<a href="http://www.mysql.com/" target="_blank">MySQL</a>
								<p>
									All of the data that flows through the game comes from the MySQL database engine - the most
									popular open-source database solution.
								</p>
							</li>
							<li>
								<a href="http://jquery.com/" target="_blank">jQuery</a>
								<p>
									The incredible jQuery library allowed us to complete rapid development on the client-side, saving
									us literally weeks of work by providing much of the functionality that we would have otherwise
									hand-written.
								</p>
							</li>
							<li>
								<a href="http://jqueryui.com/" target="_blank">jQuery UI</a>
								<p>
									Just as the jQuery library gave us the core of our application, jQuery UI provided the framework
									for much of the interactions.
								</p>
							</li>
							<li>
								<a href="https://github.com/jquery/jquery-datalink" target="_blank">jQuery datalink</a>
								<p>
									The jQuery datalink plugin allowed us to create and bind data to templates, thus simplifying much
									of our client code.
								</p>
							</li>
							<li>
								<a href="http://onehackoranother.com/projects/jquery/tipsy/" target="_blank">jQuery Tipsy</a>
								<p>
									Tipsy provided the tooltips across the interface; most notably, the tops list on the home page.
								</p>
							</li>
							<li>
								<a href="http://code.google.com/p/jquery-watermark/" target="_blank">jQuery Watermark</a>
								<p>
									jQuery Watermark provided friendly browser textbox hints for non-html5 browsers.
								</p>
							</li>
							<li>
								<a href="http://gsgd.co.uk/sandbox/jquery/easing/" target="_blank">jQuery Easing</a>
								<p>
									jQuery Easing allowed us to use advanced transitions in the UI.
								</p>
							</li>
						</ul>
					</section>
				</div>
				<div class="grid_4">
					<section id="team">
						<h1>Chrysellia Team</h1>
						<article>
							<h1>Drew Ditthardt</h1>
							<h2>Sexy Lingerie</h2>
							<p>
								<img src="./css/images/sexy_lingerie.jpg" />
								Drew is the lead server developer. He handles management and implementation of the code that facilitates modification and access to the database on the client's behalf. His PHP skills are legendary as is his love of cheesecake and beer, but not mixed together.
							</p>
						</article>
						<article>
							<h1>Jack Lawson</h1>
							<h2>Silwar Naiilo</h2>
							<p>
								<img src="./css/images/silwar.jpg" />
								Jack Lawson is the lead UI developer, in charge of creating the code with which users interact with the game. He directs the flow of the
								interface and creates the user experience with his wicked sweet jQuery and html 5 skills. Outside of Chrys, he is a husband, a father, and
								a UI consultant- and, most of all, an obscenely snobbish coffee <em>connoisseur</em>.
								<br />
								<br />
								<a href="http://www.twitter.com/ajacksified">@ajacksified</a> on twitter
							</p>
						</article>
						<article>
							<h1>Don Horn</h1>
							<h2>Nullifiednll</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
						<article>
							<h1>Kirus Tiberius</h1>
							<h2>Kirus</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
						<article>
							<h1>Dave Thomas</h1>
							<h2>Mage</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
						<article>
							<h1>Chris</h1>
							<h2>RequieM</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
						<article>
							<h1>Roger Thomas</h1>
							<h2>Outkast</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
						<article>
							<h1>William Thomas</h1>
							<h2>Irish Drinker</h2>
							<p>
								I just copypasted some lorem ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit, nunc nec iaculis consequat, lacus erat tincidunt sem, eu aliquet tortor dui non ipsum. Duis sollicitudin neque in sapien adipiscing porttitor. Donec sapien diam, fringilla et imperdiet in, porttitor eu velit. Nulla ornare mi eget nunc lobortis lacinia.
							</p>
						</article>
					</section>
				</div>
				
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
		
		<!-- Here come the plugins -->
		<script src="./js/jquery.watermark.min.js"></script>
		<script src="./js/jquery.cookie.js"></script>
		<script src="./Core/jquery-md5.js" type="text/javascript"></script>
		<script src="./Core/json.js" type="text/javascript"></script>
		<script src="./js/jsend.min.js"></script>
		<script src="./js/jquery.tipsy.js"></script>
		<!-- <script src="./js/plugins.min.js"></script>-->
				
		<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->
		<script src="./Core/core.js"></script>
		<script src="./Core/core-AccountService.js"></script>
		<script src="./Core/core-CharacterService.js"></script>
		<!-- <script src="./Core/core.min.js"></script> -->
		
		<!-- Page setup -->
		<script src="./js/startup.js"></script>
		<script src="./js/about-startup.js"></script>
		
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