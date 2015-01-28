<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Docu_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'docu_widget',
			__('Docu Sidebar Widget', 'docu'),
			array( 'description' => __( 'Displays a search form and a list of all doc categories', 'docu' ), )
		);	

	}

	public function widget( $args, $instance ) {

		do_action( 'docu_before_sidebar_widget' );

		$title = apply_filters( 'docu_widget_title', $instance['title'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="docu-container-category">';
			echo '<div class="docu-nav-container">';

				// display search form

				$display_search_form = $instance['display_search_form'];

				if ( $display_search_form && $display_search_form == '1' ) {

					$template = new DOCU_Template_Loader;
					$template->get_template_part( 'docu-search-form' );

				}

				// list documents

				$list_documents = $instance['list_documents'];

				if ( $list_documents ) {

					// display a list of all doc categories
					// for each category, display a list of all documents in the category

					echo '<ul class="docu-nav-list">';

					$taxonomies = array( 'doc_category' );

					$tax_args = array(
					    'orderby' => 'term_group', 
					    'order' => 'ASC'
					); 

					$terms = get_terms($taxonomies, $tax_args);
						
					foreach ($terms as $term) { ?>

						<li>
							<a class="docu-item-link" href="<?php echo get_term_link( $term );?>"><?php echo $term->name;?></a>

							<?php
							$term_id = $term->term_id;

							$term_args = array(
								'post_type' => 'doc',
								'post_status' => 'publish',
								'tax_query' => array(
									array(
										'taxonomy' => 'doc_category',
										'field'    => 'id',
										'terms'    => array( $term_id )
									)
								),
									'orderby' => 'menu_order', 
									'order' => 'ASC'
							);

							$the_query = new WP_Query( $term_args );

							if ( $the_query->have_posts() ) { ?>

								<ul>

							   	<?php while ( $the_query->have_posts() ) {
							        $the_query->the_post(); ?>
							        
							        <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
							               
								<?php } ?>

								</ul>

							<?php } 

							wp_reset_postdata();
							?>

						</li>

					<?php }

					echo '</ul>'; 					


				} else {

					// display a list of all doc categories

					echo '<ul class="docu-nav-list">';

					$cat_args = array(
						'show_option_all'    => '',
						'orderby'            => 'term_group',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 0,
						'hide_empty'         => 1,
						'use_desc_for_title' => 1,
						'child_of'           => 0,
						'feed'               => '',
						'feed_type'          => '',
						'feed_image'         => '',
						'exclude'            => '',
						'exclude_tree'       => '',
						'include'            => '',
						'hierarchical'       => 1,
						'title_li'           => '',
						'show_option_none'   => '',
						'number'             => null,
						'echo'               => 1,
						'depth'              => 0,
						'current_category'   => 0,
						'pad_counts'         => 0,
						'taxonomy'           => 'doc_category',
						'walker'             => null
					);

					echo wp_list_categories( apply_filters( 'docu_list_categories_args', $cat_args, 10, 1 ) );

					echo '</ul>';

				}
		

			echo '</div>';
		echo '</div>';

		echo $args['after_widget'];

		do_action( 'docu_after_sidebar_widget' );

	}

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {

			$title = $instance[ 'title' ];

		} else {

			$title = __( 'Docu Sidebar Widget', 'docu' );

		} ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'docu' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php

		// display search form | default 1 (checked)

		if( isset( $instance[ 'display_search_form' ] ) ) {

		     $checkbox_display_search_form = esc_attr($instance['display_search_form']);

		} else {

		     $checkbox_display_search_form = '1';

		}

		?>

		<p>
			<input id="<?php echo $this->get_field_id('display_search_form'); ?>" name="<?php echo $this->get_field_name('display_search_form'); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_display_search_form ); ?> />
			<label for="<?php echo $this->get_field_id('display_search_form'); ?>"><?php _e('Display search form', 'docu'); ?></label>
		</p>

		<?php

		// list documents | default 0 (unchecked)

		if( isset( $instance[ 'list_documents' ] ) ) {

		     $checkbox_list_documents = esc_attr($instance['list_documents']);

		} else {

		     $checkbox_list_documents = '';

		}

		?>

		<p>
			<input id="<?php echo $this->get_field_id('list_documents'); ?>" name="<?php echo $this->get_field_name('list_documents'); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox_list_documents ); ?> />
			<label for="<?php echo $this->get_field_id('list_documents'); ?>"><?php _e('List documents in category', 'docu'); ?></label>
		</p>

	<?php }

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		
		$instance['display_search_form'] = strip_tags($new_instance['display_search_form']);
		$instance['list_documents'] = strip_tags($new_instance['list_documents']);

		return $instance;

	}		

}

function docu_register_widgets() {

	register_widget( 'Docu_Widget' );

}

add_action( 'widgets_init', 'docu_register_widgets' );