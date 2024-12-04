<?php
/**
 * Joblook Theme Customizer
 *
 * @package Joblook
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function joblook_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$joblook_options = joblook_theme_options();

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'joblook_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'joblook_customize_partial_blogdescription',
			)
		);
	}

	$wp_customize->add_panel(
        'theme_options',
        array(
            'title' => esc_html__('Theme Options', 'joblook'),
            'priority' => 2,
        )
    );



//Social Links
    $wp_customize->add_section(
    'social_section',
	    array(
	        'title' => esc_html__( 'Social Links','joblook' ),
		     'description' => esc_html__( 'More Social Links are available in Premium Version','joblook' ),
	        'panel'=>'theme_options',
	        'capability'=>'edit_theme_options',
	    )
	);
	$wp_customize->add_setting('joblook_theme_options[fb_url]',
	    array(
	        'type' => 'option',
	        'default' => $joblook_options['fb_url'],
	        'sanitize_callback' => 'joblook_sanitize_url',
	    )
	);
	$wp_customize->add_control('joblook_theme_options[fb_url]',
	    array(
	        'label' => esc_html__('Facebook Link', 'joblook'),
	        'type' => 'text',
	        'section' => 'social_section',
	        'settings' => 'joblook_theme_options[fb_url]',
	    )
	);
		$wp_customize->add_setting('joblook_theme_options[insta_url]',
	    array(
	        'type' => 'option',
	        'default' => $joblook_options['insta_url'],
	        'sanitize_callback' => 'joblook_sanitize_url',
	    )
	);
	$wp_customize->add_control('joblook_theme_options[insta_url]',
	    array(
	        'label' => esc_html__('Instagram Link', 'joblook'),
	        'type' => 'text',
	        'section' => 'social_section',
	        'settings' => 'joblook_theme_options[insta_url]',
	    )
	);
		$wp_customize->add_setting('joblook_theme_options[twitter_url]',
	    array(
	        'type' => 'option',
	        'default' => $joblook_options['twitter_url'],
	        'sanitize_callback' => 'joblook_sanitize_url',
	    )
	);
	$wp_customize->add_control('joblook_theme_options[twitter_url]',
	    array(
	        'label' => esc_html__('Twiiter X Link', 'joblook'),
	        'type' => 'text',
	        'section' => 'social_section',
	        'settings' => 'joblook_theme_options[twitter_url]',
	    )
	);


    $wp_customize->add_section(
    'article_section',
	    array(
	        'title' => esc_html__( 'Single Article/Blog Page','joblook' ),
	        'panel'=>'theme_options',
	        'capability'=>'edit_theme_options',
	    )
	);

	$wp_customize->add_setting('joblook_theme_options[sidebar_show]',
	    array(
	        'type' => 'option',
	        'default'        => true,
	        'default' => $joblook_options['sidebar_show'],
	        'sanitize_callback' => 'joblook_sanitize_checkbox',
	    )
	);

	$wp_customize->add_control('joblook_theme_options[sidebar_show]',
	    array(
	        'label' => esc_html__('Show Sidebar in Single Article?', 'joblook'),
	        'type' => 'Checkbox',
	        'section' => 'article_section',

	    )
	);



//Header Section
    $wp_customize->add_section(
    'header_section',
	    array(
	        'title' => esc_html__( 'Header Section','joblook' ),
	        'panel'=>'theme_options',
	        'capability'=>'edit_theme_options',
	    )
	);


       $wp_customize->add_setting( 'joblook_theme_options[header_layout]', array(
          'capability' => 'edit_theme_options',
          'default' => 'header1',
          'sanitize_callback' => 'joblook_sanitize_radio',
          'type' => 'option',
    ) );

    $wp_customize->add_control( 'joblook_theme_options[header_layout]', array(
          'type' => 'radio',
          'section' => 'header_section', // Add a default or your own section
          'label' => esc_attr( __('Choose Header Layout', 'joblook') ),
          'choices' => array(
            'header1' => esc_attr( __('Default Header', 'joblook') ),
            'header2' => esc_attr( __('Centered Layout', 'joblook') ),
            'header3' => esc_attr( __('Bottom Menu Layout', 'joblook') ),
          ),
    ) );


	$wp_customize->add_setting('joblook_theme_options[dark_header]',
	    array(
	        'type' => 'option',
	        'default'        => true,
	        'default' => $joblook_options['dark_header'],
	        'sanitize_callback' => 'joblook_sanitize_checkbox',
	    )
	);

	$wp_customize->add_control('joblook_theme_options[dark_header]',
	    array(
	        'label' => esc_html__('Dark Header?', 'joblook'),
	        'type' => 'Checkbox',
	        'section' => 'header_section',

	    )
	);

	$wp_customize->add_setting('joblook_theme_options[header_full_width]',
	    array(
	        'type' => 'option',
	        'default'        => true,
	        'default' => $joblook_options['header_full_width'],
	        'sanitize_callback' => 'joblook_sanitize_checkbox',
	    )
	);

	$wp_customize->add_control('joblook_theme_options[header_full_width]',
	    array(
	        'label' => esc_html__('Full Width?', 'joblook'),
	        'type' => 'Checkbox',
	        'section' => 'header_section',

	    )
	);




	$wp_customize->add_section(
    'footer_section',
	    array(
	        'title' => esc_html__( 'Footer Option','joblook' ),
	       	'description' => esc_html__( 'Copyright text can be changed in Premium Version','joblook' ),
	        'panel'=>'theme_options',
	        'capability'=>'edit_theme_options',
	    )
	);

	$wp_customize->add_setting('joblook_theme_options[show_widgets]',
	    array(
	        'type' => 'option',
	        'default'        => true,
	        'default' => $joblook_options['show_widgets'],
	        'sanitize_callback' => 'joblook_sanitize_checkbox',
	    )
	);

	$wp_customize->add_control('joblook_theme_options[show_widgets]',
	    array(
	        'label' => esc_html__('Show Widgets', 'joblook'),
	        'type' => 'Checkbox',
	        'priority' => 1,
	        'section' => 'footer_section',

	    )
	);


}
add_action( 'customize_register', 'joblook_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function joblook_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function joblook_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function joblook_customize_preview_js() {
	wp_enqueue_script( 'joblook-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'joblook_customize_preview_js' );
