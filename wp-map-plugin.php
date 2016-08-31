<?php
/*
Plugin Name: Brotsky Store Locator
Plugin URI: http://www.brotskydesigns.com
Version: 0.1
Author: Brotsky, LLC
Author URI: http://www.brotskydesigns.com
*/

$GLOBALS['brotsky_store_locator'] = get_option('brotsky_store_locator');
$GLOBALS['brotsky_store_locator']['plugin_code'] = 'brotsky_store_locator';
$GLOBALS['brotsky_store_locator']['item_name'] = 'Brotsky Map Locator';
$GLOBALS['brotsky_store_locator']['page_slug'] = 'brotsky_store_locator';


$GLOBALS['brotsky_store_locator_settings']['distance'] = array('1', '5', '25', '50', '100', '600');

define("Redux_TEXT_DOMAIN", "brotsky_store_locator");

require_once dirname( __FILE__ ).'/redux-framework/redux-framework.php';
require_once dirname( __FILE__ ).'/brotsky-location-admin-settings.php';
require_once dirname( __FILE__ ).'/shortcodes.php';

class Brotsky_store_location_admin {
	
	function Brotsky_store_location_admin() {
		add_action( 'admin_menu', array(__CLASS__, 'config_page_init') );
		if(is_admin()) {
    		$key = $GLOBALS['brotsky_store_locator']['google_maps_api'];
    		
    		wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-autocomplete');	
    		
			wp_enqueue_script('gmap_api', "//maps.googleapis.com/maps/api/js?key=$key", array('jquery'));
			wp_enqueue_script( 'brotsky_store_locator_admin', plugin_dir_url( __FILE__ ).'/js/admin.js');	
			
			wp_enqueue_style( 'brotsky_store_locator_admin', plugin_dir_url( __FILE__ ).'/css/admin.css' );		
			
		}
	}
}


new Brotsky_store_location_admin();

add_action( 'init', 'create_brotsky_map_location_post_type' );
function create_brotsky_map_location_post_type() {
        
    if($GLOBALS['brotsky_store_locator']['permalink_slug']=='') $GLOBALS['brotsky_store_locator']['permalink_slug'] = 'location';
    
  register_post_type( 'brotsky_map_location',
    array(
      'labels' => array(
        'name' => __( 'Map Locations BETA' ),
        'singular_name' => __( 'Map Location' )
      ),
      'public' => true,
      'has_archive' => false,
      'supports' => array( 'title', 'editor', 'comments', 'excerpt', 'custom-fields', 'thumbnail' ),
      'rewrite' => array( 'slug' => $GLOBALS['brotsky_store_locator']['permalink_slug'] ),
    )
  );
}


add_action( 'init', 'create_brotsky_map_location_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_brotsky_map_location_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Categories', 'textdomain' ),
		'all_items'         => __( 'All Categories', 'textdomain' ),
		'parent_item'       => __( 'Parent Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Category', 'textdomain' ),
		'update_item'       => __( 'Update Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Category', 'textdomain' ),
		'new_item_name'     => __( 'New Category Name', 'textdomain' ),
		'menu_name'         => __( 'Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'category' ),
	);

	register_taxonomy( 'category', array( 'brotsky_map_location' ), $args );
}


function prop_user_to_add_Google_Maps_API_key_notice() {
    
    $key = $GLOBALS['brotsky_store_locator']['google_maps_api'];
    
    $url = get_admin_url() . "admin.php?page=brotsky_store_locator&tab=2";
    
    
    if($key == false || $key == "") {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( "Please add a Google Maps API Key to the <a href='$url'>Brotsky Map Locator Settings Page</a>", 'brotsky_store_locator' ); ?></p>
    </div>
    <?php
    }
}
add_action( 'admin_notices', 'prop_user_to_add_Google_Maps_API_key_notice' );

