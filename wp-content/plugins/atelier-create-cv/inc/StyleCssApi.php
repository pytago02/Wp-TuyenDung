<?php

namespace ateliercv;

class StyleCssApi
{

    /* Register Settings style */
    public function __construct()
    {

        add_action('admin_head', [$this, 'styleSettingsApi']);

    }

    public function styleSettingsApi()
    { ?>

        <!-- Style Atelier Scroll Top Settings Api -->
        <style>

            .preview-sidebar {
                background-color: <?php echo esc_attr(get_option('sidebar_bg_color')); ?>;
            }

            .preview-sidebar,
            h2.atl-prv-title {
                color: <?php echo esc_attr(get_option('atl_cv_font_color')); ?>;
            }

            .image-box img {
                border: 3px solid  <?php echo esc_attr(get_option('atl_cv_font_color')); ?>;
            }



        </style>

    <?php }

}