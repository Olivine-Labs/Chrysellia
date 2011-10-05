<?php
date_default_timezone_set('America/New_York');
include_once('php/simplepie.inc');
?>

<!DOCTYPE html>

<html lang="en">
	<?php include('head.php'); ?>

		<div id="messages">
			<div class="container_12">
				<div class="grid_12" id="info">
					<span class="info">Online: <span id="onlines" class="loading">...</span></span>
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
							<li><a href="tops.php">Rankings</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="9TRGSRK4VVC28" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li><a href="about.php">About</a></li>
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
            <article class="mainNews" >
              <h1>Chrysellia: Re-Hosted and Open-Sourced</h1>
              <em class="alternate">10/4/11 - by Silwar Naiilo</em>
              
              <p>
                It's been in interesting journey with Chrysellia. After running <a href="http://www.neflaria.com">Neflaria</a>
                for a while, Drew and I (Jack) decided to attempted to build a sucessor to Neflaria - Chrysellia was built to
                test out some of our architecture decisions. It did this well, and I think that it answered a lot of questions
                and pushed us to see what we could build in a short amount of time.
              </p>

              <p>
                Chrysellia really served as a launching point for many of the things we're building- for example, an experiment
                with Websockets as an alternative to AJAX requests for data spawned 
                <a href="http://www.github.com/Olivine-Labs/Alchemy-Websockets">Alchemy Websockets</a>, an open-source, MIT-licensed
                library meant to help all kinds of applications. We worked on methods to completely seperate the client-side code
                from the server-side code, keeping the presentation and logic layers seperated, which has spawned a web framework
                that we'll be releasing soon. It also created questions about how we're storing data - we've since moved on to
                MongoDB, from MySQL, all generated out of this project.
              </p>
  
              <p>
                So, while Chrysellia was meant to become a core gaming engine, what's come out if it is something even stronger-
                and we're very excited about what we can offer to the community. Feel free to poke around in the code, use it
                as a platform for trying things out, or anything you'd like - the code is MIT-licensed.
              </p>

              <p>
                <a href="http://www.github.com/Olivine-Labs/Chrysellia">Chrysellia code hosted on Github</a>
              </p>
            </article>

						<article class="newsItem">
							<h1>Chrysellia: Beta 2 Has Begun!</h1>
							<em class="alternate">2/16/11 - by Silwar Naiilo</em>
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
            </article>
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
