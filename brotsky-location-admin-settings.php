<?php

    if ( ! class_exists( 'Redux' ) ) { return; }
    
    $opt_name = 'brotsky_store_locator';
    
    $args = array(
    	
        'opt_name'             => $opt_name,
        'display_name'         => $GLOBALS[$opt_name]['item_name'],
        'menu_title'           => __( $GLOBALS[$opt_name]['item_name'], 'redux-framework-demo' ),
        'page_title'           => __( $GLOBALS[$opt_name]['item_name'], 'redux-framework-demo' ),
		'page_slug'            => $GLOBALS[$opt_name]['page_slug'],
        
        // Name that appears at the top of your panel
        'display_version'      => 'by Brotsky, LLC',
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
	
    // Add content after the form.
    $args['footer_text'] = __( '<p>For support, questions or customization requests please contact us using the form on our <a href="http://codecanyon.net/user/brotsky?ref=brotsky" target="_blank">profile page here</a> or through our <a href="http://www.brotskydesigns.com" target="_blank">website</a></p>', 'redux-framework-demo' );
	
    Redux::setArgs( $opt_name, $args );
	
	$map_types_tab = array('roadmap'=>'Roadmap', 'satellite'=>'Satellite', 'hybrid'=>'Hybrid', 'terrain'=>'Terrain');
	$distance_tab = array('km'=>'Kilometers', 'miles'=>'Miles');
	$closest_stores_tab = array('1'=>'Yes', '2'=>'No');
	$yes_no_tab = array('1'=>'Yes', '2'=>'No');
    
	//START SECTIONS
	
	Redux::setSection( $opt_name, array(
        'title'  => __( 'Brotsky Map Settings', 'redux-framework-demo' ),
        'id'     => 'brotsky-settings',
        'desc'   => __( '<p class="description">Main store locator settings</p>', 'redux-framework-demo' ),
        'fields' => array(
            array(
                'id' => 'nb_display_search',
                'type' => 'text',
                'title' => __('Number of search results', Redux_TEXT_DOMAIN),
                'desc' => __('Number of stores to display when a search is made (per page or per Map) - 10 by default', Redux_TEXT_DOMAIN),
                'default' => '10'
            ),
            array(
                'id' => 'nb_display_default',
                'type' => 'text',
                'title' => __('Number of results by default', Redux_TEXT_DOMAIN),
                'desc' => __('Number of stores to display when the locator loads the first time - 50 by default', Redux_TEXT_DOMAIN),
                'default' => '50'
            ),
            array(
                'id' => 'closest_stores',
                'type' => 'radio',
                'title' => __('Closest stores', Redux_TEXT_DOMAIN), 
                'desc' => __('Detect the user\'s location and load the closest stores<br>If set to "Yes", make sure a value for the "number of results per default" is defined', Redux_TEXT_DOMAIN),
                'options' => $closest_stores_tab, // Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id' => 'distance_unit',
                'type' => 'radio',
                'title' => __('Distance unit', Redux_TEXT_DOMAIN), 
                'desc' => __('Used for the search results', Redux_TEXT_DOMAIN),
                'options' => $distance_tab,
                'default' => 'km'
            ),
            array(
                'id' => 'custom_marker',
                'type' => 'media',
                'title' => __('Custom marker', Redux_TEXT_DOMAIN),
                'desc' => __('The custom default marker for each location.', Redux_TEXT_DOMAIN),
                'default' => ''
            ),
            array(
                'id' => 'locator_url',
                'type' => 'text',
                'title' => __('Locator URL', Redux_TEXT_DOMAIN),
                'desc' => __('Full URL of the page where the shortcode is used. Need to start with http://', Redux_TEXT_DOMAIN),
                'default' => ''
            ),
            array(
                'id' => 'direction_links',
                'type' => 'radio',
                'title' => __('Direction links', Redux_TEXT_DOMAIN), 
                'desc' => __('Display direction links in the marker infowindow', Redux_TEXT_DOMAIN),
                'options' => $yes_no_tab,
                'default' => '1'
            ),
            array(
                'id' => 'streetview',
                'type' => 'radio',
                'title' => __('Streetview', Redux_TEXT_DOMAIN), 
                'desc' => __('Display streetview link in the marker infowindow', Redux_TEXT_DOMAIN),
                'options' => $yes_no_tab,
                'default' => '1'
            ),
            array(
                'id' => 'permalink_slug',
                'type' => 'text',
                'title' => __('Permalink Slug', Redux_TEXT_DOMAIN), 
                'desc' => __('<p>ie: ' . site_url() . '/PERMALINK_SLUG/example-location-name/</p><p>If changed, make sure to re-save your permalinks to refresh the rewrite rules. Please click the Save Changes button <a href="' . get_admin_url() . 'options-permalink.php">here</a>.</p>', Redux_TEXT_DOMAIN),
                'default' => 'location'
            )
		)
	));
	
	Redux::setSection( $opt_name, array(
        'title'  => __( 'General Map settings', 'redux-framework-demo' ),
        'desc'   => __( '<p class="description">Main Map settings</p>', 'redux-framework-demo' ),
        'fields' => array(
            array(
                'id' => 'google_maps_api',
                'type' => 'text',
                'title' => __('Google Maps API Key', Redux_TEXT_DOMAIN),
                'desc' => __('Get an API Key <a href="https://developers.google.com/maps/documentation/javascript/" target="_blank">Here</a> (Click on GET A KEY)', Redux_TEXT_DOMAIN),
                'default' => ''
            ),
            array(
                'id' => 'map_width',
                'type' => 'text',
                'title' => __('Map width', Redux_TEXT_DOMAIN),
                'desc' => __('100% or any value in pixels - Ex: 480px', Redux_TEXT_DOMAIN),
                'default' => '100%'
            ),
            array(
                'id' => 'map_height',
                'type' => 'text',
                'title' => __('Map height', Redux_TEXT_DOMAIN),
                'desc' => __('Any value in pixels - Ex: 380px', Redux_TEXT_DOMAIN),
                'default' => '380px'
            ),
            array(
                'id' => 'map_type',
                'type' => 'radio',
                'title' => __('Map type', Redux_TEXT_DOMAIN), 
                'desc' => __('', Redux_TEXT_DOMAIN),
                'options' => $map_types_tab, // Must provide key => value pairs for radio options
                'default' => 'roadmap'
            ),
            array(
                'id' => 'map_lat',
                'type' => 'text',
                'title' => __('Default map latitude', Redux_TEXT_DOMAIN),
                'desc' => __('Used to display a default location when no results are loaded by default', Redux_TEXT_DOMAIN),
                'default' => ''
            ),
            array(
                'id' => 'map_lng',
                'type' => 'text',
                'title' => __('Default map longitude', Redux_TEXT_DOMAIN),
                'desc' => __('Used to display a default location when no results are loaded by default', Redux_TEXT_DOMAIN),
                'default' => ''
            ),
            array(
                'id' => 'map_zoom',
                'type' => 'text',
                'title' => __('Default map zoom', Redux_TEXT_DOMAIN),
                'desc' => __('Possible values: from 0 to 20 - Used when the default location is displayed', Redux_TEXT_DOMAIN),
                'default' => '13'
            )
		)
	));
	
	Redux::setSection( $opt_name, array(
        'title'  => __( 'Store details settings', 'redux-framework-demo' ),
        'desc'   => __( '<p class="description">Settings related to the Map displayed in the store detail individual pages</p>', 'redux-framework-demo' ),
        'fields' => array(
            array(
                'id' => 'map_width_detail',
                'type' => 'text',
                'title' => __('Map width', Redux_TEXT_DOMAIN),
                'desc' => __('100% or any value in pixels - Ex: 480px', Redux_TEXT_DOMAIN),
                'default' => '100%'
            ),
            array(
                'id' => 'map_height_detail',
                'type' => 'text',
                'title' => __('Map height', Redux_TEXT_DOMAIN),
                'desc' => __('Any value in pixels - Ex: 380px', Redux_TEXT_DOMAIN),
                'default' => '380px'
            ),
            array(
                'id' => 'map_type_detail',
                'type' => 'radio',
                'title' => __('Map type', Redux_TEXT_DOMAIN), 
                'desc' => __('', Redux_TEXT_DOMAIN),
                'options' => $map_types_tab, // Must provide key => value pairs for radio options
                'default' => 'roadmap'
            ),
            array(
                'id' => 'map_zoom_detail',
                'type' => 'text',
                'title' => __('Default map zoom', Redux_TEXT_DOMAIN),
                'desc' => __('Possible values: from 0 to 20', Redux_TEXT_DOMAIN),
                'default' => '15'
            )
		)
	));
	
	Redux::setSection( $opt_name, array(
        'title'  => __( 'Templating', 'redux-framework-demo' ),
        'desc'   => __( '<p class="description">Settings related to the Map displayed in the store detail individual pages</p>', 'redux-framework-demo' ),
        'fields' => array(
            array(
                'id' => 'ace_editor',
                'type' => "ace_editor",
                'title' => __("Code Editor", 'redux-framework-demo'),
                'compiler' => 'true',
                'subtitle' => __('Dummy Subtitle', 'redux-framework-demo'),
                "mode" => "html",
                "theme" => "monokai"
            ),
		)
	));
	
	//END SECTIONS
	
?>