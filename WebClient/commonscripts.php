<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
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


<!-- For the production version, we'll minify and combine our javascript, and keep a plain version for us -->

  
<!-- Game services -->
<?php
$debug = false;

if($debug){?>
  <!-- Here come the plugins -->
  <script src="./js/jquery.watermark.min.js"></script>
  <script src="./js/jquery.cookie.js"></script>
  <script src="./Core/jquery-md5.js" type="text/javascript"></script>
  <script src="./Core/json.js" type="text/javascript"></script>
  <script src="./js/jsend.min.js"></script>
  <script src="./js/jquery.tipsy.js"></script>
  <script src="./js/jstorage.js"></script>
  <script src="./js/consolefix.js"></script>

  <script src="./Core/core.js"></script>
  <script src="./Core/core-AccountService.js"></script>
  <script src="./Core/core-CharacterService.js"></script>
  <script src="./Core/core-CommandService.js"></script>
  <script src="./Core/core-ChatService.js"></script>
  <script src="./Core/core-MapService.js"></script>
  <script src="./Core/core-ItemService.js"></script>
  <script src="./Core/core-MonsterService.js"></script>
  <script src="./Core/core-APIService.js"></script>

  <!-- Libraries -->
  <script src="./Core/staticInfo/items.js"></script>
  <script src="./Core/staticInfo/maps.js"></script>
  <script src="./Core/staticInfo/monsters.js"></script>
  <script src="./Core/staticInfo/races.js"></script>

  <!-- Page setup -->
<?php } else { ?>
  <script src="./js/plugins.min.js"></script>
  <script src="./Core/core.min.js"></script>
  <script src="./Core/staticInfo/libraries.min.js"></script>
<?php } ?>

<script src="./js/startup.js"></script>


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

