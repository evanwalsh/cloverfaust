$(document).ready(function(){
	setTimeout('$(".message").fadeOut(500)',1500)
	setTimeout('$(".message").remove()',2000);
	$(".message,.error").click(function(){
		$(this).remove();
	});
	$(document).ready(function(){
		$("#username").after('<div class="v"></div>');
		$("#username").change(function(){
			$.get("http://localhost/klei/api/get/user:check/"+$(this).val(),function(v){
				var d = $("#username").next().html(v);
			});
		});
		var url = 'http://localhost/klei/api/home/recentreplies/';
		var url2 = 'http://localhost/klei/api/home/recentposts/';
		$("#recentreplies .posts,#recentworld .posts").css({"background":"url(load-block.gif) no-repeat center center","padding":"35px"});
		var offset = '0';
		$("#recentreplies .posts").load(url+offset,1,function(){
			$(this).css({"background":"none","padding":"10px"});
		});
		$("#recentworld .posts").load(url2+offset,1,function(){
			$(this).css({"background":"none","padding":"10px"});
		});
		$(".uparrow").click(function(){
			offset = parseInt(offset)-5;
			var postArea = $(this).parent().next();
			if(offset < 0){ offset = 0; }
			if($(this).parents().filter("#recentreplies") !== "div#recentreplies.block"){ url = url2; }
			else{ url = url; }
			$(postArea).load(url+offset);
		});
		$(".downarrow").click(function(){
			offset = parseInt(offset)+5;
			var postArea = $(this).parent().next();
			if(offset < 0){ offset = 0; }
			if($(this).parents().filter("#recentreplies") !== "div#recentreplies.block"){ url = url2; }
			else{ url = url; }
			$(postArea).load(url+offset);
		});
		$("#side ul li a").prepend("&raquo; ");
	});
});