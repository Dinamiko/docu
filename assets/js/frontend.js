jQuery(document).ready(function($) {

	if( jQuery().masonry ) {

		var container = $('.items');
			
		container.imagesLoaded( function() {
			container.masonry({"gutter": 20});		
		});

	} 

	// show/hide docu-single-nav link texts based on window with

	var prev_text = $('.docu-single-nav-prev a').after().text();
	var next_text = $('.docu-single-nav-next a').after().text();

	function onResizeDocu() {

		if( $('.docu-single-nav-prev').length )  {

			if( $(window).width() <= 768 ) {

				$('.docu-single-nav-prev a').before().text( '' );

			} else {

				$('.docu-single-nav-prev a').before().text( prev_text );

			}

		}

		if( $('.docu-single-nav-next').length )  {

			if( $(window).width() <= 768 ) {

				$('.docu-single-nav-next a').after().text( '' );

			} else {

				$('.docu-single-nav-next a').after().text( next_text );

			}

		}
	
	}
	
	$(window).resize(onResizeDocu);
	onResizeDocu();
	
});