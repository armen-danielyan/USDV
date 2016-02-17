( function( $ ) {

	function removeNoJsClass() {
		$( 'html:first' ).removeClass( 'no-js' );
	}

	/* Superfish the menu drops ---------------------*/
	function superfishSetup() {
		$('.menu').superfish({
			delay: 200,
			animation: {opacity:'show', height:'show'},
			speed: 'fast',
			cssArrows: true,
			autoArrows:  true,
			dropShadows: false
		});
	}

	/* Flexslider ---------------------*/
	function flexSliderSetup() {
	
		$('.slides li > img:gt(0)').addClass(
		     function(i){return 'lazy';}
		);
		
		if( ($).flexslider) {
			var slider = $('.flexslider');
			slider.fitVids().flexslider({
				slideshowSpeed		: slider.attr('data-speed'),
				animationDuration	: 600,
				animation			: 'fade',
				video				: false,
				useCSS				: false,
				prevText			: '<i class="fa fa-angle-left"></i>',
				nextText			: '<i class="fa fa-angle-right"></i>',
				touch				: false,
				animationLoop		: true,
				smoothHeight		: true,
				pauseOnAction		: true,
				pauseOnHover		: true,
				
				start: function(slider) { // Fires when the slider loads the first slide
					slider.removeClass('loading');
					$( ".preloader" ).hide();
					
			      	var slide_count = slider.count - 1;
			      	$(slider)
				        .find('img.lazy:eq(0)')
				        .each(function() {
				        	var src = $(this).attr('data-src');
				        	$(this).attr('src', src).removeAttr('data-src');
			        });
			    },
			    before: function(slider) { // Fires asynchronously with each slider animation
			    	var slides	= slider.slides,
			    	index      	= slider.animatingTo,
			    	$slide     	= $(slides[index]),
			    	$img       	= $slide.find('img[data-src]'),
			    	current    	= index,
			    	nxt_slide  	= current + 1,
			     	prev_slide 	= current - 1;
			
			  	$slide
			    	.parent()
			    	.find('img.lazy:eq(' + current + '), img.lazy:eq(' + prev_slide + '), img.lazy:eq(' + nxt_slide + ')')
			    	.each(function() {
			      		var src = $(this).attr('data-src');
			      		$(this).attr('src', src).removeAttr('data-src');
			  		});
				}
			});
		}
	}
		
	/* Portfolio Filter ---------------------*/
	function isotopeSetup() {
		var mycontainer = $('#portfolio-list');
		mycontainer.isotope({
			itemSelector: '.portfolio-item'
		});
	
		// filter items when filter link is clicked
		$('#portfolio-filter a').click(function(){
			var selector = $(this).attr('data-filter');
			mycontainer.isotope({ filter: selector });
			return false;
		});
	}
	
	/* Animating Menu Setup ---------------------*/
	function navScrollSetup() {
		$('#header').data('size','big');
	}
	
	/* Nav Scroll Animation ---------------------*/
	function navScroll() {
		
		var $header = $('#header');
		var $headerbg = $('.header-bg');
		var $logow = $('.logo-light');
		var $logob = $('.logo-dark');

		if ($(document).scrollTop() > 24) {
			if ($header.data('size') == 'big') {
				$header.data('size','small').removeClass('header-large');
				$header.data('size','small').addClass('header-small');
				$logob.data('size','small').fadeIn( 250 );
				$logow.data('size','small').fadeOut( 250 );
				$headerbg.data('size','small').fadeIn( 250 );
			}
		} else {
			if ($header.data('size') == 'small') {
				$header.data('size','big').addClass('header-large');
				$header.data('size','big').removeClass('header-small');
				$logob.data('size','big').fadeOut( 250 );
				$logow.data('size','big').fadeIn( 250 );
				$headerbg.data('size','big').fadeOut( 800 );
			}
		}
	}
			
	function modifyPosts() {
	
		/* Insert Nav Arrow Before Submenu ---------------------*/
		$('<span class="nav-arrow"></span>').insertBefore('ul.sub-menu li:first-child, ul.menu ul li:first-child');
		
		/* Insert Line Break Before More Links ---------------------*/
		$('<br />').insertBefore('.content a.more-link');
		
		/* Hide Comments When No Comments Activated ---------------------*/
		$('.nocomments').parent().css('display', 'none');
		
		/* Animate Page Scroll ---------------------*/
		$(".scroll").click(function(event){
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
		});
		
		/* Fit Vids ---------------------*/
		$('.feature-vid, .content').fitVids();
		
	}
	
	$( document )
	.ready( removeNoJsClass )
	.ready( navScrollSetup )
	.ready( navScroll )
	.ready( superfishSetup )
	.ready( modifyPosts )
	.on( 'post-load', modifyPosts );
	
	$( window )
	.load( flexSliderSetup )
	.load( isotopeSetup )
	.scroll( navScroll )
	.resize( isotopeSetup );
	
})( jQuery );