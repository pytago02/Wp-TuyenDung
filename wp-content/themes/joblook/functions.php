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

// Thêm hàm xử lý gửi email khi ứng viên ứng tuyển
function joblook_send_application_email($application_id, $job_id, $candidate_id) {
    // Lấy thông tin công việc
    $job = get_post($job_id);
    $company_id = get_post_meta($job_id, '_job_author', true);
    $company_user = get_user_by('id', $company_id);
    $company_email = $company_user->user_email;
    
    // Lấy thông tin ứng viên
    $candidate = get_user_by('id', $candidate_id);
    $candidate_name = $candidate->display_name;
    
    // Chuẩn bị nội dung email
    $subject = sprintf('Có ứng viên mới ứng tuyển vào vị trí: %s', $job->post_title);
    
    $message = sprintf(
        'Xin chào,<br><br>
        Ứng viên %s đã ứng tuyển vào vị trí %s.<br><br>
        Để xem chi tiết hồ sơ ứng tuyển, vui lòng truy cập vào link sau:<br>
        %s<br><br>
        Trân trọng,<br>
        %s',
        $candidate_name,
        $job->post_title,
        admin_url('post.php?post=' . $application_id . '&action=edit'),
        get_bloginfo('name')
    );
    
    // Thiết lập headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>'
    );
    
    // Gửi email
    wp_mail($company_email, $subject, $message, $headers);
}
add_action('job_manager_application_submitted', 'joblook_send_application_email', 10, 3);

// Tùy chỉnh template email
function joblook_email_template($message) {
    $email_template = '
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px;">
            <h2 style="color: #333; margin-bottom: 20px;">Thông báo ứng tuyển mới</h2>
            %s
        </div>
        <div style="text-align: center; margin-top: 20px; color: #666; font-size: 12px;">
            Email này được gửi tự động từ %s
        </div>
    </div>';
    
    return sprintf($email_template, $message, get_bloginfo('name'));
}
add_filter('job_manager_email_message', 'joblook_email_template');

// Xử lý form ứng tuyển
function handle_job_application() {
    if (isset($_POST['submit_job_application']) && wp_verify_nonce($_POST['job_application_nonce'], 'submit_job_application')) {
        
        // Lấy thông tin công việc
        $job_id = intval($_POST['job_id']);
        $job = get_post($job_id);
        $company_id = get_post_meta($job_id, '_job_author', true);
        $company_user = get_user_by('id', $company_id);
        $employer_email = $company_user->user_email;

        // Lấy thông tin CV được chọn
        $cv_id = intval($_POST['selected_cv']);
        $cv_content = get_post_meta($cv_id, 'cv_html_content', true);
        $cv_pdf_url = get_post_meta($cv_id, 'cv_pdf_file', true);
        
        // Lấy thông tin người ứng tuyển
        $applicant = wp_get_current_user();

        // Chuẩn bị nội dung email
        $subject = sprintf('Ứng viên %s ứng tuyển vị trí: %s', 
            $applicant->display_name,
            $job->post_title
        );
        
        $message = sprintf(
            'Thông tin ứng viên:<br><br>
            Họ tên: %s<br>
            Email: %s<br>
            Số điện thoại: %s<br><br>
            Thư giới thiệu:<br>%s<br><br>
            CV đính kèm trong file PDF.',
            $applicant->display_name,
            $applicant->user_email,
            get_user_meta($applicant->ID, 'phone', true),
            wp_kses_post($_POST['cover_letter'])
        );

        // Áp dụng template email
        $message = joblook_email_template($message);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>'
        );
        
        // Đính kèm file PDF của CV
        $cv_pdf_path = get_attached_file(attachment_url_to_postid($cv_pdf_url));
        $attachments = array($cv_pdf_path);

        // Gửi email
        $mail_sent = wp_mail($employer_email, $subject, $message, $headers, $attachments);

        if ($mail_sent) {
            // Lưu đơn ứng tuyển vào database
            $application = array(
                'post_type' => 'job_application',
                'post_title' => sprintf('Ứng tuyển: %s - %s', $applicant->display_name, $job->post_title),
                'post_status' => 'publish',
                'post_author' => $applicant->ID
            );
            
            $application_id = wp_insert_post($application);
            
            if ($application_id) {
                update_post_meta($application_id, 'job_id', $job_id);
                update_post_meta($application_id, 'cv_id', $cv_id);
                update_post_meta($application_id, 'status', 'pending');
                
                // Gọi action để thông báo ứng tuyển thành công
                do_action('job_manager_application_submitted', $application_id, $job_id, $applicant->ID);
            }
            
            wp_redirect(add_query_arg('application', 'success', get_permalink($job_id)));
            exit;
        } else {
            wp_redirect(add_query_arg('application', 'failed', get_permalink($job_id)));
            exit;
        }
    }
}
add_action('init', 'handle_job_application');

