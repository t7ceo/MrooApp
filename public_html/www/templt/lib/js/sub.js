jQuery(function($){
	//snb
	$('#side_menu li a.on').next('ul').addClass('current');
	$('#side_menu li .tit').mouseenter(function(event){
		var $target=$(event.target);
		if($target.is('.on')){
			$(this).stop();
		}else{
			$(this).addClass('open on02').next('ul').stop().slideDown(300);
		};		
	}).focusin(function(event){
		var $target=$(event.target);
		if($target.is('.on')){
			$(this).stop();
		}else{
			$(this).addClass('open on02').next('ul').stop().slideDown(300);
		};		
	}).focusout(function(){
		$(this).removeClass('open on02');
	});
	$('#side_menu li ul').focusin(function(){
		$(this).prev('a.tit').addClass('open on02');
	});
	$('#side_menu >ul li').mouseleave(function(){
			$(this).find('.open').removeClass('open on02').next('ul').stop().slideUp(300);
	});
	$('#side_menu li li a').focusin(function(){
		$(this).addClass('current');
	}).focusout(function(){
		$(this).removeClass('current');
	});
	$('#side_menu li li:last-child()').focusout(function(){
			$('#side_menu a.on').removeClass('open on02');
			$(this).parents('ul').prev('.open').removeClass('open on02').next('ul').stop().slideUp(300);
	});
});