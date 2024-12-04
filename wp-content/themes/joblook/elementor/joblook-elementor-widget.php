<?php
require get_template_directory(). '/elementor/elementor-helper.php';

add_action( 'elementor/widgets/widgets_registered', 'joblook_free_elementor_widgets' );

function joblook_free_elementor_widgets($widgets_manager){
    // We check if the Elementor plugin has been installed / activated.

    if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
        require get_template_directory(). '/elementor/joblook-elementor-blog.php';
        require get_template_directory(). '/elementor/joblook-elementor-job-list.php';
        require get_template_directory(). '/elementor/joblook-elementor-search-widget.php';

    }
}