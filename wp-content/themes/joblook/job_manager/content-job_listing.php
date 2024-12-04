<?php 

/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.0.0
 * @version     1.34.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


global $post;




$term_list = wp_get_post_terms($post->ID, 'job_listing_category', array("fields" => "all"));
$job_related_company =get_post_meta($post->ID,'_company_id', true);
$company_logo = get_post_meta($job_related_company, '_company_logo' , true);
?>

<div <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_long ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_lat ); ?>">

		<div class="job-listing-card">
			<div class="job-data-left">
			<?php if($company_logo) : ?>
				<figure> <img class="company_logo" src="<?php echo $company_logo; ?>"></figure>
			<?php else: ?>
			<figure> <?php the_company_logo(); ?></figure>
			<?php endif; ?>
				<div class="position">
						<a href="<?php the_job_permalink(); ?>">	<h3 class="card-job-title"><?php wpjm_the_job_title(); ?></h3></a>
					<div class="company">
						
						<?php the_company_name( '<h3>', '</h3> ' ); ?>
						<div class="location">
							<svg class="svg-icon" viewBox="0 0 20 20">
								<path d="M10,1.375c-3.17,0-5.75,2.548-5.75,5.682c0,6.685,5.259,11.276,5.483,11.469c0.152,0.132,0.382,0.132,0.534,0c0.224-0.193,5.481-4.784,5.483-11.469C15.75,3.923,13.171,1.375,10,1.375 M10,17.653c-1.064-1.024-4.929-5.127-4.929-10.596c0-2.68,2.212-4.861,4.929-4.861s4.929,2.181,4.929,4.861C14.927,12.518,11.063,16.627,10,17.653 M10,3.839c-1.815,0-3.286,1.47-3.286,3.286s1.47,3.286,3.286,3.286s3.286-1.47,3.286-3.286S11.815,3.839,10,3.839 M10,9.589c-1.359,0-2.464-1.105-2.464-2.464S8.641,4.661,10,4.661s2.464,1.105,2.464,2.464S11.359,9.589,10,9.589"></path>
							</svg><?php the_job_location( false ); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="job-data-right">
				<a href="<?php the_job_permalink(); ?>" class="btn btn-default"><?php _e('Apply Now','joblook'); ?></a>
			</div>
		</div>

		
	

		<div class="job-add-meta">
			<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
				<?php $types = wpjm_get_the_job_types(); ?>
				<?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
					<li class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><svg class="svg-icon" viewBox="0 0 20 20">
							<path d="M16.557,4.467h-1.64v-0.82c0-0.225-0.183-0.41-0.409-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H5.901v-0.82c0-0.225-0.185-0.41-0.41-0.41c-0.226,0-0.41,0.185-0.41,0.41v0.82H3.442c-0.904,0-1.64,0.735-1.64,1.639v9.017c0,0.904,0.736,1.64,1.64,1.64h13.114c0.904,0,1.64-0.735,1.64-1.64V6.106C18.196,5.203,17.461,4.467,16.557,4.467 M17.377,15.123c0,0.453-0.366,0.819-0.82,0.819H3.442c-0.453,0-0.82-0.366-0.82-0.819V8.976h14.754V15.123z M17.377,8.156H2.623V6.106c0-0.453,0.367-0.82,0.82-0.82h1.639v1.23c0,0.225,0.184,0.41,0.41,0.41c0.225,0,0.41-0.185,0.41-0.41v-1.23h8.196v1.23c0,0.225,0.185,0.41,0.41,0.41c0.227,0,0.409-0.185,0.409-0.41v-1.23h1.64c0.454,0,0.82,0.367,0.82,0.82V8.156z"></path>
						</svg><?php echo esc_html( $type->name ); ?></li>
				<?php endforeach; endif; ?>
			<?php } ?>
			
			<div class="job-date"><svg class="svg-icon" viewBox="0 0 20 20">
							<path d="M10.25,2.375c-4.212,0-7.625,3.413-7.625,7.625s3.413,7.625,7.625,7.625s7.625-3.413,7.625-7.625S14.462,2.375,10.25,2.375M10.651,16.811v-0.403c0-0.221-0.181-0.401-0.401-0.401s-0.401,0.181-0.401,0.401v0.403c-3.443-0.201-6.208-2.966-6.409-6.409h0.404c0.22,0,0.401-0.181,0.401-0.401S4.063,9.599,3.843,9.599H3.439C3.64,6.155,6.405,3.391,9.849,3.19v0.403c0,0.22,0.181,0.401,0.401,0.401s0.401-0.181,0.401-0.401V3.19c3.443,0.201,6.208,2.965,6.409,6.409h-0.404c-0.22,0-0.4,0.181-0.4,0.401s0.181,0.401,0.4,0.401h0.404C16.859,13.845,14.095,16.609,10.651,16.811 M12.662,12.412c-0.156,0.156-0.409,0.159-0.568,0l-2.127-2.129C9.986,10.302,9.849,10.192,9.849,10V5.184c0-0.221,0.181-0.401,0.401-0.401s0.401,0.181,0.401,0.401v4.651l2.011,2.008C12.818,12.001,12.818,12.256,12.662,12.412"></path>
						</svg><?php the_job_publish_date(); ?></div>
		
		</div>
		
	
		
			
			<?php do_action( 'job_listing_meta_start' ); ?>

			
			<?php do_action( 'job_listing_meta_end' ); ?>
			

	
</div>



