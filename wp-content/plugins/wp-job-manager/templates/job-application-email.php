<?php
/**
 * Apply by email content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application-email.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php // translators: %1$s is the email address, %2$s is the subject query args. ?>
<p><?php printf( wp_kses_post( __( 'Để ứng tuyển cho công việc này <strong>Gửi email chi tiết của bạn đến</strong> <a class="job_application_email" href="mailto:%1$s%2$s">%1$s</a>', 'wp-job-manager' ) ), esc_html( $apply->email ), '?subject=' . rawurlencode( wp_specialchars_decode( $apply->subject, ENT_QUOTES ) ) ); ?></p>
