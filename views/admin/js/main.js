$(document).ready(function(){
	setTimeout('$("#message").fadeOut(500)',1500);
	setTimeout('$("#message").remove()',2000);
	$("#message,#error").click(function(){
		$(this).fadeOut(500);
	});
	$("#forums").sortable({  
		revert: true, 
		containment: '#forums',
		opacity: 0.8,
		placeholder: 'placehold',
		handle: 'img'
	});
});