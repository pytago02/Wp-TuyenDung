<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Define our Pt Elementor Call Out settings.
 */
class joblook_elementor_blog extends Widget_Base {
	/**
	 * Define our get_name settings.
	 */
	public function get_name() {
		return 'joblook-blog';
	}
	/**
	 * Define our get_title settings.
	 */
	public function get_title() {
		return __( 'Blog Posts', 'joblook' );
	}
	/**
	 * Define our get_icon settings.
	 */
	public function get_icon() {
		return 'eicon-call-to-action';
	}
	/**
	 * Define our get_categories settings.
	 */
	public function get_categories() {
		return [ 'joblook-elementor-widget' ];
	}
	/**
	 * Define our _register_controls settings.
	 */
	protected function register_controls()
    {
        /**
         * Info Box Title and Description Section.
         */
        $this->start_controls_section(
            'joblook_blog_section',
            [
                'label' => esc_html__('Blog Options', 'joblook'),
            ]
        );
        $this->add_control(
            'joblook_blog_get_category',
            [
                'label' => __('Select Category', 'joblook'),
                'type' => Controls_Manager::SELECT2,
                'default' => array(),
                'options' => joblook_blog_get_category(),
                'multiple' => true

            ]
        );
        $this->add_control(
            'joblook_blog_post_count',
            [
                'label' => __('No. Of Posts', 'joblook'),
                'type' => Controls_Manager::NUMBER,
                'default' =>3,
            ]
        );

        $this->end_controls_section();

    }
	/**
	 * Define our Content Display inline settings.
	 */
	protected function add_inline_editing_attributes( $key, $toolbar = 'basic' ) {
		if ( ! Plugin::$instance->editor->is_edit_mode() ) {
			return;
		}
		$this->add_render_attribute( $key, [
			'class' => 'elementor-inline-editing',
			'data-elementor-setting-key' => $key,
		] );
		if ( 'basic' !== $toolbar ) {
			$this->add_render_attribute( $key, [
				'data-elementor-inline-editing-toolbar' => $toolbar,
			] );
		}
	}

	/**
	 * Define our Content Display settings.
	 */
	protected function render() {
		$settings = $this->get_settings();
        $taxs = $settings['joblook_blog_get_category'];
        $posts_count = $settings['joblook_blog_post_count'];
        $loop = ($posts_count<=0)?30:$posts_count;
        if($taxs){
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => esc_attr($loop),
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
                'tax_query' =>
                    array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'id',
                            'terms' => $taxs,
                        ),
                    ),
            );
        }
        else{
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => esc_attr($loop),
                'post_status' => 'publish',
                'order' => 'desc',
                'orderby' => 'menu_order date',
            );
        }

        $query = new \WP_Query($args);

         if ($query->have_posts()):
            ?>
            <div class="blog-element">
                        <?php
                        while ($query->have_posts()) : $query->the_post();
                            global $post;
                            $post_format = get_post_format($post->ID);
                            $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                            $image = wp_get_attachment_image_src($post_thumbnail_id, 'joblook-blog-thumbnail-img');
                            $content = get_the_content();
  

                            if (!empty($image)) {
                                $image_style = "style='background-image:url(" . esc_url($image[0]) . ")'";
                            } else {
                                $image_style = '';
                            }

                            if($loop>=1) :
                                ?>
                                <article class="blog-post">
                                    <div class="blog-img">
                                    <img src="<?php echo esc_url($image[0]); ?>" alt="" />

                                    <?php    
                                    $blog_year  = get_the_time('Y');
                                    $blog_month = get_the_time('m');

                                    ?>

                                    <?php echo '<div class="date"><a href="'.esc_url(get_month_link($blog_year,$blog_month)).'"><span>'.esc_html(get_the_date()).'</span></a></div>'; ?>
                                      </div>
                                    <div class="post-content">
                                    <h3 class="entry-title"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>

                                            <?php
                                         
                
                                            
                                            ?>
                                            <p class="post-excerpt"><?php echo wp_kses_post(joblook_get_excerpt(get_the_ID(), 125)); ?></p>
                                        </div>
                                    </article>
                                <?php $loop--; endif; endwhile;
                        wp_reset_postdata(); ?>
                    </div>
        <?php endif;
	}
	
}
/*=============Call this every widget ====================*/
Plugin::instance()->widgets_manager->register_widget_type( new joblook_elementor_blog() );

