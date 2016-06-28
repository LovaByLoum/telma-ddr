<?php
/**
 * telmarh Theme Customizer
 *
 * @package telmarh
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function telmarh_customize_register( $wp_customize ) {
	
	// Move sections up 
	$wp_customize->get_section('static_front_page')->priority = 10; 
	
	//allows donations
    class telmarh_Info extends WP_Customize_Control {
     
        public $label = '';
        public function render_content() {
        ?>

        <?php
        }
    }	
	
	// Pro
    $wp_customize->add_section(
        'telmarh_theme_info',
        array(
            'title' => __('telmarh Pro', 'telmarh'),
            'priority' => 5, 
            'description' => __('Need a little more telmarh? If you want to see what additional features <a href="http://modernthemes.net/wordpress-themes/telmarh-pro/" target="_blank">telmarh Pro</a> has, check them all out right <a href="http://modernthemes.net/wordpress-themes/telmarh-pro/" target="_blank">here</a>. telmarh Pro is only $18!', 'telmarh'),
    ));  
	 
    //Donations section
    $wp_customize->add_setting('telmarh_help', array(
			'sanitize_callback' => 'telmarh_no_sanitize',
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
    ));
	
    $wp_customize->add_control( new telmarh_Info( $wp_customize, 'telmarh_help', array(
        'section' => 'telmarh_theme_info',
        'settings' => 'telmarh_help',
        'priority' => 10
    )));
	
	// nav 
	$wp_customize->add_section( 'telmarh_nav', array(
	'title' => __( 'Navigation', 'telmarh' ),
	'priority' => '13', 
	));

	// Nav
	$wp_customize->add_setting( 'telmarh_menu_name', array(
        'default'     => 'Menu',
        'sanitize_callback' => 'telmarh_sanitize_text',
    ));
 
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_menu_name', array(
        'label'	   => __( 'Mobile Menu Name', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_menu_name',
		'priority' => 25
    )));
	
	$wp_customize->add_setting( 'telmarh_nav_link_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_link_color', array(
        'label'	   => __( 'Navigation Link Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_link_color',
		'priority' => 70 
    )));

	$wp_customize->add_setting( 'telmarh_nav_link_hover_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_link_hover_color', array(
        'label'	   => __( 'Navigation Link Hover Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_link_hover_color',
		'priority' => 75
    )));
	
	$wp_customize->add_setting( 'telmarh_nav_drop_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_drop_color', array(
        'label'	   => __( 'Menu Drop Down Background Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_drop_color',
		'priority' => 95  
    )));
	
	$wp_customize->add_setting( 'telmarh_nav_accent_color', array(
        'default'     => '#039be5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_accent_color', array(
        'label'	   => __( 'Menu Drop Down Accent Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_accent_color',
		'priority' => 100
    )));
	
	$wp_customize->add_setting( 'telmarh_nav_drop_link_color', array(
        'default'     => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_drop_link_color', array(
        'label'	   => __( 'Menu Drop Down Link Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_drop_link_color',
		'priority' => 105
    )));
	
	
	$wp_customize->add_setting( 'telmarh_nav_drop_link_bg_color', array(
        'default'     => '#f5f5f5', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_drop_link_bg_color', array(
        'label'	   => __( 'Menu Drop Down Link Background Color', 'telmarh' ),
       	'section'  => 'telmarh_nav',
        'settings' => 'telmarh_nav_drop_link_bg_color',
		'priority' => 115
    )));
	
	$wp_customize->add_setting( 'telmarh_page_nav_bg_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_nav_bg_color', array(
        'label'	   => __( 'Page Navigation Background Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_page_nav_bg_color',
		'priority' => 120
    )));
	
	$wp_customize->add_setting( 'telmarh_page_link_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_link_color', array(
        'label'	   => __( 'Page Navigation Link Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_page_link_color',
		'priority' => 125
    )));
	
	$wp_customize->add_setting( 'telmarh_page_link_hover_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_link_hover_color', array(
        'label'	   => __( 'Page Navigation Link Hover Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_page_link_hover_color',
		'priority' => 130  
    )));

	$wp_customize->add_setting( 'telmarh_mobile_menu', array(
        'default'     => '#039be5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_mobile_menu', array(
        'label'	   => __( 'Mobile Menu Button Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_mobile_menu',
		'priority' => 140
    )));
	
	$wp_customize->add_setting( 'telmarh_mobile_menu_hover', array(
        'default'     => '#039be5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_mobile_menu_hover', array(
        'label'	   => __( 'Mobile Menu Button Hover Color', 'telmarh' ),
        'section'  => 'telmarh_nav',
        'settings' => 'telmarh_mobile_menu_hover',
		'priority' => 145
    )));
	
	// Sticky Navigation
	$wp_customize->add_section( 'telmarh_sticky_section' , array(
	    'title'       => __( 'Sticky Navigation', 'telmarh' ),
	    'priority'    => 15, 
	    'description' => __( 'Adjust your Sticky Navigation settings here.', 'telmarh'),
	)); 
	
	
	$wp_customize->add_setting(
        'telmarh_sticky_active',
        array(
            'sanitize_callback' => 'telmarh_sanitize_checkbox',
            'default' => 0,
    ));
	
    $wp_customize->add_control( 
        'telmarh_sticky_active',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box if you want to disable the Sticky Header option', 'telmarh'),
            'section' => 'telmarh_sticky_section',
            'priority' => 50,       
    ));
	
	$wp_customize->add_setting( 'telmarh_nav_bg_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_nav_bg_color', array(
        'label'	   => __( 'Sticky Navigation Background Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_nav_bg_color',
		'priority' => 80
    )));
	
	$wp_customize->add_setting( 'telmarh_stickynav_link_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_link_color', array(
        'label'	   => __( 'Sticky Navigation Link Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_link_color',
		'priority' => 85
    )));
	
	$wp_customize->add_setting( 'telmarh_stickynav_link_hover_color', array(
        'default'     => '#404040', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_link_hover_color', array(
        'label'	   => __( 'Sticky Navigation Link Hover Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_link_hover_color',
		'priority' => 90  
    )));
	
	$wp_customize->add_setting( 'telmarh_stickynav_drop_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_drop_color', array(
        'label'	   => __( 'Sticky Navigation Menu Drop Down Background Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_drop_color',
		'priority' => 95  
    )));
	
	$wp_customize->add_setting( 'telmarh_stickynav_accent_color', array(
        'default'     => '#039be5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_accent_color', array(
        'label'	   => __( 'Sticky Navigation Menu Drop Down Accent Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_accent_color',
		'priority' => 100
    )));
	
	$wp_customize->add_setting( 'telmarh_stickynav_drop_link_color', array(
        'default'     => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_drop_link_color', array(
        'label'	   => __( 'Sticky Navigation Menu Drop Down Link Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_drop_link_color',
		'priority' => 105
    )));
	
	
	$wp_customize->add_setting( 'telmarh_stickynav_drop_link_bg_color', array(
        'default'     => '#f5f5f5', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_stickynav_drop_link_bg_color', array(
        'label'	   => __( 'Sticky Navigation Menu Drop Down Link Background Color', 'telmarh' ),
        'section'  => 'telmarh_sticky_section',
        'settings' => 'telmarh_stickynav_drop_link_bg_color',
		'priority' => 115
    )));

    // Logo upload
    $wp_customize->add_section( 'telmarh_logo_section' , array(
	    'title'       => __( 'Logo and Icons', 'telmarh' ),
	    'priority'    => 20, 
	    'description' => __( 'Upload a logo to replace the default site name and description in the header. Also, upload your site favicon and Apple Icons.', 'telmarh'),
	)); 

	$wp_customize->add_setting( 'telmarh_logo', array(
		'sanitize_callback' => 'esc_url_raw',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'telmarh_logo', array(
		'label'    => __( 'Home Logo', 'telmarh' ),
		'section'  => 'telmarh_logo_section',
		'settings' => 'telmarh_logo',
		'priority' => 1,
	))); 
	
	$wp_customize->add_setting( 'telmarh_logo_page', array(
		'sanitize_callback' => 'esc_url_raw',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'telmarh_logo_page', array(
		'label'    => __( 'Page Logo', 'telmarh' ),
		'section'  => 'telmarh_logo_section',
		'settings' => 'telmarh_logo_page',
		'priority' => 1,
	)));
	
	// Logo Width
	$wp_customize->add_setting( 'logo_size', array(
	    'sanitize_callback' => 'telmarh_sanitize_text',
		'default'	        => '165'   
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'logo_size', array( 
		'label'    => __( 'Change the width of the Logo in PX.', 'telmarh' ),
		'description'    => __( 'Only enter numeric value', 'telmarh' ),
		'section'  => 'telmarh_logo_section',
		'settings' => 'logo_size', 
		'type'     => 'number', 
		'priority'   => 2,
		'input_attrs' => array(
            'style' => 'margin-bottom: 15px;',  
        ),
	)));
	
	//Favicon Upload
	$wp_customize->add_setting(
		'site_favicon',
		array(
			'default' => (get_stylesheet_directory_uri( 'stylesheet_directory') . '/img/favicon.png'), 
			'sanitize_callback' => 'esc_url_raw',
	));
	
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon (16x16 pixels)', 'telmarh' ),
			   'type' 			=> 'image',
               'section'        => 'telmarh_logo_section',
               'settings'       => 'site_favicon',
               'priority' => 2,
    )));
	
    //Apple touch icon 144
    $wp_customize->add_setting(
        'apple_touch_144',
        array(
            'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
    ));
	
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_144',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (144x144 pixels)', 'telmarh' ),
               'type'           => 'image',
               'section'        => 'telmarh_logo_section',
               'settings'       => 'apple_touch_144',
               'priority'       => 11,
    )));
	
    //Apple touch icon 114
    $wp_customize->add_setting(
        'apple_touch_114',
        array(
            'default-image' => '',
			'sanitize_callback' => 'esc_url_raw', 
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_114',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (114x114 pixels)', 'telmarh' ),
               'type'           => 'image',
               'section'        => 'telmarh_logo_section',
               'settings'       => 'apple_touch_114',
               'priority'       => 12,
    )));
	
    //Apple touch icon 72
    $wp_customize->add_setting(
        'apple_touch_72',
        array(
            'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
    ));
	
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_72',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (72x72 pixels)', 'telmarh' ),
               'type'           => 'image',
               'section'        => 'telmarh_logo_section',
               'settings'       => 'apple_touch_72',
               'priority'       => 13,
    )));
	
    //Apple touch icon 57
    $wp_customize->add_setting(
        'apple_touch_57',
        array(
            'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
    ));
	
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_57',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (57x57 pixels)', 'telmarh' ),
               'type'           => 'image',
               'section'        => 'telmarh_logo_section',
               'settings'       => 'apple_touch_57',
               'priority'       => 14,
    )));
	
	// Hero Section
	$wp_customize->add_section( 'telmarh_slider_section', array(
		'title'          => __( 'Home Hero Section', 'telmarh' ),
		'priority'       => 25, 
		'description' => __( 'Edit your Home Page Hero', 'telmarh'),
	));
	
	$wp_customize->add_setting('active_hero',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_checkbox',
	));
	
	$wp_customize->add_control( 
    'active_hero', 
    array(
        'type' => 'checkbox',
        'label' => __( 'Hide Hero', 'telmarh' ),
        'section' => 'telmarh_slider_section',
		'priority'   => 10
    ));
	
	// Main Background
	$wp_customize->add_setting( 'telmarh_main_bg', array(
		'default' => (get_stylesheet_directory_uri( 'stylesheet_directory') . '/img/telmarh.jpg'),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'telmarh_main_bg', array(
		'label'    => __( 'Hero Image', 'telmarh' ),
		'section'  => 'telmarh_slider_section',
		'settings' => 'telmarh_main_bg',
		'priority'   => 20
	) ) ); 
	
	// First Heading
	$wp_customize->add_setting( 'telmarh_first_heading' ,
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	    ) 
	);
	 
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_first_heading', array(
    'label' => __( 'Hero Heading', 'telmarh' ),
    'section' => 'telmarh_slider_section',
    'settings' => 'telmarh_first_heading',
	'priority'   => 30
	) ) );
	
	// Second Heading
	$wp_customize->add_setting( 'telmarh_second_heading' ,
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	    ) 
	);
	 
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_second_heading', array(
    'label' => __( 'Hero Second Heading', 'telmarh' ),
    'section' => 'telmarh_slider_section',
    'settings' => 'telmarh_second_heading',
	'priority'   => 40
	) ) );
	
	// Hero Button Text
	$wp_customize->add_setting( 'telmarh_hero_button_text',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	    ) 
	);
	 
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_hero_button_text', array(
    'label' => __( 'Hero Button Text', 'telmarh' ),
    'section' => 'telmarh_slider_section',
    'settings' => 'telmarh_hero_button_text',
	'priority'   => 45 
	) ) );
	
	// Page Drop Downs 
	$wp_customize->add_setting('hero_button_url', array( 
		'capability' => 'edit_theme_options', 
        'sanitize_callback' => 'telmarh_sanitize_int'
	));
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hero_button_url', array( 
    	'label' => __( 'Hero Button URL', 'telmarh' ),
    	'section' => 'telmarh_slider_section',
		'type' => 'dropdown-pages',
    	'settings' => 'hero_button_url',
		'priority'   => 50 
	)));
	
	// Page URL
	$wp_customize->add_setting( 'page_url_text',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( 'page_url_text', array( 
		'type'     => 'url',
		'label'    => __( 'External URL Option', 'telmarh' ),
		'description' => __( 'If you use an external URL, leave the Hero Button URL Link above empty. Must include http:// before any URL.', 'telmarh' ),
		'section'  => 'telmarh_slider_section',
		'settings' => 'page_url_text',
		'priority'   => 60
	));
	
	// Social Panel
	$wp_customize->add_panel( 'telmarh_footer_panel', array(
    'priority'       => 38,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Footer Options', 'telmarh' ),
    'description'    		 => __( 'Edit your footer options', 'telmarh' ),
	)); 
	
	// Add Footer Section
	$wp_customize->add_section( 'footer-custom' , array(
    	'title' => __( 'Footer', 'telmarh' ),
    	'priority' => 10,
    	'description' => __( 'Customize your footer area', 'telmarh' ),
		'panel' => 'telmarh_footer_panel'
	) );
	
	// Footer Byline Text 
	$wp_customize->add_setting( 'telmarh_footerid',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));
	 
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_footerid', array(
    'label' => __( 'Footer Byline Text', 'telmarh' ),
    'section' => 'footer-custom', 
    'settings' => 'telmarh_footerid',
	'priority'   => 10
	)));
	
	$wp_customize->add_setting( 'telmarh_footer_color', array(
        'default'     => '#161B1F',  
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_footer_color', array(
        'label'	   => __( 'Footer Background Color', 'telmarh'),
        'section'  => 'footer-custom',
        'settings' => 'telmarh_footer_color',
		'priority' => 20
    )));
	
	$wp_customize->add_setting( 'telmarh_footer_heading_color', array(
        'default'     => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_footer_heading_color', array(
        'label'	   => __( 'Footer Heading Color', 'telmarh'),
        'section'  => 'footer-custom',
        'settings' => 'telmarh_footer_heading_color',
		'priority' => 30
    )));
	
	$wp_customize->add_setting( 'telmarh_footer_text_color', array(
        'default'     => '#6c7980',  
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_footer_text_color', array(
        'label'	   => __( 'Footer Text Color', 'telmarh'),
        'section'  => 'footer-custom',
        'settings' => 'telmarh_footer_text_color',
		'priority' => 40
    )));
	
	$wp_customize->add_setting( 'telmarh_footer_link_color', array(
        'default'     => '#cccccc', 
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_footer_link_color', array(
        'label'	   => __( 'Footer Link Color', 'telmarh'),
        'section'  => 'footer-custom',
        'settings' => 'telmarh_footer_link_color',
		'priority' => 50
    )));
	
	// Social Panel
	$wp_customize->add_panel( 'social_panel', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Social Section', 'telmarh' ),
    'description'    		 => __( 'Edit your social media icons', 'telmarh' ),
	)); 
	
	// Social Section 
	$wp_customize->add_section( 'telmarh_settings', array(
    	'title'          => __( 'Social Media Icons', 'telmarh' ),
        'priority'       => 38,
		'panel' => 'social_panel',  
    ) );
	
	
	$wp_customize->add_setting(
        'telmarh_social_new_window',
        array(
            'sanitize_callback' => 'telmarh_sanitize_checkbox',
            'default' => 0,
    ));
	
    $wp_customize->add_control( 
        'telmarh_social_new_window',
        array(
            'type' => 'checkbox',
            'label' => __('Open links in new window?', 'telmarh'),
            'section'  => 'telmarh_settings',
            'priority' => 5,       
    ));
	
	
	// Footer Social Section 
	$wp_customize->add_setting('active_footer_social',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_checkbox',
	)); 
	
	$wp_customize->add_control( 
    'active_footer_social', 
    array(
        'type' => 'checkbox',
        'label' => __( 'Hide Social Section', 'telmarh' ),
        'section' => 'telmarh_settings',
		'priority'   => 5
    ));
	
	// Social Text
	$wp_customize->add_setting( 'footer_social_text',
	   array(
	       'sanitize_callback' => 'telmarh_sanitize_text',
	   )); 

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_social_text', array(
		'label'    => __( 'Social Heading', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'footer_social_text', 
		'priority'   => 20
	)));
		
	$wp_customize->add_setting( 'telmarh_social_bg_color', array(
        'default'     => '#ffffff', 
        'sanitize_callback' => 'sanitize_hex_color',  
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_social_bg_color', array(
        'label'	   => __( 'Social Background Color', 'telmarh'),
        'section'  => 'telmarh_settings',
        'settings' => 'telmarh_social_bg_color',
		'priority' => 6
    )));
	
	$wp_customize->add_setting( 'telmarh_social_border_color', array(
        'default'     => '#dadada', 
        'sanitize_callback' => 'sanitize_hex_color',  
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_social_border_color', array(
        'label'	   => __( 'Social Border Color', 'telmarh'),
        'section'  => 'telmarh_settings',
        'settings' => 'telmarh_social_border_color',
		'priority' => 6
    )));
	
	// Social Icon Colors
	$wp_customize->add_setting( 'telmarh_social_color', array(
        'default'     => '#888888', 
		'sanitize_callback' => 'sanitize_hex_color',
    ));
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_social_color', array(
        'label'	   => __( 'Social Icon Color', 'telmarh' ),
        'section'  => 'telmarh_settings',
        'settings' => 'telmarh_social_color',
		'priority' => 6
    )));
	
	$wp_customize->add_setting( 'telmarh_social_color_hover', array(
        'default'     => '#039BE5', 
		'sanitize_callback' => 'sanitize_hex_color',  
    ));
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_social_color_hover', array(
        'label'	   => __( 'Social Icon Hover Color', 'telmarh' ),
        'section'  => 'telmarh_settings',
        'settings' => 'telmarh_social_color_hover',
		'priority' => 6
    )));
	
	
	// Facebook
	$wp_customize->add_setting( 'telmarh_fb',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_fb', array(
		'label'    => __( 'Facebook URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_fb',
		'priority'   => 30
	))); 
	
	// Twitter
	$wp_customize->add_setting( 'telmarh_twitter',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_twitter', array(
		'label'    => __( 'Twitter URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_twitter',
		'priority'   => 40
	))); 
	
	// LinkedIn
	$wp_customize->add_setting( 'telmarh_linked',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_linked', array(
		'label'    => __( 'LinkedIn URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_linked',
		'priority'   => 50
	)));
	
	// Google Plus
	$wp_customize->add_setting( 'telmarh_google',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_google', array(
		'label'    => __( 'Google Plus URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_google',
		'priority'   => 60
	)));
	
	// Instagram
	$wp_customize->add_setting( 'telmarh_instagram',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_instagram', array(
		'label'    => __( 'Instagram URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_instagram',
		'priority'   => 70
	)));
	
	// Vine
	$wp_customize->add_setting( 'telmarh_vine',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_vine', array(
		'label'    => __( 'Vine URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_vine',
		'priority'   => 75 
	)));
	
	// Snapchat
	$wp_customize->add_setting( 'telmarh_snapchat',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_snapchat', array(
		'label'    => __( 'Snapchat URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_snapchat',
		'priority'   => 78
	)));
	
	// Flickr
	$wp_customize->add_setting( 'telmarh_flickr',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_flickr', array(
		'label'    => __( 'Flickr URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_flickr',
		'priority'   => 80
	)));
	
	// Pinterest
	$wp_customize->add_setting( 'telmarh_pinterest',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_pinterest', array(
		'label'    => __( 'Pinterest URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_pinterest',
		'priority'   => 90
	)));
	
	// Youtube
	$wp_customize->add_setting( 'telmarh_youtube',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_youtube', array(
		'label'    => __( 'YouTube URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_youtube',
		'priority'   => 100
	)));
	
	// Vimeo
	$wp_customize->add_setting( 'telmarh_vimeo',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_vimeo', array(
		'label'    => __( 'Vimeo URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_vimeo',
		'priority'   => 110
	)));
	
	// Tumblr
	$wp_customize->add_setting( 'telmarh_tumblr',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_tumblr', array(
		'label'    => __( 'Tumblr URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_tumblr',
		'priority'   => 120
	)));
	
	// Dribbble
	$wp_customize->add_setting( 'telmarh_dribbble',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_dribbble', array(
		'label'    => __( 'Dribbble URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_dribbble',
		'priority'   => 130
	)));
	
	// behance
	$wp_customize->add_setting( 'telmarh_behance',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_behance', array(
		'label'    => __( 'Behance URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_behance',
		'priority'   => 132
	)));
	
	// 500px
	$wp_customize->add_setting( 'telmarh_500px',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_500px', array(
		'label'    => __( '500px URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_500px',
		'priority'   => 134
	)));
	
	// VK
	$wp_customize->add_setting( 'telmarh_vk',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_vk', array(
		'label'    => __( 'VK URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_vk',
		'priority'   => 135
	)));
	
	// yelp
	$wp_customize->add_setting( 'telmarh_yelp',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_yelp', array(
		'label'    => __( 'Yelp URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_yelp',
		'priority'   => 140
	)));
	
	// xing
	$wp_customize->add_setting( 'telmarh_xing',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_xing', array(
		'label'    => __( 'Xing URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_xing',
		'priority'   => 145
	)));
	
	// skype
	$wp_customize->add_setting( 'telmarh_skype',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_skype', array(
		'label'    => __( 'Skype URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_skype',
		'priority'   => 150
	)));
	
	// deviantart
	$wp_customize->add_setting( 'telmarh_deviant',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_deviant', array(
		'label'    => __( 'DeviantArt URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_deviant',
		'priority'   => 155
	)));
	
	// reddit
	$wp_customize->add_setting( 'telmarh_reddit',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_reddit', array(
		'label'    => __( 'Reddit URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_reddit',
		'priority'   => 160
	)));
	
	// github
	$wp_customize->add_setting( 'telmarh_github',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_github', array(
		'label'    => __( 'Github URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_github',
		'priority'   => 165
	)));
	
	// codepen
	$wp_customize->add_setting( 'telmarh_codepen',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_codepen', array(
		'label'    => __( 'Codepen URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_codepen',
		'priority'   => 165
	)));
	
	// spotify
	$wp_customize->add_setting( 'telmarh_spotify',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_spotify', array(
		'label'    => __( 'Spotify URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_spotify',
		'priority'   => 170
	)));
	
	// soundcloud
	$wp_customize->add_setting( 'telmarh_soundcloud',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_soundcloud', array(
		'label'    => __( 'SoundCloud URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_soundcloud',
		'priority'   => 175
	)));
	
	// lastfm
	$wp_customize->add_setting( 'telmarh_lastfm',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_lastfm', array(
		'label'    => __( 'lastFM URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_lastfm',
		'priority'   => 180
	)));
	
	// stumbleupon
	$wp_customize->add_setting( 'telmarh_stumble',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_stumble', array(
		'label'    => __( 'StumbleUpon URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_stumble',
		'priority'   => 185
	)));
	
	// Weibo
	$wp_customize->add_setting( 'telmarh_weibo',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_weibo', array(
		'label'    => __( 'Weibo URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_weibo',
		'priority'   => 188
	)));
	
	// Phone Number
	$wp_customize->add_setting( 'telmarh_phone_number_icon',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_phone_number_icon', array(
		'label'    => __( 'Phone Number:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_phone_number_icon',
		'priority'   => 190
	)));
	
	// Email
	$wp_customize->add_setting( 'telmarh_email_icon',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_email_icon', array(
		'label'    => __( 'Email:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_email_icon',
		'priority'   => 195
	))); 
	
	// RSS
	$wp_customize->add_setting( 'telmarh_rss',
	    array(
	        'sanitize_callback' => 'telmarh_sanitize_text',
	));  

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_rss', array(
		'label'    => __( 'RSS URL:', 'telmarh' ),
		'section'  => 'telmarh_settings',
		'settings' => 'telmarh_rss',
		'priority'   => 200
	)));
	
	
	// Fonts  
    $wp_customize->add_section(
        'telmarh_typography',
        array(
            'title' => __('Google Fonts', 'telmarh' ),
            'priority' => 45,
    ));
	
    $font_choices = 
        array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
			'Open Sans:400italic,700italic,400,700' => 'Open Sans',
			'Oswald:400,700' => 'Oswald',
			'Playfair Display:400,700,400italic' => 'Playfair Display',
			'Montserrat:400,700' => 'Montserrat',
			'Raleway:400,700' => 'Raleway',
            'Droid Sans:400,700' => 'Droid Sans',
            'Lato:400,700,400italic,700italic' => 'Lato',
            'Arvo:400,700,400italic,700italic' => 'Arvo',
            'Lora:400,700,400italic,700italic' => 'Lora',
			'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
			'Oxygen:400,300,700' => 'Oxygen',
			'PT Serif:400,700' => 'PT Serif', 
            'PT Sans:400,700,400italic,700italic' => 'PT Sans',
            'PT Sans Narrow:400,700' => 'PT Sans Narrow',
			'Cabin:400,700,400italic' => 'Cabin',
			'Fjalla One:400' => 'Fjalla One',
			'Francois One:400' => 'Francois One',
			'Josefin Sans:400,300,600,700' => 'Josefin Sans',  
			'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
            'Arimo:400,700,400italic,700italic' => 'Arimo',
            'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
            'Bitter:400,700,400italic' => 'Bitter',
            'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
            'Roboto:400,400italic,700,700italic' => 'Roboto',
            'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
            'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
            'Roboto Slab:400,700' => 'Roboto Slab',
            'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
            'Rokkitt:400' => 'Rokkitt',
    );
    
    $wp_customize->add_setting(
        'headings_fonts',
        array(
            'sanitize_callback' => 'telmarh_sanitize_fonts',
    ));
    
    $wp_customize->add_control(
        'headings_fonts',
        array(
            'type' => 'select',
            'description' => __('Select your desired font for the headings. Source Sans Pro is the default Heading font.', 'telmarh'),
            'section' => 'telmarh_typography',
            'choices' => $font_choices
    ));
    
    $wp_customize->add_setting(
        'body_fonts',
        array(
            'sanitize_callback' => 'telmarh_sanitize_fonts',
    ));
    
    $wp_customize->add_control(
        'body_fonts',
        array(
            'type' => 'select',
            'description' => __( 'Select your desired font for the body. Source Sans Pro is the default Body font.', 'telmarh' ),
            'section' => 'telmarh_typography',
            'choices' => $font_choices
    ));
	
	// Colors
	$wp_customize->add_setting( 'telmarh_text_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_text_color', array(
        'label'	   => __( 'Text Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_text_color',
		'priority' => 10 
    )));
	
	$wp_customize->add_setting( 'telmarh_custom_color', array(
        'default'     => '#039BE5', 
		'sanitize_callback' => 'sanitize_hex_color',
    ));
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_custom_color', array(
        'label'	   => __( 'Theme Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_custom_color',
		'priority' => 20
    )));
	
    $wp_customize->add_setting( 'telmarh_link_color', array(
        'default'     => '#039BE5',   
        'sanitize_callback' => 'sanitize_hex_color', 
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_link_color', array(
        'label'	   => __( 'Link Color', 'telmarh'),
        'section'  => 'colors',
        'settings' => 'telmarh_link_color',
		'priority' => 25
    )));
	
	$wp_customize->add_setting( 'telmarh_hover_color', array(
        'default'     => '#039BE5', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_hover_color', array(
        'label'	   => __( 'Hover Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_hover_color',
		'priority' => 30
    )));
	
	$wp_customize->add_setting( 'telmarh_site_title_color', array(
        'default'     => '#efefef', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_site_title_color', array(
        'label'	   => __( 'Site Title Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_site_title_color',
		'priority' => 40 
    )));
	
	$wp_customize->add_setting( 'telmarh_page_site_title_color', array(
        'default'     => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_site_title_color', array(
        'label'	   => __( 'Page + Sticky Nav Site Title Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_page_site_title_color',
		'priority' => 43
    )));
	
	/*$wp_customize->add_setting( 'telmarh_blockquote', array(
        'default'     => '#f5f5f5',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_blockquote', array(
        'label'	   => __( 'Blockquote Background', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_blockquote',
		'priority' => 45
    )));
	
	$wp_customize->add_setting( 'telmarh_blockquote_border', array(
        'default'     => '#222222', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_blockquote_border', array(
        'label'	   => __( 'Blockquote Accent Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_blockquote_border',
		'priority' => 50 
    )));*/
	
	$wp_customize->add_setting( 'telmarh_entry', array(
        'default'     => '#404040', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_entry', array(
        'label'	   => __( 'Entry Title Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_entry',
		'priority' => 55
    )));
	
	$wp_customize->add_setting( 'telmarh_button_text', array(
        'default'     => '#FFFFFF', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_button_text', array(
        'label'	   => __( 'Button Text Color', 'telmarh' ),
        'section'  => 'colors',
        'settings' => 'telmarh_button_text',
		'priority' => 60
    )));

	$wp_customize->add_setting( 'telmarh_page_hp_background_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_hp_background_color', array(
        'label'	   => "Couleur du backgound contenu de la page d'accueil",
        'section'  => 'colors',
        'settings' => 'telmarh_page_hp_background_color',
		'priority' => 135
    )));

	$wp_customize->add_setting( 'telmarh_page_hp_content_color', array(
        'default'     => '#404040',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'telmarh_page_hp_content_color', array(
        'label'	   => "Couleur du contenu page d'accueil",
        'section'  => 'colors',
        'settings' => 'telmarh_page_hp_content_color',
		'priority' => 135
    )));
	
	//Animations
	$wp_customize->add_section( 'telmarh_animations' , array(
	    'title'       => __( 'Animations', 'telmarh' ),
	    'priority'    => 50,  
	    'description' => __( 'We can make things fly across the screen.', 'telmarh' ),
	)); 
	
    $wp_customize->add_setting(
        'telmarh_animate',
        array(
            'sanitize_callback' => 'telmarh_sanitize_checkbox',
            'default' => 0,
    ));
	
    $wp_customize->add_control( 
        'telmarh_animate',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box if you want to disable the animations.', 'telmarh'),
            'section' => 'telmarh_animations',
            'priority' => 1,           
    ));
	
	// Choose excerpt or full content on blog
    $wp_customize->add_section( 'telmarh_layout_section' , array(
	    'title'       => __( 'Blog Layout', 'telmarh' ),
	    'priority'    => 51,   
	    'description' => __( 'Change how telmarh displays posts', 'telmarh' ),
	));

	$wp_customize->add_setting( 'telmarh_post_content', array(
		'default'	        => 'option1',
		'sanitize_callback' => 'telmarh_sanitize_index_content',
	));

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'telmarh_post_content', array(
		'label'    => __( 'Post content', 'telmarh' ),
		'section'  => 'telmarh_layout_section',
		'settings' => 'telmarh_post_content',
		'type'     => 'radio',
		'choices'  => array(
			'option1' => 'Excerpts',
			'option2' => 'Full content', 
			),
	)));
	
	//Excerpt
    $wp_customize->add_setting(
        'exc_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '50',
    )); 
	
    $wp_customize->add_control( 'exc_length', array( 
        'type'        => 'number',
        'priority'    => 2, 
        'section'     => 'telmarh_layout_section',
        'label'       => __('Excerpt length', 'telmarh'),
        'description' => __('Choose your excerpt length here. Default: 50 words', 'telmarh'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5
        ), 
	));
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	
}
add_action( 'customize_register', 'telmarh_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function telmarh_customize_preview_js() {
	wp_enqueue_script( 'telmarh_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'telmarh_customize_preview_js' );
