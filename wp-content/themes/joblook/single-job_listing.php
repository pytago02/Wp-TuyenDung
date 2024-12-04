<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package joblook
 */


  
get_header(); 

  ?>
<div id="content" class="page-section">
    <div class="container">
        <div class="row">
                <div class="col-md-12">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">

						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );



						endwhile; // End of the loop.
						?>

					</main><!-- #main -->
                </div>
            </div>
            </div>
            
    </div>
</div>


<?php
get_footer();
