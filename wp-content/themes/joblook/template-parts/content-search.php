<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Joblook
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
</article><!-- #post-<?php the_ID(); ?> -->
