<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Joblook
 */

get_header();
?>
<div id="content" class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
				<main id="primary" class="site-main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
									<?php
									/* translators: %s: search query. */
									printf( esc_html__( 'Search Results for: %s', 'joblook' ), '<span>' . get_search_query() . '</span>' );
									?>
							</h1>
						</header><!-- .page-header -->

						<div class="posts-wrap">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
					</div>
				</main><!-- #main -->

			</div>
        </div>        
    </div>
</div>

<?php
get_footer();
