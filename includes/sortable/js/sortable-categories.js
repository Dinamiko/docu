jQuery(document).ready(function($) {

	$('#the-list').sortable({

		items: 'tr',
		cursor: 'move',
		axis: 'y',

		update: function() {

			console.log('yep!');

			var order = $(this).sortable('serialize') + '&action=order_categories';
			$.post(ajaxurl, order, function(response) {});

		}
		
	});
	
});