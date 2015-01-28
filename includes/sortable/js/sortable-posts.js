jQuery(document).ready(function($) {

	$('#the-list').sortable({

		items: 'tr',
		cursor: 'move',
		axis: 'y',

		update: function() {

			var order = $(this).sortable('serialize') + '&action=order_docs';
			$.post(ajaxurl, order, function(response) {});

		}
		
	});
	
});