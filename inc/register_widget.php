<?php
/*
*	Register Tabool Widget.
*/

/*******************************************
		Taboola 1 Widget: Register
********************************************/
function reg_cus_taboola_widget() {
	register_widget( 'cus_taboola_widget' );
}
add_action( 'widgets_init', 'reg_cus_taboola_widget' );	

/********************************************
	Taboola 1 Widget: Body
*********************************************/
class cus_taboola_widget extends WP_Widget 
{
	function __construct() {
		parent::__construct(
			'cus_taboola_widget', // Base ID
			__('[AUR] Taboola Widget' ), // Name
			array( 'description' => __( 'Display Taboola ADs on your sidebars/widgets' ), ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$widget_title = $instance['widget_title'];
		$custom_class = $instance['custom_class']; 
		
		wp_enqueue_script( 'aur_taboola_js', plugins_url("taboola") . '/supportive/taboola.js', false , '');
		wp_enqueue_style( 'aur_taboola_css', plugins_url("taboola") . '/supportive/taboola-widget.css', false );
	?>
		<ul class="widget taboola-widget <?php echo $custom_class; ?>">
			<li>
				<h2 class="section-title capitalize"><?php esc_html_e($widget_title)?><i></i></h2>
				<div id="taboola-below-article-thumbnails"></div>
				<script type="text/javascript">
					window._taboola = window._taboola || [];
					_taboola.push({
						mode: 'thumbnails-a',
						container: 'taboola-below-article-thumbnails',
						placement: 'Below Article Thumbnails',
						target_type: 'mix'
					});
				</script>
			</li>
		<ul>
<?php }
	
	
	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'widget_title' ]) ) {
			$widget_title = $instance['widget_title'];
		} else {
			$widget_title = __( '[AUR] Taboola Widget' );
		}
		
		if ( isset( $instance[ 'custom_class' ]) ) {
			$custom_class = $instance['custom_class'];
		} else {
			$custom_class = __( '' );
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Widget Title:' ); ?></label> 
			<input 	id="<?php echo $this->get_field_id( 'widget_title' ); ?>" 
					class="widefat"  type="text" 
					name="<?php echo $this->get_field_name( 'widget_title' ); ?>" 
					value="<?php echo esc_html($widget_title); ?>" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'custom_class' ); ?>"><?php _e( 'Custom Class:' ); ?></label> 
			<input 	id="<?php echo $this->get_field_id( 'custom_class' ); ?>" 
					class="widefat"  type="text" 
					name="<?php echo $this->get_field_name( 'custom_class' ); ?>" 
					value="<?php echo esc_html($custom_class); ?>" />
		</p>
<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 * @see WP_Widget::update()
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) 
	{
		$instance = array();
		$instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ? ( $new_instance['widget_title'] ) : '';
		$instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? ( $new_instance['custom_class'] ) : '';
		return $instance;
	}
} // END OF WIDGET CLASS