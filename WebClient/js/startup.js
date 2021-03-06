;$(function(){
	V2Core.SERVERCODE_DIRECTORY = "./Server/";
	V2Core.API_URI = "./Server/API.php";
	V2Core.CompressionMode = V2Core.COMPRESSION_MODE_jSEND;
	V2Core.Version = "0.2.1";
	
	$.ajaxSetup({
		url: V2Core.SERVERCODE_DIRECTORY + "index.php",
		dataType: "json",
		global: false,
		timeout: 3333
	});

	vc.CheckVersion(function(v){ if(v != vc.Version) { $.jStorage.flush(); alert("Your game file cache is out of date.\nPlease clear your browser's cache."); }  });

	$("a").focusin(function() {
	  $(this).css("opacity",.75);
	}).focusout(function() {
	  $(this).css("opacity",1);
	}).mouseup(function() {
	  $(this).css("opacity",1);
	});
			
	$("input").each(function(){
		$(this).watermark($(this).attr("placeholder"), {className: 'watermark'});
	});
});
