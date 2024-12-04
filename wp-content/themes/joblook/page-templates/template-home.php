<?php
/**
 *
 * Template Name: Home Page Template

 *
 * @package Joblook
 */
 
get_header();

$joblook_options = joblook_theme_options();
$about_sec_show = $joblook_options['about_sec_show'];
$newsletter_sec_show = $joblook_options['newsletter_sec_show'];
$blog_sec_show = $joblook_options['blog_sec_show'];
$bottomblog_sec_show = $joblook_options['bottomblog_sec_show'];


get_template_part('template-parts/homepage/banner', 'section');

if($blog_sec_show == 1)
get_template_part('template-parts/homepage/blog', 'section');

if($about_sec_show == 1)
get_template_part('template-parts/homepage/about', 'section');

if($bottomblog_sec_show == 1)
get_template_part('template-parts/homepage/bottomblog', 'section');

if($newsletter_sec_show == 1)
get_template_part('template-parts/homepage/cta', 'section');




get_footer();
