$(function(){
	//list
	$('.view-grid').on('click',function(){
		$('.list-wrapper').removeClass('agenda-list');
		$('.list-wrapper').addClass('card-list');
	});
	$('.view-agenda').on('click',function(){
		$('.list-wrapper').removeClass('card-list');
		$('.list-wrapper').addClass('agenda-list');
	});
	
	//search-modal
	$('#search-modal').hide();
	$('#search-modal__close').on('click', function(){
		$('#search-modal').hide();
	});
	$('#search-toggler').on('click', function(){
		$('#search-modal').show();
	});
	$('.layer').on('click', function(){
		$('#search-modal').hide();
	});

	//accodion
	var w = $(window).width();
	accodionMenu();
	window.addEventListener('resize', function(){
		w = $(window).width();
		accodionMenu();
	});

	function accodionMenu(){
		if(w < 768){
			$('#nav-toggler').on('click',function(){
				$('#global-nav').slideToggle();
			});
		} else {
			$('#global-nav').show();
		}
	};
	
	
});