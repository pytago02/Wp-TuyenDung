<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Joblook
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if (is_archive() || is_home()){ ?>
	    <?php global $post;
	    $post_format = get_post_format($post->ID);
	    $blog_post_author = get_avatar(get_the_author_meta('ID'), 32);
	    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
	    $image = wp_get_attachment_image_src($post_thumbnail_id, 'joblook-blog-thumbnail-img');
	    $author_name = get_the_author_meta('display_name');
	    $category = get_the_category();
	    if (!empty($image)) {
	        $image_style = "style='background-image:url(" . esc_url($image[0]) . ")'";
	    } else {
	        $image_style = '';
	    }
	    if($image){
	        $url = $image[0];
	    }


	    ?>
	    <div class="post-wrap-element">
	        <div class="post-content-wrap">
	        	<?php if ($image) :?>
	            <div class="post-thumb">
	                <img src="<?php echo esc_url($image[0]) ?>">
	            </div>
	            <?php endif; ?>
	            <div class="post-content">

	                <h2>
	                    <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo the_title(); ?></a>
	                </h2>
	                <ul class="post-meta">
	                <li class="post-cat">
	            <?php 
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
	echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
	}
	            ?>
	        </li>
	                    <li class="meta-date"><a
	                                href="<?php echo esc_url(joblook_archive_link($post)); ?>">
	                             <time class="entry-date published"
	                                      datetime="<?php echo esc_url(joblook_archive_link($post)); ?>"><?php echo esc_html(the_time( get_option( 'date_format' ) )); ?></time>
	                        </a></li>
	                </ul>

	            </div>
	        </div>
	    </div>
	<?php } else{ ?>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				joblook_posted_on();
				joblook_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php joblook_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if (is_archive() || is_home()){
                echo wp_kses_post(joblook_get_excerpt($post->ID, 300));
		}
		 else{
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'joblook' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		}

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'joblook' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php joblook_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php } ?>
</article><!-- #post-<?php the_ID(); ?> -->
