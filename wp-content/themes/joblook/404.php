<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Rất tiếc! Không tìm thấy trang.', 'joblook' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'Có vẻ như không có gì được tìm thấy ở đây. Hãy thử tìm kiếm hoặc sử dụng các liên kết dưới đây?', 'joblook' ); ?></p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Danh mục phổ biến', 'joblook' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					$joblook_archive_content = '<p>' . sprintf( esc_html__( 'Hãy thử tìm trong các bài viết theo tháng. %1$s', 'joblook' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$joblook_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
            </div>
        </div>        
    </div>
</div>
<?php
get_footer();
