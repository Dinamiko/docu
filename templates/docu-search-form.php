<?php
/**
 *  This template is used to display the search form
 */
?>

<div class="docu-container">
	<div class="docu-wrapper-search">
		
		<form action="<?php echo site_url('/');?>" method="post" id="search-doc">

			<div class="docu-search-container">
				<input type="text" name="s" placeholder="<?php _e( 'Search', 'docu' );?>"/>
				<button id="docu-search-button" type="submit"/>
				<input type="hidden" name="docu_post_type" value="doc" />
				<?php wp_nonce_field('docu_action','docu_nonce_field');?>
			</div>

		</form>

	</div>
</div>