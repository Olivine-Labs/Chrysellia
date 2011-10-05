<!DOCTYPE html>

<html lang="en">
	
  <?php include('head.php'); ?>
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
							<li><a href="index.php" class="selected">Home</a></li>
							<li><a href="account.php" class="playNow">Play</a></li>
							<li><a href="tops.php">Rankings</a></li>
							<li><form target="_blank" method="post" action="https://www.paypal.com/cgi-bin/webscr"><input type="hidden" value="_s-xclick" name="cmd"><input type="hidden" value="9TRGSRK4VVC28" name="hosted_button_id"><button type="image" border="0" alt="PayPal - The safer, easier way to pay online!" name="submit" >Donate</button><img width="1" height="1" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" alt=""></form></li>
							<li><a href="about.php">About</a></li>
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
	
    <?php include('commonscripts.php'); ?>
		<script src="./js/account-startup.js"></script>
  </body>
</html>
