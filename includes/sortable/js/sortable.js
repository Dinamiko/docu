jQuery(document).ready(function($) {

	$('#the-list').sortable({

		items: 'tr',
		cursor: 'move',
		axis: 'y',

		update: function() {

			var params={};
			window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});

			if ( params['taxonomy'] ) {

				if( params['taxonomy'] == 'doc_category') {

					var order = $(this).sortable('serialize') + '&action=order_categories';

				}			

			} else {

				var order = $(this).sortable('serialize') + '&action=order_docs';				

			}

			$.post(ajaxurl, order, function(response) {});

		}
		
	});
	
});