// Hiển thị thông báo sau khi ứng tuyển
function show_application_messages() {
    if (isset($_GET['application'])) {
        if ($_GET['application'] == 'success') {
            echo '<div class="alert alert-success">
                    <p>Đơn ứng tuyển của bạn đã được gửi thành công!</p>
                  </div>';
        } else {
            echo '<div class="alert alert-danger">
                    <p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>
                  </div>';
        }
    }
}
add_action('wp_body_open', 'show_application_messages');

add_action('wp_ajax_preview_cv', 'handle_preview_cv');

function handle_preview_cv() {
    check_ajax_referer('cv_preview_nonce', 'nonce');
    
    $cv_id = intval($_POST['cv_id']);
    $cv_html = get_post_meta($cv_id, 'cv_html_content', true);
    
    wp_send_json_success(array('html' => $cv_html));
}

// Thêm scripts và styles
function enqueue_job_apply_assets() {
    if (is_page_template('page-templates/job-apply.php')) {
        wp_enqueue_style('job-apply-css', get_template_directory_uri() . '/assets/css/job-apply.css');
        wp_enqueue_script('job-apply-js', get_template_directory_uri() . '/assets/js/job-apply.js', array('jquery'), null, true);
        
        wp_localize_script('job-apply-js', 'cv_preview', array(
            'nonce' => wp_create_nonce('cv_preview_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_job_apply_assets');

function restrict_pages_for_subscribers() {
    // Kiểm tra nếu người dùng là Subscriber
    if (is_user_logged_in() && current_user_can('subscriber')) {
        // Lấy URL của trang hiện tại
        $current_url = home_url(add_query_arg(array(), $GLOBALS['wp']->request));

        // Danh sách slug của các trang cần chặn
        $restricted_pages = array(
            home_url('/post-a-job'), // Thay bằng URL hoặc slug trang Đăng tuyển dụng
            home_url('/tat-ca-cong-viec')   // Thay bằng URL hoặc slug trang Đã đăng tuyển
        );

        // Nếu URL hiện tại trùng với trang bị chặn
        if (in_array($current_url, $restricted_pages)) {
            // Thêm thông báo vào session
            if (!session_id()) {
                session_start();
            }
            $_SESSION['toast_message'] = 'Bạn không phải là nhà tuyển dụng';
            
            // Chuyển hướng về trang chủ
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_pages_for_subscribers');


/**
 * Lưu CV vào user meta khi CV được tạo/cập nhật
 * 
 * @param int $cv_id ID của CV (có thể là post ID nếu CV được lưu dưới dạng custom post type)
 * @param string $cv_name Tên của CV
 */
function save_cv_to_user_meta($cv_id, $cv_name) {
    $user_id = get_current_user_id();
    
    // Lấy danh sách CV hiện tại
    $user_cvs = get_user_meta($user_id, 'user_cvs', true);
    
    // Nếu chưa có danh sách CV, tạo mảng mới
    if (!is_array($user_cvs)) {
        $user_cvs = array();
    }
    
    // Thêm CV mới vào danh sách
    $user_cvs[$cv_id] = $cv_name;
    
    // Cập nhật metadata
    update_user_meta($user_id, 'user_cvs', $user_cvs);
}

/**
 * Xóa CV khỏi user meta
 * 
 * @param int $cv_id ID của CV cần xóa
 */
function remove_cv_from_user_meta($cv_id) {
    $user_id = get_current_user_id();
    $user_cvs = get_user_meta($user_id, 'user_cvs', true);
    
    if (is_array($user_cvs) && isset($user_cvs[$cv_id])) {
        unset($user_cvs[$cv_id]);
        update_user_meta($user_id, 'user_cvs', $user_cvs);
    }
}

/**
 * Chuyển thẻ input thành thẻ p chứa thông tin
 */
/**

function convert_input_to_p() {
    // Kiểm tra xem có phải là trang hồ sơ CV không
    if (is_page('ho-so-cv')) {
        // Kiểm tra user có role employer không
        if (current_user_can('employer')) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                // Thêm tiêu đề "Thông tin hồ sơ" vào đầu form
                $('.cv-form').prepend('<h3 class="mb-4">Thông tin hồ sơ</h3>');
                $('input[type="text"], input[type="tel"]').each(function() {
                    var value = $(this).val();
                    var label = $(this).prev('label').text();
                    $(this).replaceWith('<p class="form-control-static"><strong>' + '</strong> ' + value + '</p>');
                });
                
                $('textarea').each(function() {
                    var value = $(this).val();
                    var label = $(this).prev('label').text();
                    $(this).replaceWith('<p class="form-control-static"><strong>' + '</strong> ' + value + '</p>');
                });
                
                // Ẩn các nút và phần upload
                $('button[name="edit_cv"], button[name="submit_cv"], .uploadfilecv, th:last-child, td:last-child').hide();
            });
            </script>
            <?php
        }
    }
}
add_action('wp_footer', 'convert_input_to_p');
 */

