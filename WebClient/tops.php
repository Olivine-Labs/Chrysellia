<?php
date_default_timezone_set('America/New_York');
include_once('php/simplepie.inc');
?>

<!DOCTYPE html>

<html lang="en">
	<?php include('head.php'); ?>
	<body class="tops">	
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
							<li><a href="tops.php" class="selected">Rankings</a></li>
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

    <?php include('commonscripts.php'); ?>
		<script src="./js/tops-startup.js"></script>
	</body>
</html>
