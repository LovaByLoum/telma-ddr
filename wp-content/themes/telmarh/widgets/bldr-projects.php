<?php



class telmarh_projects extends WP_Widget {



// constructor

    function telmarh_projects() {

		$widget_ops = array('classname' => 'telmarh_projects_widget', 'description' => __( 'With this widget you can display all those projects you are proud of.', 'telmarh') );

        parent::__construct(false, $name = __('Home Page Projects', 'telmarh'), $widget_ops);

		$this->alt_option_name = 'telmarh_projects_widget';

		

		add_action( 'save_post', array($this, 'flush_widget_cache') );

		add_action( 'deleted_post', array($this, 'flush_widget_cache') );

		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		

    }

	

	// widget form creation

	function form($instance) {



	// Check values

		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;

		$see_all   		= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';

		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';	

	?>



	<p><?php _e('In order to display this widget, you must first add some Projects custom post types.', 'telmarh'); ?></p>

	<p>

	<label for="<?php echo sanitize_text_field( $this->get_field_id('title')); ?>"><?php _e('Title', 'telmarh'); ?></label>

	<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id('title')); ?>" name="<?php echo sanitize_text_field( $this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title );  ?>" /> 

	</p>

	<p><label for="<?php echo sanitize_text_field( $this->get_field_id( 'number' )); ?>"><?php _e( 'Number of projects to show (-1 shows all):', 'telmarh' ); ?></label>

	<input id="<?php echo sanitize_text_field( $this->get_field_id( 'number' )); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'number' )); ?>" type="text" value="<?php echo intval( $number ); ?>" size="3" /></p>

    <p><label for="<?php echo sanitize_text_field( $this->get_field_id('see_all')); ?>"><?php _e('<em>Optional:</em> Enter the URL for your Projects page.', 'telmarh'); ?></label>

	<input class="widefat custom_media_url" id="<?php echo sanitize_text_field( $this->get_field_id( 'see_all' )); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'see_all' )); ?>" type="text" value="<?php echo esc_url_raw( $see_all ); ?>" size="3" /></p> 	

    <p><label for="<?php echo sanitize_text_field( $this->get_field_id('see_all_text')); ?>"><?php _e('Enter the Button Text. Default is set to <em>See All</em>.', 'telmarh'); ?></label>

	<input class="widefat" id="<?php echo sanitize_text_field( $this->get_field_id( 'see_all_text' )); ?>" name="<?php echo sanitize_text_field( $this->get_field_name( 'see_all_text' )); ?>" type="text" value="<?php echo esc_html( $see_all_text ); ?>" size="3" /></p>

	

	<?php

	}



	// update widget

	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] 			= esc_html( $new_instance['title'] ); 

		$instance['number'] 		= intval( $new_instance['number'] ); 

		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	

		$instance['see_all_text'] 	= esc_html( $new_instance['see_all_text'] );			

		$this->flush_widget_cache();



		$alloptions = wp_cache_get( 'alloptions', 'options' );

		if ( isset($alloptions['telmarh_projects']) )

			delete_option('telmarh_projects');

		  

		return $instance;

	}

	

	function flush_widget_cache() {

		wp_cache_delete('telmarh_projects', 'widget');

	}

	

	// display widget

	function widget($args, $instance) {

		$cache = array();

		if ( ! $this->is_preview() ) {

			$cache = wp_cache_get( 'telmarh_projects', 'widget' );

		}



		if ( ! is_array( $cache ) ) {

			$cache = array();

		}



		if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}



		if ( isset( $cache[ $args['widget_id'] ] ) ) {

			echo $cache[ $args['widget_id'] ];

			return;

		}



		ob_start();

		extract($args);



		$title = ( ! empty( $instance['title'] ) ) ? esc_html( $instance['title'] ) : __( 'Projects', 'telmarh' );



		/** This filter is documented in wp-includes/default-widgets.php */ 

		$title 			= apply_filters( 'widget_title', esc_html( $title ), $instance, $this->id_base );

		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';

		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';

		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1; 

		if ( ! $number ) {

			$number = -1;

		}



		$mt = new WP_Query( apply_filters( 'widget_posts_args', array(

			'no_found_rows'       => true,

			'post_status'         => 'publish',

			'post_type' 		  => 'projects',

			'posts_per_page'	  => -1, 

			'posts_per_page'	  => $number

		) ) );



		if ($mt->have_posts()) :

?>

		<section id="home-projects" class="projects">

			<div class="grid grid-pad">
        		<div class="col-1-1">
				<?php if ( $title ) echo $before_title . esc_html( $title ) . $after_title; ?>
                </div>
        	</div>
            
            <div class="grid grid-pad overflow">		

				<?php $c = 1; ?>				

				<?php while ( $mt->have_posts() ) : $mt->the_post(); ?>
                
                <div class="col-1-3 tri-clear"> 
                	<div class="grid-block fade">
                    	<div class="caption" style="display: none;">
                        	<a href="<?php the_permalink(); ?>"><i class="fa fa-plus"></i></a>
                        </div>
                		<?php the_post_thumbnail( 'large', array( 'class' => 'project-img' ) ); ?>
                    </div>
            	</div> 

				<?php endwhile; ?>

			</div>

			<?php if ( $see_all ) : ?>

				<a href="<?php echo esc_url( $see_all ); ?>" class="telmarh-home-widget">

					<?php if ( $see_all_text ) : ?>

						<button><?php echo esc_html( $see_all_text ); ?></button> 

					<?php else : ?>

						<button><?php echo __('See All', 'telmarh'); ?></button>

					<?php endif; ?>

				</a>

			<?php endif; ?> 		
			

		</section>		

	<?php

		// Reset the global $the_post as this query will have stomped on it

		wp_reset_postdata();



		endif;



		if ( ! $this->is_preview() ) {

			$cache[ $args['widget_id'] ] = ob_get_flush();

			wp_cache_set( 'telmarh_projects', $cache, 'widget' );

		} else {

			ob_end_flush();

		}

	}

	

}