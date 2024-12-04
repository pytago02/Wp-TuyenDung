<?php
/**
 * Joblook functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Joblook
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function joblook_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Joblook, use a find and replace
		* to change 'joblook' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'joblook', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'joblook' ),
		)
	);

	add_image_size( 'joblook-blog-thumbnail-img', 650, 450, true);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'joblook_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'joblook_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function joblook_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'joblook_content_width', 640 );
}
add_action( 'after_setup_theme', 'joblook_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function joblook_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'joblook' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'joblook' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name' => esc_html__('Joblook Footer Widget', 'joblook') . $i,
            'id' => 'joblook_footer_' . $i,
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-heading">',
            'after_title' => '</h3>',
        ));
    }
}
add_action( 'widgets_init', 'joblook_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function joblook_scripts() {
	wp_enqueue_style( 'joblook-style', get_stylesheet_uri() );
    wp_enqueue_style( 'joblook-font', joblook_fonts(), array(), null);
    wp_enqueue_style(
        'joblook-fontawesome',
        get_template_directory_uri() . '/assets/fontawesome/css/all.css',
        array(),
        '1.0'
    );
   	wp_enqueue_style( 'joblook-bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '1.0' );
   	wp_enqueue_style( 'joblook-chosen-css', get_template_directory_uri() . '/assets/css/chosen.css', array(), '1.0' );
	wp_enqueue_style( 'joblook-css', get_template_directory_uri() . '/assets/css/joblook.css', array(), '1.0' );
	wp_enqueue_style( 'joblook-media-queries', get_template_directory_uri() . '/assets/css/media-queries.css', array(), '1.0' );

	wp_enqueue_script( 'joblook-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'joblook-chosen-script', get_template_directory_uri() . '/assets/js/chosen.jquery.js', array('jquery'), '1.0', true);
	wp_enqueue_script( 'joblook-custom-script', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'joblook_scripts',99  );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/plugin-activation.php';
require get_template_directory() . '/lib/joblook-tgmp.php';
require get_template_directory() . '/elementor/joblook-elementor-widget.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/joblook-customizer-default.php';
require get_template_directory() . '/inc/customize-control.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



if (!function_exists('joblook_fonts')) :
    function joblook_fonts()
    {
        $fonts_url = '';
        $fonts = array();


		if ('off' !== _x('on', 'Inter font: on or off', 'joblook')) {
            $fonts[] = 'Inter:400,600';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
            ), '//fonts.googleapis.com/css');
        }

        return $fonts_url;
    }
endif;


if(!function_exists('joblook_blog_get_category')) {
    function joblook_blog_get_category()
    {

        $terms = get_terms('category',array(
            'hide_empty' => true,
        ));
        $options = ['' => ''];

        foreach ($terms as $t) {
            $options[$t->term_id] = $t->name;
        }
        return $options;
    }
}


if (!function_exists('joblook_get_excerpt')) :
    function joblook_get_excerpt($post_id, $count)
    {
        $content_post = get_post($post_id);
        $excerpt = $content_post->post_content;

        $excerpt = strip_shortcodes($excerpt);
		$regex = array (
			'/<h2[^>]*>.*?<\/h2>/i',
			'/<h1[^>]*>.*?<\/h1>/i',
			'/<h3[^>]*>.*?<\/h3>/i',
			'/<h4[^>]*>.*?<\/h4>/i',
			'/<h5[^>]*>.*?<\/h5>/i',
			'/<h6[^>]*>.*?<\/h6>/i',
		);
		
		$excerpt = preg_replace($regex, '', $excerpt);
        $excerpt = strip_tags($excerpt);


        $excerpt = preg_replace('/\s\s+/', ' ', $excerpt);
        $excerpt = preg_replace('#\[[^\]]+\]#', ' ', $excerpt);




        $strip = explode(' ', $excerpt);
        foreach ($strip as $key => $single) {
            if (!filter_var($single, FILTER_VALIDATE_URL) === false) {
                unset($strip[$key]);
            }
        }
        $excerpt = implode(' ', $strip);

        $excerpt = substr($excerpt, 0, $count);
        if (strlen($excerpt) >= $count) {
            $excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
            $excerpt = $excerpt . '...';
        }
        return $excerpt;
        
        
    }
endif;


if (!function_exists('joblook_archive_link')) {
    function joblook_archive_link($post)
    {
        $year = date('Y', strtotime($post->post_date));
        $month = date('m', strtotime($post->post_date));
        $day = date('d', strtotime($post->post_date));
        $link = site_url('') . '/' . $year . '/' . $month . '?day=' . $day;
        return $link;
    }
}


if (!function_exists('joblook_blank_widget')) {

    function joblook_blank_widget()
    {
        echo '<div class="col-md-4">';
        if (is_user_logged_in() && current_user_can('edit_theme_options')) {
            echo '<a href="' . esc_url(admin_url('widgets.php')) . '" target="_blank">' . esc_html__('Add Footer Widget', 'joblook') . '</a>';
        }
        echo '</div>';
    }
}


//radio box sanitization function
function joblook_sanitize_radio( $input, $setting ){

    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible radio box options
    $choices = $setting->manager->get_control( $setting->id )->choices;

    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}




if (!function_exists('joblook_archive_link')) {
    function joblook_archive_link($post)
    {
        $year = date('Y', strtotime($post->post_date));
        $month = date('m', strtotime($post->post_date));
        $day = date('d', strtotime($post->post_date));
        $link = site_url('') . '/' . $year . '/' . $month . '?day=' . $day;
        return $link;
    }
}



function joblook_enqueue_styles() {
    wp_enqueue_style('joblook-welcome-style', get_template_directory_uri() . '/welcome/welcome.css', array(), '1.0' );
    wp_enqueue_script( 'joblook-welcome-script', get_template_directory_uri() . '/welcome/welcome-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'joblook_enqueue_styles');

// Add admin notice
function joblook_admin_notice() { 
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'joblook_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();

    if( 'themes.php' == $pagenow && !$meta ){
	    if( is_network_admin() ){
	        return;
	    }

	    if( ! current_user_can( 'manage_options' ) ){
	        return;
	    } ?>
	    <div class="notice notice-success">
	        <h1><?php esc_html_e('Hey, Thank you for installing Joblook Theme!', 'joblook'); ?></h1>
	        <p><?php esc_html_e('Joblook is now installed and ready to use. Click below to see theme documentation, and other details to get started.', 'joblook'); ?></p>
	        <p><a class="btn btn-default" href="<?php echo esc_url( admin_url( 'themes.php?page=joblook-welcome' ) ); ?>"><?php esc_html_e('Welcome to Joblook', 'joblook'); ?></a></p>
	        <p class="dismiss-link"><strong><a href="?joblook_admin_notice=1"><?php esc_html_e( 'Dismiss', 'joblook' ); ?></a></strong></p>
	    </div>
	    <?php

	}
}

add_action( 'admin_notices', 'joblook_admin_notice' );

if( ! function_exists( 'joblook_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function joblook_update_admin_notice(){
    if ( isset( $_GET['joblook_admin_notice'] ) && $_GET['joblook_admin_notice'] = '1' ) {
        update_option( 'joblook_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'joblook_update_admin_notice' );


/**
 * Add a menu item to the admin menu.
 */
