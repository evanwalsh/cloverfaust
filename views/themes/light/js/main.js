$(document).ready(function(){
	setTimeout('$("#message").fadeOut(500)',1500);
	setTimeout('$("#message").remove()',2000);
	$("#message,#error").click(function(){
		$(this).fadeOut(500);
	});
	$("#login").click(function(){
		$("#loginform").slideToggle(500);
		return false;
	})
});