function scrollToAnchor(aid){
	var aTag = $("a[name='"+ aid +"']");
	$('html,body').animate({scrollTop: aTag.offset().top - 80},'slow');
}

function checkPage()
{
	var checkHeader = $.inviewport($('.main-marker'), {threshold : 0});
	var navHeight = $('.nav-cont').height();
	if(!checkHeader){
		$('.nav-cont').addClass('fixed-nav');
		//$('.main').attr('style', 'top: ' + navHeight + 'px');
	}
	else{
		$('.nav-cont').removeClass('fixed-nav');
		//$('.main').removeAttr('style');
	}
	
}

$(document).ready(function(){
	
	tinymce.baseURL = window.siteURL + '/resources/tinymce/js/tinymce';
	tinymce.init({selector:'#html-editor', skin: 'light', plugins: 'anchor,hr,image,link,media,table,lists,code', forced_root_block: false,
		extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]"}
	);	
	
	$('.smooth-scroll').click(function(e){
		e.preventDefault();
		var name = $(this).attr('name');
		scrollToAnchor(name);
	});
	
	$('.back-top').click(function(e){
		e.preventDefault();
		$('html,body').animate({scrollTop: 0},'slow');
	});
	
	$(window).scroll(function(){
		checkPage();
	});

	$('.delete').click(function(e){
		var check = confirm('Are you sure you want to delete?');
		if(!check || check == null){
			e.preventDefault();
			return false;
		}
	});
	
	$('.mobile-pull').click(function(e){
		e.preventDefault();
		if($(this).hasClass('active')){
			$('.mobile-nav .menu').slideUp();
			$(this).removeClass('active');
		}
		else{
			$('.mobile-nav .menu').slideDown();
			$(this).addClass('active');
		}
	});

});
