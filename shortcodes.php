<?php

function brotsky_location_map() {
    
    $key = $GLOBALS['brotsky_store_locator']['google_maps_api'];
                
    wp_enqueue_script( 'brotsky-location-map', plugin_dir_url( __FILE__ ).'/js/brotsky-location-map.js', array('jquery'));        
    wp_enqueue_script('gmap_api', "//maps.googleapis.com/maps/api/js?key=$key", array('jquery'));
    wp_enqueue_style( 'brotsky-location-map', plugin_dir_url( __FILE__ ).'/css/brotsky-location-map.css' );	
        
	ob_start();
	?>
	<div id="brotsky-location-map" class="brotsky-map shortcode"></div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'brotsky_location_map', 'brotsky_location_map' );
