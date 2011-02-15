$(function(){
	V2Core.SERVERCODE_DIRECTORY = "../Server/";
	V2Core.CompressionMode = V2Core.COMPRESSION_MODE_jSEND;
	
	$.ajaxSetup({
		url: V2Core.SERVERCODE_DIRECTORY + "Index.php",
		dataType: "json",
		global: false,
		timeout: 1000
	});

	vc.CheckVersion(function(v){ if(v !== vc.Version) { alert("Your game file cache is out of date.\nPlease clear your browser's cache."); }  });

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