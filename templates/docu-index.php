<?php
/**
 *  This template is used to display Docu index page [docu]
 */
?>

<?php 

	global $docu_atts;

	// set columns
	$columns = esc_attr( $docu_atts['columns'] );

	switch ($columns) {

	 	case '1':
	 		$col = 'col1';
	 		break;

	 	case '2':
	 		$col = 'col2';
	 		break;

	 	case '3':
	 		$col = 'col3';
	 		break;

	 	case '4':
	 		$col = 'col4';
	 		break;
	 	
	 	default:
	 		$col = 'col1';
	 		break;

	 } 

	// display search form
	$search = esc_attr( $docu_atts['search'] );

	if( $search && $search == 'true' ) {

		$template = new DOCU_Template_Loader;
		$template->get_template_part( 'docu-search-form' );

	}

?>

<div class="docu-container">
	<div class="docu-wrapper">

		<?php do_action( 'docu_before_index_content' ); ?>

		<div class="items">

		<?php

			$taxonomies = array( 'doc_category' );

			$args = array(
			    'orderby' => 'term_group', 
			    'order' => 'ASC'
			); 

			$terms = get_terms($taxonomies, $args);
								
			foreach ($terms as $term) { ?>

				<div class="docu-item <?php echo $col;?>">

					<h2><a href="<?php echo get_term_link( $term );?>"><?php echo $term->name;?></a></h2>
					<p><?php echo $term->description;?></p>

					<?php

						$list_docs = esc_attr( $docu_atts['list_docs'] );

						// if list_categories is false, display number of documents in the category
						if( $list_docs && $list_docs == 'false' ) { ?>

							<p class="docu-count-documents"><?php echo $term->count;?> documents</p>

						<?php } else { // display a list with all docs in the category ?>

							<ul class="docu-nav-list">

								<?php

								$args = array(
									'post_type' => 'doc',
									'post_status' => 'publish',
									'tax_query' => array(
										array(
											'taxonomy' => 'doc_category',
											'field' => 'id',
											'terms' => array( $term->term_id )
										),
									),
									'orderby' => 'menu_order', 
									'order' => 'ASC'
								);

								$the_query = new WP_Query( $args );

								if ( $the_query->have_posts() ) {

								   	while ( $the_query->have_posts() ) {
								        $the_query->the_post(); ?>

								        <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>

								<?php }

								} 

								wp_reset_postdata();

								?>

							</ul>

						<?php } 

					?>

					<hr>

				</div>

			<?php }

		?>

		</div>

		<?php do_action( 'docu_after_index_content' ); ?>

	</div>
</div>
