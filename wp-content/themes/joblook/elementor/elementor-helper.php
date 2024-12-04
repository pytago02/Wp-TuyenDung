<?php
namespace Elementor;
function joblook_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'joblook-elementor-widget',

        [
            'title'  => 'Joblook Free Elementor Widgets',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\joblook_elementor_init');