<?php
/*
Plugin Name: VR jScrollPane Shortcode
Plugin URL: http://blog.pixelthemes.com/
Description: Adds scrollable content section using jScrollPane
Version: 1.0.1
Author: Rajesh Kannan MJ
Author URI: http://blog.pixelthemes.com/
*/

function vr_jscrollpane_shortcode( $atts,$content = null ) {

	$atts = shortcode_atts(
		array(
			'width' 	=> '100%',
			'height' 	=> '200px'
		),
		$atts
	);
	$content = "<div class='scroll-pane'>".wpautop($content)."</div>";
	$content .="<style>.scroll-pane{width: ".esc_attr( $atts['width'] ).";height:".esc_attr( $atts['height'] ).";overflow: auto;}</style>";
	
	return $content;
}
//main shortcode
add_shortcode( 'vr_jsp', 'vr_jscrollpane_shortcode' );

add_action('wp_enqueue_scripts', 'vr_shortcodes_css_and_js');
function vr_shortcodes_css_and_js(){
	wp_enqueue_style( 'vr-shortcodes-css',  plugins_url('jquery.jscrollpane.css', __FILE__ ), false, '20130311', 'all' );
	wp_register_script( 'vr-shortcodes-js-scroll', plugins_url("jquery.jscrollpane.min.js", __FILE__ ), array('jquery'),'20130311', false );
	wp_register_script( 'vr-shortcodes-js-mwheel', plugins_url("jquery.mousewheel.js", __FILE__ ), array('jquery'),'20130311', false );
	wp_enqueue_script( 'vr-shortcodes-js-scroll' );  
	wp_enqueue_script( 'vr-shortcodes-js-mwheel' );  
}

function vr_init_scroll(){ ?>
	<script type="text/javascript">
	//<![CDATA[
		jQuery(document).ready(function() {
			jQuery('.scroll-pane').jScrollPane();
		});
	/* ]]> */
	</script>

<?php }
add_action('wp_head', 'vr_init_scroll');