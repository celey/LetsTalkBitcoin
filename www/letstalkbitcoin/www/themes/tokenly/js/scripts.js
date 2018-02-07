$(document).ready(function(){
	var pageTitle = document.title;

	$('body').delegate('.delete', 'click', function(e){
		var check = confirm('Are you sure you want to delete?');
		if(!check || check == null){
			e.preventDefault();
			return false;
		}
	});
	
	if($('#html-editor').length > 0){
		CKEDITOR.replace( 'html-editor' );
	}
	if($('#mini-editor').length > 0){	
		CKEDITOR.replace( 'mini-editor' );
	}
	
	$('.header-top .menu').find('li').hover(function(){
		$(this).find('ul').show();
	},function(){
		$(this).find('ul').hide();
	});
	
	$('.header-top .notify-pull').click(function(e){
		e.preventDefault();
		if($(this).hasClass('collapse')){
			$('.notify-list').hide();
			$(this).removeClass('collapse');
		}
		else{
			$('.notify-list').show();
			$(this).addClass('collapse');
			var url = window.siteURL + '/account/notifications/setread';
			$.get(url, function(data){
				$('.notify-pull').html(0);
				$('.notifications').removeClass('has-notes');
				document.title = pageTitle;
			});
		}
	});

	
	$('.markdown-trigger').click(function(e){
		if($(this).hasClass('collapse')){
			$('#markdown-guide').slideUp();
			$(this).removeClass('collapse');
		}
		else{
			$('#markdown-guide').slideDown();
			$(this).addClass('collapse');
		}
		e.preventDefault();

	});
	
	$('.collapse-trigger').click(function(e){
		e.preventDefault();
		var target = $(this).data('trigger');
		if($(this).hasClass('collapse')){
			$('#' + target).slideUp();
			$(this).removeClass('collapse');
		}
		else{
			$('#' + target).slideDown();
			$(this).addClass('collapse');
		}
	});

});
