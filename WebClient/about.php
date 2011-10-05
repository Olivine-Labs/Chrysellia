<?php
date_default_timezone_set('America/New_York');
include_once('php/simplepie.inc');
?>

<!DOCTYPE html>

<html lang="en">
  <?php include('head.php'); ?>
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
							<li><a href="tops.php">Rankings</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="9TRGSRK4VVC28" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li><a href="about.php" class="selected">About</a></li>
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
								Drew is the lead server developer. He handles management and implementation of the code that facilitates modification and access to the 
								database on the client's behalf. His PHP skills are legendary as is his love of cheesecake and beer, but not mixed together.
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
							<h1>Dave Thomas</h1>
							<h2>Mage</h2>
							<p>
								<img src="./css/images/mage.jpg" />
								Dave Thomas (not related to the other Thomas's) joined our team late, but quickly come up to speed. He has been responsible for managing 
								the database, and the large amounts of content within it. He's married, has a young son, and works as a Java programmer. His love of Java 
								is only surpassed by that of chocolate chip cookies.
							</p>
						</article>
						<article>
							<h1>Don Horn</h1>
							<h2>Nullifiednll</h2>
							<p>
								<img src="./css/images/nullifiednll.jpg" />
								Don Horn is a server administrator for Chrysellia; he runs one of the data clusters and works with Drew on server and network architecture. 
								He's always had a passion for computers; and, when he's not working, he spends time with the other hardware in his life- his car, a carefully
								restored Camaro.<span style="color: #333;">lulz</span>
							</p>
						</article>
						<article>
							<h1>Kirus Tiberius</h1>
							<h2>Kirus</h2>
						</article>
						<article>
							<h1>Chris</h1>
							<h2>RequieM</h2>
						</article>
						<article>
							<h1>Roger Thomas</h1>
							<h2>Outkast</h2>
						</article>
						<article>
							<h1>William Thomas</h1>
							<h2>Irish Drinker</h2>
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
  
    <?php include('commonscripts.php'); ?>
    <script src="./js/index-startup.js"></script>
  </body>
</html>
