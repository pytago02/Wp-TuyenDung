<?php
/**
 * Message to display when access is denied to a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/access-denied-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.37.0
 * @version     1.39.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<p class="job-manager-error"><?php _e( 'Rất tiếc, bạn không có quyền xem danh sách công việc này.', 'wp-job-manager' ); ?></p>