function brotsky_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "brotsky_location_nonce");
    
    
    $lat = get_post_meta($object->ID, "brotsky-location-lat", true);
    $lng = get_post_meta($object->ID, "brotsky-location-lng", true);
    
    ?>
    <div>
        <form id="brotsky-locator-search">
            <label for="brotsky-store-locator-address">
                <h4>Search Address <small>(Full address, including the zip code and country)</small></h4>
                <input form="brotsky-locator-search" id="brotsky-locator-search-input" name="brotsky-store-locator-address" type="text" value="<?php echo get_post_meta($object->ID, "brotsky-location-address", true); ?>">
                <button class="wp-core-ui button-primary" id="brotsky-locator-search-button" form="brotsky-locator-search" type="submit">Search Geocode</button>
            </label>
        </form>
        
        <hr>
            <table id="brotsky-store-locator-address-info">
                <tr>
                    <td colspan="2" id="address_display"></td>
                </tr>
                <tr>
                    <th>Coordinates</th>
                    <td><input type="text" id="brotsky-location-lat" name="brotsky-location-lat" value="<?php echo get_post_meta($object->ID, "brotsky-location-lat", true); ?>"><input type="text" id="brotsky-location-lng" name="brotsky-location-lng" value="<?php echo get_post_meta($object->ID, "brotsky-location-lng", true); ?>"></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input type="text" id="brotsky-location-address" name="brotsky-location-address" value="<?php echo get_post_meta($object->ID, "brotsky-location-address", true); ?>"></td>
                </tr>
                <tr>
                    <th></th>
                    <td id="google-maps-image"><?php if($lat && $lng) { ?><img src="//maps.google.com/maps/api/staticmap?center=<?php echo $lat; ?>,<?php echo $lng; ?>&zoom=15&size=300x200&markers=color:red|<?php echo $lat; ?>,<?php echo $lng; ?>&sensor=false"><?php } ?></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td><input type="text" id="brotsky-location-phone" name="brotsky-location-phone" value="<?php echo get_post_meta($object->ID, "brotsky-location-phone", true); ?>"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="text" id="brotsky-location-email" name="brotsky-location-email" value="<?php echo get_post_meta($object->ID, "brotsky-location-email", true); ?>"></td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td><input type="text" id="brotsky-location-website" name="brotsky-location-website" value="<?php echo get_post_meta($object->ID, "brotsky-location-website", true); ?>"></td>
                </tr>
            </table>
        
    </div>
    
    <script type="text/javascript">
    
    $ = jQuery;
    
    $('#brotsky-locator-search-input').keydown(function(event){    
    	var keycode = (event.keyCode ? event.keyCode : event.which);
    	if(keycode == '13')    		
    		$("#brotsky-locator-search-button").trigger("click");    		
    });
    
    $('#brotsky-locator-search-button').live('click', function(event) {
    	event.preventDefault();
    	var address = $('#brotsky-locator-search-input').val();
    		
    	var geocoder = new google.maps.Geocoder();
    	geocoder.geocode({address: address}, function(results, status) {
    		if (status == google.maps.GeocoderStatus.OK) {
    			var lat = results[0].geometry.location.lat();
    			var lng = results[0].geometry.location.lng();
    			$('#brotsky-location-lat').val(lat);
    			$('#brotsky-location-lng').val(lng);
    			$('#brotsky-location-address').val(address);
    			$('#address_display').html(address);
    			var img = '<img src="//maps.google.com/maps/api/staticmap?center='+lat+','+lng+'&zoom=15&size=300x200&markers=color:red|'+lat+','+lng+'&sensor=false">';
    			$('#google-maps-image').html(img);
    		}
    	});
    });
    
    
    </script>
    
    
    <?php  
}

function add_custom_meta_box()
{
    add_meta_box("brotsky-location-meta-box", "Location", "brotsky_meta_box_markup", "brotsky_map_location", "normal", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");



/* Save the meta box's post metadata. */
function brotsky_location_save_post_class_meta( $post_id, $post ) {
  if ( !isset( $_POST['brotsky_location_nonce'] ) || !wp_verify_nonce( $_POST['brotsky_location_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  $post_type = get_post_type_object( $post->post_type );

  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

    $fields = array("brotsky-location-address","brotsky-location-lat","brotsky-location-lng","brotsky-location-phone","brotsky-location-email","brotsky-location-website");

    foreach($fields as $field) {
        $new_meta_value = ( isset( $_POST[$field] ) ?  $_POST[$field]  : '' );
        $meta_key = $field;
        $meta_value = get_post_meta( $post_id, $meta_key, true );
        if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );
        elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
    }
}

add_action( 'save_post', 'brotsky_location_save_post_class_meta', 10, 2 );

function addContent($content) {
    
    if(get_post_type() == "brotsky_map_location") {        
        $key = $GLOBALS['brotsky_store_locator']['google_maps_api'];
                
        wp_enqueue_script( 'brotsky-single-location-map', plugin_dir_url( __FILE__ ).'/js/brotsky-single-location-map.js', array('jquery'));        
        wp_enqueue_script('gmap_api', "//maps.googleapis.com/maps/api/js?key=$key", array('jquery'));
        wp_enqueue_style( 'brotsky-single-location-map', plugin_dir_url( __FILE__ ).'/css/brotsky-location-map.css' );	
        
        $id = get_the_ID();
        
        $lat = get_post_meta($id,"brotsky-location-lat",true);
        $lng = get_post_meta($id,"brotsky-location-lng",true);
        
	    $content .= "<div id='brotsky-map' class='brotsky-map' data-lat='$lat' data-lng='$lng'></div>";
    }
    
    return $content;
}

add_action('the_content', 'addContent');

?>