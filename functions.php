<?php
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