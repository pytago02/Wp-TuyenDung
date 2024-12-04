<?php
if (!function_exists('joblook_theme_options')) :
    function joblook_theme_options()
    {
        $defaults = array(

            'fb_url' => '',
            'youtube_url' => '',
            'insta_url' => '',
            'twitter_url' => '',
            'header_layout' => 'header1',
            'dark_header' => 0,
            'header_full_width' => 0,
            'transparent_header' => 0,
            

            'banner_blog_category' => '',
            
            //Banner section
            'banner_title' => '',
            'banner_sub_title' => '',
            'banner_image' => '',

            'about_sec_show' => 0,
            'about_sec_title' => '',
            'about_sec_description' => '',
            'about_btn_text' => '',
            'about_button_url' => '',

            //CTA section
            'newsletter_sec_show' => 1,
            'newsletter_sec_title' => '',
            'newsletter_description' => '',
            'newsletter_shortcode' => '',
            'newsletter_image' => '',

            //Blog section
            'blog_sec_show' => 1,
            'blog_sec_title' => '',
            'blog_post_no' => '',

            //Blog section
            'bottomblog_sec_show' => 1,
            'bottomblog_sec_title' => '',
            'bottomblog_post_no' => '',
            'bottomblog_category' => '',

            'show_widgets' => 1,

            'sidebar_show' => 1,
        
        );

        $options = get_option('joblook_theme_options', $defaults);

        $options = wp_parse_args($options, $defaults);

        return $options;
    }
endif;
