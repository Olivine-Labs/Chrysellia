$(function(){
	SERVERCODE_DIRECTORY = "./Server/";

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