<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Joblook
 */

get_header();
$joblook_options = joblook_theme_options();
$sidebar_show = $joblook_options['sidebar_show'];

?>
<div id="content" class="page-section">
    <div class="container">
        <div class="row">

        	<?php if($sidebar_show==1){ ?> 
            <div class="col-md-8">
				<main id="primary" class="site-main">

						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							the_post_navigation(
								array(
									'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'joblook' ) . '</span> <span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'joblook' ) . '</span> <span class="nav-title">%title</span>',
								)
							);

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>

				</main><!-- #main -->
            </div>

            <div class="col-md-4">
            	<?php get_sidebar(); ?>
            </div>

        <?php } else { ?>
            <div class="col-md-12 no-sidebar">
				<main id="primary" class="site-main">

						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							the_post_navigation(
								array(
									'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'joblook' ) . '</span> <span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'joblook' ) . '</span> <span class="nav-title">%title</span>',
								)
							);

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>

				</main><!-- #main -->
            </div>

        <?php } ?>
        </div>        
    </div>
</div>

<?php

get_footer();
