<?php
include('../ThirdParty/jsend.class.php');
        
$data = $_POST["data"];
// Checks, Validation etc. 
$jSEND = new \ThirdParty\jSEND();
$str = $jSEND->getData($data); 
?>

<html>
	<head>
		<title>jSEND Decompression Utility</title>
	</head>
	<body>
		<h2>from jSend</h2>
		<form action="jSendDecompression.php" method="post">
			Data:<br />
			<textarea name="data" style="height: 150px; width: 300px;"><?php echo($str); ?></textarea>
			<button type="submit">Convert to json</button>
			<button type="submit" id="convertJsend">Convert to jSend</button>
		</form>
		<script src="http://code.jquery.com/jquery-1.5rc1.js"></script>
		<script src="../../WebClient/js/jsend.min.js"></script>
				
		<script>
			$(function(){
				$("#convertJsend").click(function(e){
					e.preventDefault();
					$("form textarea").val($.jSEND($("form textarea").val()));
				});
			});
		</script>
	</body>
</html>