function joblook_add_welcome_page() {
    add_theme_page(
        esc_html__('About Joblook', 'joblook'),
        esc_html__('Welcome to Joblook', 'joblook'),
        'manage_options',
        'joblook-welcome',
        'joblook_welcome_page'
    );
}
add_action('admin_menu', 'joblook_add_welcome_page');

/**
 * Display the welcome page content.
 */
function joblook_welcome_page() {
    include get_template_directory() . '/welcome/welcome.php';
}

/**
 * Gửi email cho nhà tuyển dụng khi có người ứng tuyển
 */
function joblook_send_application_email() {
    // Kiểm tra nếu form được submit
    if(isset($_POST['apply_job'])) {
        
        // Lấy thông tin người ứng tuyển
        $applicant_name = sanitize_text_field($_POST['applicant_name']);
        $applicant_email = sanitize_email($_POST['applicant_email']); 
        $applicant_phone = sanitize_text_field($_POST['applicant_phone']);
        $applicant_cv = $_FILES['applicant_cv'];
        
        // Lấy thông tin công việc và nhà tuyển dụng
        $job_id = intval($_POST['job_id']);
        $job_title = get_the_title($job_id);
        $employer_email = get_post_meta($job_id, 'employer_email', true);
        
        // Nội dung email
        $subject = sprintf('Có ứng viên mới ứng tuyển cho vị trí: %s', $job_title);
        
        $message = sprintf('
            <p>Xin chào,</p>
            <p>Có ứng viên mới ứng tuyển cho vị trí <strong>%s</strong></p>
            <p>Thông tin ứng viên:</p>
            <ul>
                <li>Họ tên: %s</li>
                <li>Email: %s</li>
                <li>Số điện thoại: %s</li>
            </ul>
        ', $job_title, $applicant_name, $applicant_email, $applicant_phone);

        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Đính kèm CV nếu có
        if($applicant_cv['error'] == 0) {
            $cv_path = $applicant_cv['tmp_name'];
            $cv_name = $applicant_cv['name'];
            $attachments = array($cv_path);
        } else {
            $attachments = array();
        }

        // Gửi email
        $mail_sent = wp_mail($employer_email, $subject, $message, $headers, $attachments);

        if($mail_sent) {
            wp_send_json_success('Đã gửi CV thành công!');
        } else {
            wp_send_json_error('Có lỗi xảy ra khi gửi CV. Vui lòng thử lại sau.');
        }
    }
}
add_action('wp_ajax_joblook_send_application', 'joblook_send_application_email');
add_action('wp_ajax_nopriv_joblook_send_application', 'joblook_send_application_email');
