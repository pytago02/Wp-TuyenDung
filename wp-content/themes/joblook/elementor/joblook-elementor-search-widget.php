<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Define our Pt Elementor Call Out settings.
 */
class joblook_elementor_job_search extends Widget_Base {
	/**
	 * Define our get_name settings.
	 */
	public function get_name() {
		return 'joblook-job-search';
	}
	/**
	 * Define our get_title settings.
	 */
	public function get_title() {
		return __( 'Job Search Form', 'joblook' );
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



	$check_job_active          = in_array('wp-job-manager/wp-job-manager.php', apply_filters('active_plugins', get_option('active_plugins'))) ? true : false;
                 
                
	if($check_job_active){
        $terms = get_terms( array(
            'taxonomy'   => 'job_listing_category',
            'hide_empty' => false,
        ) );
		$job_regions = get_terms( array(
           'taxonomy' => 'job_listing_region',
           'hide_empty' => false,
         ) );

		$job_region = get_option('job_manager_regions_filter');
		  ?>
		  <div class="banner-filter-wrapper">
			<form  class="form-inline" method="GET" action="<?php echo job_manager_get_permalink( 'jobs' ); ?>">
			
			<div class="banner-search-input-wrap">
			  <div class="form-group">
				<label class="sr-only" for="search_keywords"><?php _e('Job Titles, Keywords, Phrase','joblook'); ?></label>

   <svg class="svg-icon" viewBox="0 0 20 20">
	<path fill="none" d="M7.228,11.464H1.996c-0.723,0-1.308,0.587-1.308,1.309v5.232c0,0.722,0.585,1.308,1.308,1.308h5.232
		c0.723,0,1.308-0.586,1.308-1.308v-5.232C8.536,12.051,7.95,11.464,7.228,11.464z M7.228,17.351c0,0.361-0.293,0.654-0.654,0.654
		H2.649c-0.361,0-0.654-0.293-0.654-0.654v-3.924c0-0.361,0.292-0.654,0.654-0.654h3.924c0.361,0,0.654,0.293,0.654,0.654V17.351z
		 M17.692,11.464H12.46c-0.723,0-1.308,0.587-1.308,1.309v5.232c0,0.722,0.585,1.308,1.308,1.308h5.232
		c0.722,0,1.308-0.586,1.308-1.308v-5.232C19,12.051,18.414,11.464,17.692,11.464z M17.692,17.351c0,0.361-0.293,0.654-0.654,0.654
		h-3.924c-0.361,0-0.654-0.293-0.654-0.654v-3.924c0-0.361,0.293-0.654,0.654-0.654h3.924c0.361,0,0.654,0.293,0.654,0.654V17.351z
		 M7.228,1H1.996C1.273,1,0.688,1.585,0.688,2.308V7.54c0,0.723,0.585,1.308,1.308,1.308h5.232c0.723,0,1.308-0.585,1.308-1.308
		V2.308C8.536,1.585,7.95,1,7.228,1z M7.228,6.886c0,0.361-0.293,0.654-0.654,0.654H2.649c-0.361,0-0.654-0.292-0.654-0.654V2.962
		c0-0.361,0.292-0.654,0.654-0.654h3.924c0.361,0,0.654,0.292,0.654,0.654V6.886z M17.692,1H12.46c-0.723,0-1.308,0.585-1.308,1.308
		V7.54c0,0.723,0.585,1.308,1.308,1.308h5.232C18.414,8.848,19,8.263,19,7.54V2.308C19,1.585,18.414,1,17.692,1z M17.692,6.886
		c0,0.361-0.293,0.654-0.654,0.654h-3.924c-0.361,0-0.654-0.292-0.654-0.654V2.962c0-0.361,0.293-0.654,0.654-0.654h3.924
		c0.361,0,0.654,0.292,0.654,0.654V6.886z"></path>
</svg>
   <input type="text" name="search_keywords" class="form-control" id="search-keywords" placeholder="<?php esc_attr_e( 'Job Titles, Keywords, Phrase', 'joblook' ); ?>">
				
				
				
				
			   
			  </div>


			  <?php 
        
        if ( !empty($terms) && !is_wp_error( $terms ) ) {
            ?>
			  <div class="form-group">
				<label class="sr-only" for="job-category"><?php 
            _e( 'Job Category', 'joblook' );
            ?></label>
				<svg class="svg-icon" viewBox="0 0 20 20">
							<path d="M16.557,4.467h-1.64v-0.82c0-0.225-0.183-0.41-0.409-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H5.901v-0.82c0-0.225-0.185-0.41-0.41-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H3.442c-0.904,0-1.64,0.735-1.64,1.639v9.017c0,0.904,0.736,1.64,1.64,1.64h13.114c0.904,0,1.64-0.735,1.64-1.64V6.106C18.196,5.203,17.461,4.467,16.557,4.467 M17.377,15.123c0,0.453-0.366,0.819-0.82,0.819H3.442c-0.453,0-0.82-0.366-0.82-0.819V8.976h14.754V15.123z M17.377,8.156H2.623V6.106c0-0.453,0.367-0.82,0.82-0.82h1.639v1.23c0,0.225,0.184,0.41,0.41,0.41c0.225,0,0.41-0.185,0.41-0.41v-1.23h8.196v1.23c0,0.225,0.185,0.41,0.41,0.41c0.227,0,0.409-0.185,0.409-0.41v-1.23h1.64c0.454,0,0.82,0.367,0.82,0.82V8.156z"></path>
						</svg>
				<select class="form-control" id="job-category" name="search_category"  >


				  <option><?php 
                _e( 'All Categories', 'joblook' );
                ?></option>

            
            ?>
				 
				 
				  <?php 
            foreach ( $terms as $t ) {
                echo  '<option value="' . $t->term_id . '">' . $t->name . '</option>' ;
            }
            ?>
				</select>
					</div>
			  <?php 
        }
        
        ?>


			  <div class="form-group">
			  
			  <button type="submit" class="btn"><?php _e('Search','joblook'); ?></button>
			  </div>
			  
			</div>
			
 
			</form> 
		  </div>
	 <?php } 

	}
	
}
/*=============Call this every widget ====================*/
Plugin::instance()->widgets_manager->register_widget_type( new joblook_elementor_job_search() );

